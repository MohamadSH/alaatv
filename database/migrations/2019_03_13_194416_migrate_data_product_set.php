<?php

use App\Content;
use App\Contentset;
use App\Product;
use App\Productfile;
use App\Traits\ProductRepository;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class MigrateDataProductSet extends Migration
{
    /**
     * @var ConsoleOutput
     */
    private $output;
    
    /**
     * MigrateDataProductSet constructor.
     *
     */
    public function __construct()
    {
        
        $this->output = new ConsoleOutput();
    }
    
    /**
     * Run the migrations.
     *
     * @return void
     * @throws \Exception
     */
    public function up()
    {
        DB::table('contentset_product')
            ->truncate();
        DB::beginTransaction();
        
        try {
            Schema::table('productfiles', function (Blueprint $table) {
                $table->unsignedInteger('content_id')
                    ->nullable();
                $table->unsignedInteger('contentset_id')
                    ->nullable();
                
                
                $table->foreign('content_id')
                    ->references('id')
                    ->on('educationalcontents')
                    ->onDelete('cascade')
                    ->onupdate('cascade');
                
                $table->foreign('contentset_id')
                    ->references('id')
                    ->on('contentsets')
                    ->onDelete('cascade')
                    ->onupdate('cascade');
                
                
            });
        } catch (Illuminate\Database\QueryException $e) {
        
        }
        DB::commit();
        
        $this->migrateData();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
    
    private function migrateData(): void
    {
        
        $productFiles = Productfile::all();
        $this->output->writeln('update product files....');
        $progress = new ProgressBar($this->output, $productFiles->count());
        
        $productFiles->load('product');
        $productFiles->load('productfiletype');
        foreach ($productFiles->groupBy('product_id') as $productId => $files) {
            
            //get Product
            $product = Product::find($productId);
            
            $this->makeSetForProductFiles($files, $product, function (Contentset $set, Productfile $pFile) {
                $this->attachSetToProducts($set, $pFile->file);
            });
            
            /** @var Productfile $productFile */
            foreach ($files as $productFile) {
                $content = $this->getAssosiatedProductFileContent($productFile, $product);
                $this->setFileForContentBasedOnProductFile($content, $productFile, true);
            }
            $progress->advance();
        }
        $progress->finish();
        $this->output->writeln('Done!');
    }
    
    /**
     * @param            $files
     * @param  Product   $product
     *
     *
     * @param  callable  $callback
     *
     * @return void
     */
    private function makeSetForProductFiles($files, Product $product, callable $callback): void
    {
//        $this->output->writeln('makeSetForProductFiles');
        /** @var Productfile $pFile */
        $pFile = $files->first();
        $set   = $pFile->set;
        
        if (is_null($set)) {
            $set               = Contentset::create([
                'name'  => $product->name,
                'photo' => $product->photo,
                'tags'  => (array) optional($product->tags)->tags,
            ]);
            $set->enable       = 1;
            $set->display      = 1;
            $setSaveResult     = $set->save();
            $pFile->timestamps = false;
            $pFile->set()
                ->associate($set);
            $pFile->timestamps = true;
            $pSaveResult       = $pFile->save();
            if (!($setSaveResult && $pSaveResult)) {
                $this->output->writeln("\r\n"."Error\ ProductFile: ".$pFile->id);
            }
        }
        
        Productfile::whereIn('id', $files->modelKeys())
            ->update(['contentset_id' => $set->id]);
        
        call_user_func($callback, $set, $pFile);
    }
    
    
    /**
     * @param $productFile
     * @param $product
     *
     * @return \App\Content|\App\Content[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    private function getAssosiatedProductFileContent(Productfile $productFile, Product $product)
    {
//        $this->output->writeln('getAssosiatedProductFileContent');
        $set = $productFile->set;
        
        if ($productFile->content_id != null) {
            $content = $productFile->content;
//            $this->output->writeln('product'.$product->id.' \forceFill: '.$productFile->contentset_id.'productFile:'.$productFile->id);
            $this->assosiateSetToContent($content, $set);
            return $content;
        }
        //make content for each productFiles
        $productTypeContentTypeLookupTable     = [
            '1' => Content::CONTENT_TYPE_PAMPHLET,
            '2' => Content::CONTENT_TYPE_VIDEO,
        ];
        $productTypeContentTemplateLookupTable = [
            '1' => Content::CONTENT_TEMPLATE_PAMPHLET,
            '2' => Content::CONTENT_TEMPLATE_VIDEO,
        ];
        $content                               = Content::create([
            'name'            => $productFile->name,
            'description'     => (isset($productFile) && strlen($productFile->description) > 1 ? $productFile->description : null),
            'context'         => null,
            'file'            => null,
            'order'           => $productFile->order,
            'validSince'      => $productFile->validSince,
            'metaTitle'       => null,
            'metaDescription' => null,
            'metaKeywords'    => null,
            'tags'            => (array) optional($product->tags)->tags,
            'author_id'       => null,
            'template_id'     => $productTypeContentTemplateLookupTable[$productFile->productfiletype_id],
            'contenttype_id'  => $productTypeContentTypeLookupTable[$productFile->productfiletype_id],
            'isFree'          => false,
            'enable'          => $productFile->enable,
        ]);
        $content->forceFill([
            'created_at' => $productFile->created_at,
            'updated_at' => $productFile->updated_at,
        ])
            ->save();
        $this->assosiateSetToContent($content, $set);
        $productFile->timestamps = false;
        $productFile->content_id = $content->id;
        $productFile->update();
        $productFile->timestamps = true;
        return $content;
        
    }
    
    /**
     * @param        $content
     * @param        $productFile
     * @param  bool  $force
     */
    private function setFileForContentBasedOnProductFile(Content &$content, Productfile $productFile, $force = false): void
    {
//        $this->output->writeln('\r\n setFileForContentBasedOnProductFile');
        //make content for each productFiles
        $productTypeContentTypeLookupTable = [
            '1' => "pamphlet",
            '2' => "video",
        ];
        
        if (is_null($content->file) || $force) {
            $files = collect();
            $url   = $productFile->cloudFile ?? $productFile->file;
            $files->push([
                "uuid"     => null,
                "disk"     => "productFileSFTP",
                "url"      => null,
                "fileName" => parse_url($url)['path'],
                "size"     => null,
                "caption"  => $productFile->productfiletype_id == 2 ? 'کیفیت بالا' : 'جزوه',
                "res"      => $productFile->productfiletype_id == 2 ? "480p" : null,
                "type"     => $productTypeContentTypeLookupTable[$productFile->productfiletype_id],
                "ext"      => pathinfo(parse_url($url)['path'], PATHINFO_EXTENSION),
            ]);
            $content->timestamps = false;
            $content->file       = $files;
            $content->update();
            $content->timestamps = true;
        }
    }
    
    /**
     * @param  \App\Contentset  $set
     * @param  string           $fileName
     */
    private function attachSetToProducts(Contentset $set, string $fileName): void
    {
//        $this->output->writeln('attachSetToProducts');
        $products = ProductRepository::getProductsThatHaveValidProductFileByFileNameRecursively($fileName);
        $this->output->writeln('  -Count(products):'.$products->count());
        
        foreach ($products as $product) {
            $product->sets()
                ->attach($set, ['order' => $set->id]);
        }
    }
    
    /**
     * @param  Content|null     $content
     * @param  Contentset|null  $set
     */
    private function assosiateSetToContent(?Content $content, ?Contentset $set): void
    {
        $content->set()
            ->associate($set)
            ->save();
    }
}
