<?php

use App\Product;
use App\Traits\ProductCommon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AlterProductsChangeThumbnail extends Migration
{
    use ProductCommon;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('intro_videos')->nullable()->comment('کلیپ های معرفی محصول')->after('introVideo');
        });

        $products = Product::whereNotNull('introVideo')->get();

        $output = new ConsoleOutput();
        $output->writeln('update products intro videos....');
        $progress = new ProgressBar($output, $products->count());
        foreach ($products as $product){
            $videoUrl = $product->introVideo;

            if(is_null($videoUrl))
                continue;

            $output->writeln('updating product: '.$product->id);


            $videoPathSplit = explode( '/upload' , $videoUrl);
            $videoPath = $videoPathSplit[1];

            $newVideoUrl =  'https://cdn.sanatisharif.ir/upload/introVideos'.$videoPath;
            $newVideoPath = parse_url($newVideoUrl)['path'];
            $videoExtension = pathinfo($newVideoPath, PATHINFO_EXTENSION);
            $videoFileName = basename($newVideoPath);
            $videoFileNameWithoutExtension = explode('.', $videoFileName)[0];
            $introVideos = collect();
            $video = [
                $this->makeIntroVideoFileStdClass(config('constants.DISK_FREE_CONTENT'), $newVideoUrl, $newVideoPath, $videoExtension, null, 'کیفیت بالا', '480p')
            ];

            $thumbnailUrl = 'https://cdn.sanatisharif.ir/upload/introVideos/thumbnails/'.$videoFileNameWithoutExtension.'.jpg';
            $thumbnailPath = $videoFileNameWithoutExtension.'.jpg';
            $thumbnail =$this->makeVideoFileThumbnailStdClass(config('constants.DISK_FREE_CONTENT'), $thumbnailUrl, $thumbnailPath, 'jpg');

            $introVideos->push([
                'url'       =>  $video,
                'thumbnail' =>  $thumbnail,
            ]);

            $product->intro_videos = $introVideos;
            $product->update();
            $progress->advance();
        }
        $progress->finish();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'intro_videos')) {
                $table->dropColumn('intro_videos');
            }
        });
    }
}
