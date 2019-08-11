<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */


    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root'   => storage_path('app'),
        ],

        'public' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'url'        => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'profileImage' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/profile/images'),
            'visibility' => 'public',

            /*            'driver'     => 'sftp',
                        'host'       => env('SFTP_HOST2', ''),
                        'port'       => env('SFTP_PORT', '22'),
                        'username'   => env('SFTP_USERNAME', ''),
                        'password'   => env('SFTP_PASSSWORD', ''),
                        'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
                        'root'       => env('SFTP_ROOT', '').'/public/c/pamphlet/',
                        'timeout'    => env('SFTP_TIMEOUT', '10'),*/
        ],

        'assignmentQuestionFile' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/assignment/questionFiles'),
            'visibility' => 'public',
        ],

        'assignmentSolutionFile' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/assignment/solutionFiles'),
            'visibility' => 'public',
        ],

        'productImage' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/product/images'),
            'visibility' => 'public',
        ],

        'productImageSFTP'     => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => '/cdn/upload/images/product',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'prefix'     => null,
            'dHost'      => "cdn.alaatv.com",
            'dProtocol'  => "https://",
        ],

        'productCatalog_PDF' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/product/catalog/pdf'),
            'visibility' => 'public',
        ],

        'consultingAudioQuestions' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/userUploads/consultingAudioQuestions'),
            'visibility' => 'public',
        ],

        'consultationThumbnail' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/consultation/thumbnails'),
            'visibility' => 'public',
        ],
        'articleImage'          => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/article/images'),
            'visibility' => 'public',
        ],

        'homeSlideShowPic' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/slideShow/home'),
            'visibility' => 'public',
        ],

        'homeSlideShowPicSFTP'     => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => '/cdn/upload/images/slideShow',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'prefix'     => null,
            'dHost'      => "cdn.alaatv.com",
            'dProtocol'  => "https://",
        ],

        //        'articleSlideShowPic' => [
        //            'driver' => 'local',
        //            'root'   => storage_path('app/public/slideShow/article'),
        //            'visibility' => 'public',
        //        ],

        'orderFile' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/orderFiles'),
            'visibility' => 'public',
        ],

        'general' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/general'),
            'visibility' => 'public',
        ],

        'productFile'     => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/product/files'),
            'visibility' => 'public',
        ],

        'productFileSFTP' => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => '/cdn/paid',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'prefix'     => null,
            'dHost'      => "paid.alaatv.com",
            'dProtocol'  => "https://",
        ],

        'setImageSFTP'     => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => '/cdn/upload/contentset/departmentlesson',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'prefix'     => null,
            'dHost'      => "cdn.alaatv.com",
            'dProtocol'  => "https://",
        ],

        'alaaCdnSFTP'     => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => '/cdn/',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'prefix'     => null,
            'dHost'      => "cdn.alaatv.com",
            'dProtocol'  => "https://",
        ],

        'eventReport' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/event/userReports'),
            'visibility' => 'public',
        ],

        'entekhabReshte' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/entekhabReshte'),
            'visibility' => 'public',
        ],

        'exam' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/educationalContent/exam'),
            'visibility' => 'public',
        ],

        'examSftp' => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => '/cdn/public/c/exam/',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'prefix'     => '/public/c/exam/',
            'dHost'      => "dl.alaatv.com/",
            'dProtocol'  => "https://",
        ],


        'pamphlet' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/content/pamphlet'),
            'visibility' => 'public',
        ],

        'pamphletSftp' => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => '/cdn/paid/public/c/pamphlet/',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'dHost'     => 'paid.alaatv.com',
            'dProtocol' => 'https://',
            'prefix'    => '/public/c/pamphlet/',

        ],

        'pamphletSftp2' => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => '/cdn/paid/public/c/pamphlet/',
            'timeout'    => env('SFTP_TIMEOUT', '10'),

            'dHost'     => 'paid.alaatv.com',
            'dProtocol' => 'https://',
            'prefix'    => '/public/c/pamphlet/',

        ],

        'book' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/content/book'),
            'visibility' => 'public',
        ],

        'bookSftp' => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => env('SFTP_ROOT', ''),
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'prefix'     => '/cdn/paid/public/c/book/',
            'dHost'      => "dl.alaatv.com/",
            'dProtocol'  => "https://",
        ],

        'digitalSignatureCertificates' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/digitalSignatures/certificates'),
            'visibility' => 'public',
        ],

        'digitalSignatures' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/digitalSignatures/signatures'),
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key'    => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url'    => env('AWS_URL'),
        ],

    ],

];
