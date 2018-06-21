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
Route::get("debug", 'HomeController@debug');
Route::post('sendMail', 'HomeController@sendMail');
Route::post('user/getPassword' , 'UserController@sendGeneratedPassword');
Route::get('product/search', 'ProductController@search');
Route::get('showPartial/{product}' , 'ProductController@showPartial');
Route::post('refreshPrice/{product}' , 'ProductController@refreshPrice');
Route::get("ctag" , "EducationalContentController@retrieveTags");
Route::get('Sanati-Sharif-Lesson/{lId?}/{dId?}','SanatisharifmergeController@redirectLesson');
Route::get('Sanati-Sharif-Video/{lId?}/{dId?}/{vId?}','SanatisharifmergeController@redirectVideo');
Route::get('SanatiSharif-Video/{lId?}/{dId?}/{vId?}','SanatisharifmergeController@redirectEmbedVideo');
Route::get('Sanati-Sharif-Pamphlet/{lId?}/{dId?}/{pId?}','SanatisharifmergeController@redirectPamphlet');
Route::get('SanatiSharif-News', 'HomeController@home');
Route::get('Alaa-App/{mod?}','SanatisharifmergeController@AlaaApp');
Route::get('image/{category}/{w}/{h}/{filename}', [
    'as'   => 'image',
    'uses' => 'HomeController@getImage',
]);
Route::get("sharif" , "HomeController@schoolRegisterLanding");
Route::post("registerForSanatiSharifHighSchool" , "UserController@registerForSanatiSharifHighSchool");

Route::group(['prefix' => 'checkout'], function () {
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
Route::group(['prefix' => 'orderproduct'], function () {
    Route::post('checkout' , 'OrderproductController@checkOutOrderproducts') ;
});
Route::group(['prefix' => 'content'], function () {
    Route::get('/' , 'EducationalContentController@index');
    Route::get('search', 'EducationalContentController@search');
    Route::get('create2', 'EducationalContentController@create2');
    Route::get('create3', 'EducationalContentController@create3');
});
Route::post('basicStore' , 'EducationalContentController@basicStore') ;

Route::group(['prefix' => 'landing'], function () {
    Route::get('1' , 'ProductController@landing1') ;
    Route::get('2' , 'ProductController@landing2') ;
    Route::get('3' , ['as'=>'landing.3', 'uses' => 'ProductController@landing3']) ;
    Route::get('4' , 'ProductController@landing4') ;
});
Route::group(['middleware' => 'auth'], function()
{

    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::get('usersAdmin', 'HomeController@admin');
    Route::get('consultantPanel', 'HomeController@consultantAdmin');
    Route::get('consultantEntekhabReshtePanel', 'HomeController@consultantEntekhabReshte');
    Route::get('consultantEntekhabReshteList', 'HomeController@consultantEntekhabReshteList');
    Route::post('consultantStoreEntekhabReshte', 'HomeController@consultantStoreEntekhabReshte');
    Route::get('productAdmin', 'HomeController@adminProduct');
    Route::get('contentAdmin', 'HomeController@adminContent');
    Route::get('ordersAdmin', 'HomeController@adminOrder');
    Route::get('smsAdmin', 'HomeController@adminSMS');
    Route::get('botAdmin', 'HomeController@adminBot');
    Route::get('siteConfigAdmin', 'HomeController@adminSiteConfig');
    Route::get('slideShowAdmin', 'HomeController@adminSlideShow');
    Route::get('report', 'HomeController@adminReport');
    Route::get('majorAdminPanel', 'HomeController@adminMajor');
    Route::get('lotteryAdminPanel', 'HomeController@adminLottery');
    Route::get('teleMarketingAdminPanel', 'HomeController@adminTeleMarketing');
    Route::post('adminSendSMS' , 'HomeController@sendSMS');
    Route::get('asset', 'UserController@userProductFiles');
    Route::get('profile', 'UserController@showProfile');
    Route::get('complete-register', 'UserController@completeRegister');
    Route::get('survey' , 'UserController@showSurvey');
    Route::get('96' , 'HomeController@submitKonkurResult');
    Route::post("transactionToDonate/{transaction}" , "TransactionController@convertToDonate");
    Route::post("completeTransaction/{transaction}" , "TransactionController@completeTransaction");
    Route::post("myTransaction/{transaction}" , "TransactionController@limitedUpdate");
    Route::get('getUnverifiedTransactions', 'TransactionController@getUnverifiedTransactions');
    Route::any('paymentRedirect' , 'TransactionController@paymentRedirect');
    Route::get('exitAdminInsertOrder' , 'OrderController@exitAdminInsertOrder');
    Route::post('exchangeOrderproduct/{order}' , 'OrderController@exchangeOrderproduct');
    Route::get('MBTI-Participation' , "MbtianswerController@create");
    Route::get('MBTI-Introduction' , "MbtianswerController@introduction");
    Route::post('storeContentFileCaption/{c}/{file}' , 'EducationalContentController@storeFileCaption');
    Route::post('detachContentFile/{c}/{file}' , 'EducationalContentController@detachFile');
    Route::get('holdlottery' , "LotteryController@holdLottery");
    Route::get('givePrize', "LotteryController@givePrizes");
    Route::get('smsbot' , "HomeController@smsBot");
    Route::get("bot" , "HomeController@bot");
    Route::get("pointBot" , "HomeController@pointBot");
    Route::post("walletBot" , "HomeController@walletBot");
    Route::post("excelBot" , "HomeController@excelBot");
    Route::post("registerUserAndGiveOrderproduct" , "HomeController@registerUserAndGiveOrderproduct");
    Route::get("specialAddUser" , "HomeController@specialAddUser");

    Route::group(['prefix' => 'user'], function () {
        Route::get('info', "UserController@informationPublicUrl");
        Route::get('{user}/info', 'UserController@information');
        Route::post('{user}/completeInfo', 'UserController@completeInformation');
        Route::put('updateProfile', 'UserController@updateProfile');
        Route::put('updatePhoto' , 'UserController@updatePhoto');
        Route::put('updatePassword' , 'UserController@updatePassword');
        Route::get('orders' , 'UserController@userOrders');
        Route::get('question' , 'UserController@uploads');
        Route::get('getVerificationCode' , 'UserController@sendVerificationCode');
        Route::post('verifyAccount' , 'UserController@submitVerificationCode');
        Route::post('sendSMS' , 'UserController@sendSMS');
        Route::post('submitWorkTime' , 'UserController@submitWorkTime');
        Route::post('removeFromLottery' , 'UserController@removeFromLottery');
        Route::post('addToArabiHozouri' , 'OrderController@addToArabiHozouri');
        Route::post('removeArabiHozouri' , 'OrderController@removeArabiHozouri');
        Route::get('uploadQuestion', 'UserController@uploadConsultingQuestion')->middleware('completeInfo');
    });
    Route::group(['prefix' => 'order'], function () {
        Route::post('detachorderproduct' , 'OrderController@detachOrderproduct');
        Route::post('addOrderproduct/{product}', "OrderController@addOrderproduct");
        Route::delete('removeOrderproduct/{product}', "OrderController@removeOrderproduct");
        Route::post('submitCoupon', "OrderController@submitCoupon");
        Route::get('RemoveCoupon', "OrderController@removeCoupon");
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('{product}/live' , 'ProductController@showLive');
        Route::get('{product}/createConfiguration' , 'ProductController@createConfiguration');
        Route::post('{product}/makeConfiguration' , 'ProductController@makeConfiguration');
        Route::get('{product}/editAttributevalues' , 'ProductController@editAttributevalues');
        Route::post('{product}/updateAttributevalues' , 'ProductController@updateAttributevalues');
        Route::put('{product}/addGift' , 'ProductController@addGift');
        Route::delete('{product}/removeGift' , 'ProductController@removeGift');
        Route::post('{product}/copy' , 'ProductController@copy');
        Route::put('child/{product}' , 'ProductController@childProductEnable');
        Route::put('addComplimentary/{product}' , 'ProductController@addComplimentary');
        Route::put('removeComplimentary/{product}' , 'ProductController@removeComplimentary');
    });

    Route::resource('user', 'UserController');
    Route::resource('userbon', 'UserbonController');
    Route::resource('assignment', 'AssignmentController');
    Route::resource('consultation', 'ConsultationController');
    Route::resource('transaction', 'TransactionController');
    Route::resource('order', 'OrderController');
    Route::resource('permission', 'PermissionController');
    Route::resource('role', 'RoleController');
    Route::resource('coupon', 'CouponController');
    Route::resource('attributevalue', 'AttributevalueController');
    Route::resource('attribute', 'AttributeController');
    Route::resource('attributeset', 'AttributesetController');
    Route::resource('attributegroup', 'AttributegroupController');
    Route::resource('userupload', 'UseruploadController');
    Route::resource('verificationmessage', 'VerificationmessageController');
    Route::resource('contact', 'ContactController');
    Route::resource('phone', 'PhoneController');
    Route::resource('afterloginformcontrol' , 'AfterLoginFormController');
    Route::resource('articlecategory', 'ArticlecategoryController');
    Route::resource('websiteSetting', 'WebsiteSettingController');
    Route::resource('productfile', 'ProductfileController');
    Route::resource('major' , 'MajorController');
    Route::resource('usersurveyanwser' , "UserSurveyAnswerController");
    Route::resource('eventresult' , "EventresultController");
    Route::resource('productphoto' , "ProductphotoController");
    Route::resource('mbtianswer' , "MbtianswerController");
    Route::resource('slideshow' , "SlideShowController");
    Route::resource('city' , 'CityController');
    Route::resource('file' , 'FileController') ;
    Route::resource('employeetimesheet' , 'EmployeetimesheetController') ;
    Route::resource('lottery' , 'LotteryController') ;

    Route::get( "copylessonfromremote" , "RemoteDataCopyController@copyLesson");
    Route::get( "copydepartmentfromremote" , "RemoteDataCopyController@copyDepartment");
    Route::get( "copydepartmentlessonfromremote" , "RemoteDataCopyController@copyDepartmentlesson");
    Route::get( "copyvideofromremote" , "RemoteDataCopyController@copyVideo");
    Route::get( "copypamphletfromremote" , "RemoteDataCopyController@copyPamphlet");
    Route::get( "copydepartmentlessontotakhtekhak" , "SanatisharifmergeController@copyDepartmentlesson");
    Route::get( "copycontenttotakhtekhak" , "SanatisharifmergeController@copyContent");
    Route::get("tagbot", "HomeController@tagbot");

    Route::get("donate" , "HomeController@donate") ;
    Route::post("donateOrder" , "OrderController@donateOrder") ;
});

Route::resource('product', 'ProductController');
Route::resource('orderproduct', 'OrderproductController');
Route::resource('c', 'EducationalContentController', [
    'except' => [
        'index'
    ]
]);
Route::resource( "sanatisharifmerge" , "SanatisharifmergeController");
Route::resource('article', 'ArticleController');
Auth::routes();