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

        'pamphlet' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/content/pamphlet'),
            'visibility' => 'public',
        ],

        'book' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/content/book'),
            'visibility' => 'public',
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



        'productImageSFTP'     => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => env('SFTP_ROOT', ''),
            'prefix'     => '/upload/images/product',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'dHost'      => env('CDN_SERVER_NAME', ''),
            'dProtocol'  => env('DOWNLOAD_SERVER_PROTOCOL', 'http://'),
        ],

        'homeSlideShowPicSFTP'     => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => env('SFTP_ROOT', ''),
            'prefix'     => '/upload/images/slideShow',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'dHost'      => env('CDN_SERVER_NAME', ''),
            'dProtocol'  => env('DOWNLOAD_SERVER_PROTOCOL', 'http://'),
        ],

        'productFileSFTP' => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => env('SFTP_ROOT', '').'/paid',
            'prefix'     => null,
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'dHost'      => env('PAID_SERVER_NAME',null),
            'dProtocol'  => env('DOWNLOAD_SERVER_PROTOCOL', 'http://'),
        ],

        'setImageSFTP'     => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => env('SFTP_ROOT', ''),
            'prefix'       => '/upload/contentset/departmentlesson',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'dHost'      => env('CDN_SERVER_NAME', ''),
            'dProtocol'  => env('DOWNLOAD_SERVER_PROTOCOL', 'http://'),
        ],

        'alaaCdnSFTP'     => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => env('SFTP_ROOT', ''),
            'prefix'     => null,
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'dHost'      => env('CDN_SERVER_NAME', ''),
            'dProtocol'  => env('DOWNLOAD_SERVER_PROTOCOL', 'http://'),
        ],

        'pamphletSftp' => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => env('SFTP_ROOT', '').'/paid',
            'prefix'     => '/public/c/pamphlet/',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'dHost'      => env('PAID_SERVER_NAME',null),
            'dProtocol'  => env('DOWNLOAD_SERVER_PROTOCOL', 'http://'),
        ],

        'examSftp' => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => env('SFTP_ROOT', '').'/paid',
            'prefix'     => '/public/c/exam/',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'dHost'      => env('PAID_SERVER_NAME',null),
            'dProtocol'  => env('DOWNLOAD_SERVER_PROTOCOL', 'http://'),
        ],

        'bookSftp' => [
            'driver'     => 'sftp',
            'host'       => env('SFTP_HOST2', ''),
            'port'       => env('SFTP_PORT', '22'),
            'username'   => env('SFTP_USERNAME', ''),
            'password'   => env('SFTP_PASSWORD', ''),
            'privateKey' => env('SFTP_PRIVATE_KEY_PATH', ''),
            'root'       => env('SFTP_ROOT', '').'/paid',
            'prefix'     => '/public/c/book/',
            'timeout'    => env('SFTP_TIMEOUT', '10'),
            'dHost'      => env('PAID_SERVER_NAME',null),
            'dProtocol'  => env('DOWNLOAD_SERVER_PROTOCOL', 'http://'),
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
