<?php

use App\Content;
use App\Contentset;
use App\Product;
use App\Productfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class MigrateDataProductSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws \Exception
     */
    public function up()
    {
        DB::beginTransaction();

        try{
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
        }catch (Illuminate\Database\QueryException $e) {

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
        $output = new ConsoleOutput();
        $output->writeln('update product files....');
        $progress = new ProgressBar($output, $productFiles->count());

        $productFiles->load('product');
        $productFiles->load('productfiletype');
        foreach ($productFiles->groupBy('product_id') as $productId => $files) {

            //get Product
            $product = $files->first()->product;
            $this->makeSetForProductFiles($files, $product);

            /** @var Productfile $productFile */
            foreach ($files as $productFile) {

                $content = $this->getAssosiatedProductFileContent($productFile, $product);
                $this->setFileForContentBasedOnProductFile($content, $productFile, true);
            }
            $progress->advance();
        }
        $progress->finish();
        $output->writeln('Done!');
    }

    /**
     * @param $files
     * @param $product
     */
    private function makeSetForProductFiles($files, Product $product): void
    {
        $contentSetId = $files->first()->contentset_id;
        if ($contentSetId == null) {

            //make a set from Product
            $set = Contentset::create([
                'name'  => $product->name,
                'photo' => $product->photo,
                'tags'  => (array)optional($product->tags)->tags,
            ]);
            $set->enable = 1;
            $set->display = 1;
            $set->save();
        }
        $set = Contentset::find($contentSetId);
        Productfile::whereIn('id', $files->modelKeys())->update(['contentset_id' => $set->id]);
        $product->sets()->attach($set,['order'=>$set->id]);
    }


    /**
     * @param $productFile
     * @param $product
     *
     * @return \App\Content|\App\Content[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    private function getAssosiatedProductFileContent(Productfile $productFile,Product $product)
    {
        if ($productFile->content_id != null) {
            return Content::find($productFile->content_id);
        }
        //make content for each productFiles
        $productTypeContentTypeLookupTable = [
            '1' => Content::CONTENT_TYPE_PAMPHLET,
            '2' => Content::CONTENT_TYPE_VIDEO,
        ];
        $productTypeContentTemplateLookupTable = [
            '1' => Content::CONTENT_TEMPLATE_PAMPHLET,
            '2' => Content::CONTENT_TEMPLATE_VIDEO,
        ];
        $content = Content::create([
            'name'            => $productFile->name,
            'description'     => (isset($productFile) && strlen($productFile->description) > 1 ? $productFile->description : null),
            'context'         => null,
            'order'           => $productFile->order,
            'validSince'      => $productFile->validSince,
            'metaTitle'       => null,
            'metaDescription' => null,
            'metaKeywords'    => null,
            'tags'            => (array)optional($product->tags)->tags,
            'author_id'       => null,
            'contenttype_id'  => $productTypeContentTypeLookupTable[$productFile->productfiletype_id],
            'template_id'     => $productTypeContentTemplateLookupTable[$productFile->productfiletype_id],
            'contentset_id'   => $productFile->contentset_id,
            'isFree'          => false,
            'enable'          => $productFile->enable,
        ]);
        $content->forceFill([
            'created_at' => $productFile->created_at,
            'updated_at' => $productFile->updated_at,
        ])->save();
        $productFile->timestamps = false;
        $productFile->content_id = $content->id;
        $productFile->update();
        $productFile->timestamps = true;
        return $content;

    }

    /**
     * @param      $content
     * @param      $productFile
     * @param bool $force
     */
    private function setFileForContentBasedOnProductFile(Content &$content,Productfile $productFile, $force = false): void
    {
        //make content for each productFiles
        $productTypeContentTypeLookupTable = [
            '1' => "pamphlet",
            '2' => "video",
        ];

        if (is_null($content->file) || $force) {
            $files = collect();
            $url = $productFile->cloudFile ?? $productFile->file;
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
            $content->file = $files;
            $content->update();
            $content->timestamps = true;
        }
    }
}
