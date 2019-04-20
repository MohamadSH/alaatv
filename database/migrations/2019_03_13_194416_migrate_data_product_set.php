<?php

use App\Content;
use App\Contentset;
use App\Productfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
        /*
         *
        $productFiles = \App\Productfile::all();
        $output = new ConsoleOutput();
        $output->writeln('update product files....');
        $progress = new ProgressBar($output, $productFiles->count());

        $productFiles->load('product');
        $productFiles->load('productfiletype');

        foreach ($productFiles as $productFile) {
//            $productFile->timestamps = false;
//
//            $contentId = $this->makeContentFromProductFile($productFile);
//
//            $productFile->forceFill([
//                'content_id' => $contentId,
//            ])->save();
//
//            $productFile->timestamps = true;

            $progress->advance();
        }
        $progress->finish();
        $output->writeln('Done!');

        */

        DB::commit();
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

    private function makeContentFromProductFile(\App\Productfile &$productFile): int
    {

    }

    private function temp()
    {
        $productFiles = \App\Productfile::all();
        $productFiles->load('product');
        $productFiles->load('productfiletype');
        foreach ($productFiles->groupBy('product_id') as $productId => $files) {

            //get Product
            $product = $files->first()->product;

            //make a set from Product
            $set = Contentset::create([
                'name'  => $product->name,
                'photo' => $product->photo,
                'tags'  => $product->tags->tags,
            ]);
            $set->enable = 1;
            $set->display = 1;
            $set->save();

            //make content for each productFiles
            $productTypeContentTypeLookupTable = [
                '1' => Content::CONTENT_TYPE_PAMPHLET,
                '2' => Content::CONTENT_TYPE_VIDEO,
            ];
            $productTypeContentTemplateLookupTable = [
                '1' => Content::CONTENT_TEMPLATE_PAMPHLET,
                '2' => Content::CONTENT_TEMPLATE_VIDEO,
            ];
            /** @var Productfile $productFile */
            foreach ($files as $productFile) {
                //TODO://Fill file!
                $content = Content::create([
                    'name'            => $productFile->name,
                    'description'     => (isset($productFile) && strlen($productFile->description) > 1 ? $productFile->description : null),
                    'context'         => null,
                    'file'            => '',
                    'order'           => $productFile->order,
                    'validSince'      => $productFile->validSince,
                    'metaTitle'       => null,
                    'metaDescription' => null,
                    'metaKeywords'    => null,
                    'tags'            => $product->tags->tags,
                    'author_id'       => null,
                    'contenttype_id'  => $productTypeContentTypeLookupTable[$productFile->productfiletype_id],
                    'template_id'     => $productTypeContentTemplateLookupTable[$productFile->productfiletype_id],
                    'contentset_id'   => $set->id,
                    'isFree'          => false,
                    'enable'          => $productFile->enable,
                ]);
                $content->timestamps = false;
                $content->forceFill([
                    'created_at' => $productFile->created_at,
                    'updated_at' => $productFile->updated_at,
                ])->save();
                $content->timestamps = true;
                break;
            }
            break;
        }
        dd(".");
    }
}
