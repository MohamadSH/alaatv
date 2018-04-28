<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
 
 
Auth::routes();

Route::get('c',"HomeController@search");
Route::get('embed/c/{educationalcontent}',"EducationalContentController@embed");
Route::get( '/' , 'HomeController@index');
Route::get( 'home' , 'HomeController@home');
Route::get('404', 'HomeController@error404');
Route::get('403', 'HomeController@error403');
Route::get('500', 'HomeController@error500');
Route::get('error', 'HomeController@errorPage');
Route::get('download', "HomeController@download");
Route::get('aboutUs', 'HomeController@aboutUs');
Route::get('contactUs', 'HomeController@contactUs');
Route::get('rules', 'HomeController@rules');
Route::get('articleList', 'ArticleController@showList');
Route::get('sitemap.xml', 'HomeController@siteMapXML');

Route::resource('article', 'ArticleController');
Route::group(['middleware' => 'auth'], function()
{
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    //todo : combining these two routes

    Route::get('/usersAdmin', 'HomeController@admin');
    Route::get('/consultantPanel', 'HomeController@consultantAdmin');
    Route::get('/consultantEntekhabReshtePanel', 'HomeController@consultantEntekhabReshte');
    Route::get('/consultantEntekhabReshteList', 'HomeController@consultantEntekhabReshteList');
    Route::post('/consultantStoreEntekhabReshte', 'HomeController@consultantStoreEntekhabReshte');
    Route::get('/productAdmin', 'HomeController@adminProduct');
    Route::get('/contentAdmin', 'HomeController@adminContent');
    Route::get('/ordersAdmin', 'HomeController@adminOrder');
    Route::get('/smsAdmin', 'HomeController@adminSMS');
    Route::get('/siteConfigAdmin', 'HomeController@adminSiteConfig');
    Route::get('/slideShowAdmin', 'HomeController@adminSlideShow');
    Route::get('/report', 'HomeController@adminReport');
//    Route::get('articleSlideShowAdmin', 'HomeController@adminArticleSlideShow');
    Route::get('/majorAdminPanel', 'HomeController@adminMajor');
    Route::get('/lotteryAdminPanel', 'HomeController@adminLottery');
    Route::post('/adminSendSMS' , 'HomeController@sendSMS');


    Route::get('/asset', 'UserController@userProductFiles');
    Route::get('/user/info', "UserController@informationPublicUrl");
    Route::get('/user/{user}/info', 'UserController@information');
    Route::post('/user/{user}/completeInfo', 'UserController@completeInformation');
//    Route::get('myAsset', 'UserController@showBelongings');
    Route::get('/profile', 'UserController@showProfile');
    Route::get('/complete-register', 'UserController@completeRegister');
    Route::put('user/updateProfile', 'UserController@updateProfile');
    Route::put('user/updatePhoto' , 'UserController@updatePhoto');
    Route::put('user/updatePassword' , 'UserController@updatePassword');
    Route::get('user/orders' , 'UserController@userOrders');
    Route::get('user/question' , 'UserController@uploads');
    Route::get('user/getVerificationCode' , 'UserController@sendVerificationCode');
    Route::post('user/verifyAccount' , 'UserController@submitVerificationCode');
    Route::post('user/sendSMS' , 'UserController@sendSMS');
    Route::get('/survey' , 'UserController@showSurvey');
    Route::get('/96' , 'UserController@submitKonkurResult');
    Route::post('user/submitWorkTime' , 'UserController@submitWorkTime');
    Route::post('user/removeFromLottery' , 'UserController@removeFromLottery');
    Route::resource('user', 'UserController');


    Route::resource('userbon', 'UserbonController');

    Route::resource('assignment', 'AssignmentController');
    Route::resource('consultation', 'ConsultationController');

    Route::post("transactionToDonate/{transaction}" , "TransactionController@convertToDonate");
    Route::post("completeTransaction/{transaction}" , "TransactionController@completeTransaction");
    Route::post("myTransaction/{transaction}" , "TransactionController@limitedUpdate");
    Route::resource('transaction', 'TransactionController');
    Route::get('getUnverifiedTransactions', 'TransactionController@getUnverifiedTransactions');
    Route::any('/paymentRedirect' , 'TransactionController@paymentRedirect');

    Route::get('exitAdminInsertOrder' , 'OrderController@exitAdminInsertOrder');
    Route::post('exchangeOrderproduct/{order}' , 'OrderController@exchangeOrderproduct');
    Route::resource('order', 'OrderController');

    Route::post('order/detachorderproduct' , 'OrderController@detachOrderproduct');
    Route::post('order/addOrderproduct/{product}', "OrderController@addOrderproduct");
    Route::delete('order/removeOrderproduct/{product}', "OrderController@removeOrderproduct");
    Route::post('order/submitCoupon', "OrderController@submitCoupon");
    Route::get('orderRemoveCoupon', "OrderController@removeCoupon");

    Route::resource('permission', 'PermissionController');

    Route::resource('role', 'RoleController');

    Route::resource('coupon', 'CouponController');

    Route::get('product/{product}/live' , 'ProductController@showLive');
    Route::put('product/addComplimentary/{product}' , 'ProductController@addComplimentary');
    Route::put('product/removeComplimentary/{product}' , 'ProductController@removeComplimentary');
    Route::get('product/{product}/createConfiguration' , 'ProductController@createConfiguration');
    Route::post('product/{product}/makeConfiguration' , 'ProductController@makeConfiguration');
    Route::get('product/{product}/editAttributevalues' , 'ProductController@editAttributevalues');
    Route::post('product/{product}/updateAttributevalues' , 'ProductController@updateAttributevalues');
    Route::put('product/child/{product}' , 'ProductController@childProductEnable');
    Route::put('product/{product}/addGift' , 'ProductController@addGift');
    Route::delete('product/{product}/removeGift' , 'ProductController@removeGift');
    Route::post('product/{product}/copy' , 'ProductController@copy');

    Route::resource('attributevalue', 'AttributevalueController');
    Route::resource('attribute', 'AttributeController');
    Route::resource('attributeset', 'AttributesetController');
    Route::resource('attributegroup', 'AttributegroupController');

    Route::resource('userupload', 'UseruploadController');
    Route::group(['middleware' => ['completeInfo']], function () {
        Route::get('uploadQuestion', 'UserController@uploadConsultingQuestion');
    });

    Route::resource('verificationmessage', 'VerificationmessageController');

    Route::resource('contact', 'ContactController');
    Route::resource('phone', 'PhoneController');
    Route::resource('afterloginformcontrol' , 'AfterLoginFormController');

    Route::resource('articlecategory', 'ArticlecategoryController');

//    Route::resource('belonging' , 'BelongingController');
    Route::resource('websiteSetting', 'WebsiteSettingController');
    Route::resource('productfile', 'ProductfileController');
    Route::resource('major' , 'MajorController');
    Route::resource('usersurveyanwser' , "UserSurveyAnswerController");
    Route::resource('eventresult' , "EventresultController");
    Route::resource('productphoto' , "ProductphotoController");

    Route::get('MBTI-Participation' , "MbtianswerController@create");
    Route::get('MBTI-Introduction' , "MbtianswerController@introduction");
    Route::resource('mbtianswer' , "MbtianswerController");

    Route::resource('slideshow' , "SlideShowController");
    Route::resource('city' , 'CityController');

    Route::resource('file' , 'FileController') ;
    Route::post('/storeContentFileCaption/{c}/{file}' , 'EducationalContentController@storeFileCaption');
    Route::post('/detachContentFile/{c}/{file}' , 'EducationalContentController@detachFile');

    Route::resource('employeetimesheet' , 'EmployeetimesheetController') ;
    Route::get('dolottery' , "LotteryController@holdLottery");
    Route::get('givePrize', "LotteryController@givePrizes");
    Route::resource('lottery' , 'LotteryController') ;
    Route::get('smsbot' , "HomeController@smsBot");

    Route::get("bot" , "HomeController@bot");


});
Route::post('user/getPassword' , 'UserController@sendGeneratedPassword');

Route::group(['prefix' => 'checkout'], function () {
//    Route::get('invoice' , 'OrderController@checkoutInvoice');
    Route::get('auth', "OrderController@checkoutAuth");
    Route::get('completeInfo' , 'OrderController@checkoutCompleteInfo') ;
    Route::group(['middleware' => ['completeInfo']], function () {
        Route::get('review', "OrderController@checkoutReview");
        Route::get('payment', "OrderController@checkoutPayment");
    });
    Route::get('successfulPayment' , "OrderController@successfulPayment");
    Route::get('failedPayment' , "OrderController@failedPayment");
    Route::get('returnFromPayment' , "OrderController@otherPayment");
    Route::any('verifyPayment', "OrderController@verifyPayment");
});

Route::post('sendMail', 'HomeController@sendMail');

Route::get('product/search', 'ProductController@search');
Route::resource('product', 'ProductController');
Route::get('showPartial/{product}' , 'ProductController@showPartial');
Route::post('refreshPrice/{product}' , 'ProductController@refreshPrice');

Route::group(['prefix' => 'orderproduct'], function () {
    Route::post('checkout' , 'OrderproductController@checkOutOrderproducts') ;
});
Route::resource('orderproduct', 'OrderproductController');

Route::get('image/{category}/{w}/{h}/{filename}', [
    'as'   => 'image',
    'uses' => 'HomeController@getImage',
]);

Route::resource('c', 'EducationalContentController', [
    'except' => [
        'index'
    ]
]);

Route::group(['prefix' => 'content'], function () {
    Route::get('/' , 'EducationalContentController@index');
    Route::get('search', 'EducationalContentController@search');
    Route::get('create2', 'EducationalContentController@create2');
});

Route::group(['prefix' => 'landing'], function () {
    Route::get('1' , 'ProductController@landing1') ;
    Route::get('2' , 'ProductController@landing2') ;
});

/**
 *  SANATI SHARIF SYNC
 */
Route::resource( "sanatisharifmerge" , "SanatisharifmergeController");
Route::get( "copylessonfromremote" , "RemoteDataCopyController@copyLesson");
Route::get( "copydepartmentfromremote" , "RemoteDataCopyController@copyDepartment");
Route::get( "copydepartmentlessonfromremote" , "RemoteDataCopyController@copyDepartmentlesson");
Route::get( "copyvideofromremote" , "RemoteDataCopyController@copyVideo");
Route::get( "copypamphletfromremote" , "RemoteDataCopyController@copyPamphlet");
Route::get( "copydepartmentlessontotakhtekhak" , "SanatisharifmergeController@copyDepartmentlesson");
Route::get( "copycontenttotakhtekhak" , "SanatisharifmergeController@copyContent");
Route::get("ctag" , "EducationalContentController@retrieveTags");
ROute::get("tagbot", "HomeController@tagbot");
Route::get("debug", 'HomeController@debug');

Route::get('Sanati-Sharif-Lesson/{lId?}/{dId?}','SanatisharifmergeController@redirectLesson');
Route::get('Sanati-Sharif-Video/{lId?}/{dId?}/{vId?}','SanatisharifmergeController@redirectVideo');
Route::get('SanatiSharif-Video/{lId?}/{dId?}/{vId?}','SanatisharifmergeController@redirectEmbedVideo');
Route::get('Sanati-Sharif-Pamphlet/{lId?}/{dId?}/{pId?}','SanatisharifmergeController@redirectPamphlet');
Route::get('SanatiSharif-News', 'HomeController@home');


//Route::get('certificates', 'HomeController@certificates');
//Route::get('findTech', "UserController@findTech");

Route::get('Alaa-App/{mod?}','SanatisharifmergeController@AlaaApp');