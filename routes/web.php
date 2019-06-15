<?php


use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LandingPageController;
use App\Http\Controllers\Web\PaymentStatusController;
use App\Http\Controllers\Web\SalesReportController;
use App\PaymentModule\Controllers\RedirectUserToPaymentPage;
use App\PaymentModule\Controllers\PaymentVerifierController;
use App\PaymentModule\Controllers\RedirectAPIUserToPaymentRoute;

Route::get('embed/c/{content}', "Web\ContentController@embed");
Route::get('/', 'Web\IndexPageController');
Route::get('shop', 'Web\ShopPageController')->name('shop');
Route::get('home', 'Web\HomeController@home');
Route::get('404', 'Web\HomeController@error404');
Route::get('403', 'Web\HomeController@error403');
Route::get('500', 'Web\HomeController@error500');
Route::get('error', 'Web\HomeController@errorPage');
Route::get('download', "Web\HomeController@download");
Route::get('d/{data}', "Web\HomeController@newDownload");
Route::get('contactUs', 'Web\ContactUsController');
Route::get('rules', 'Web\RulesPageController');
Route::get('articleList', 'Web\ArticleController@showList');
Route::get("debug", 'Web\HomeController@debug');
Route::get("telgramAgent2", "Web\HomeController@telgramAgent");
Route::post('sendMail', 'Web\HomeController@sendMail');
Route::post('user/getPassword', 'Web\UserController@sendGeneratedPassword');
Route::get('product/search', 'Web\ProductController@search');
Route::get('showPartial/{product}', 'Web\ProductController@showPartial');
Route::get('Sanati-Sharif-Lesson/{lId?}/{dId?}', 'Web\SanatisharifmergeController@redirectLesson');
Route::get('sanati-sharif-lesson/{lId?}/{dId?}', 'Web\SanatisharifmergeController@redirectLesson');
Route::get('Sanati-Sharif-Video/{lId?}/{dId?}/{vId?}', 'Web\SanatisharifmergeController@redirectVideo');
Route::get('sanati-sharif-video/{lId?}/{dId?}/{vId?}', 'Web\SanatisharifmergeController@redirectVideo');
Route::get('SanatiSharif-Video/{lId?}/{dId?}/{vId?}', 'Web\SanatisharifmergeController@redirectEmbedVideo');
Route::get('sanatisharif-video/{lId?}/{dId?}/{vId?}', 'Web\SanatisharifmergeController@redirectEmbedVideo');
Route::get('Sanati-Sharif-Pamphlet/{lId?}/{dId?}/{pId?}', 'Web\SanatisharifmergeController@redirectPamphlet');
Route::get('sanati-sharif-pamphlet/{lId?}/{dId?}/{pId?}', 'Web\SanatisharifmergeController@redirectPamphlet');
Route::get('SanatiSharif-News', 'Web\HomeController@home');
Route::get('Alaa-App/{mod?}', 'Web\SanatisharifmergeController@AlaaApp');
Route::get('image/{category}/{w}/{h}/{filename}', [
    'as'   => 'image',
    'uses' => 'Web\HomeController@getImage',
]);
Route::get("sharif", ['\\'.HomeController::class , 'schoolRegisterLanding']);
Route::get("sharifLanding", ['\\'.LandingPageController::class , 'sharifLanding']);
Route::post("registerForSanatiSharifHighSchool", "Web\UserController@registerForSanatiSharifHighSchool");

Route::get('sitemap.xml', 'Web\HomeController@siteMapXML');
Route::group(['prefix' => 'sitemap'], function () {
    Route::get('/index.xml', 'Web\SitemapController@index');
    Route::get('products.xml', 'Web\SitemapController@products');
    Route::get('contents.xml', 'Web\SitemapController@eContents');
});

Route::group(['prefix' => 'checkout'], function () {
    Route::get('auth', "Web\OrderController@checkoutAuth");

    Route::get('completeInfo', 'Web\OrderController@checkoutCompleteInfo')
        ->name('checkoutCompleteInfo');

    Route::get('review', "Web\OrderController@checkoutReview")
        ->name('checkoutReview');
    
    Route::get('payment', "Web\OrderController@checkoutPayment")
        ->name('checkoutPayment');

    Route::any('verifyPayment/online/{paymentMethod}/{device}', [PaymentVerifierController::class, 'verify'])
        ->name('verifyOnlinePayment');
    
    Route::any('verifyPayment/online/{status}/{paymentMethod}/{device}', [PaymentStatusController::class, 'show'])
        ->name('showOnlinePaymentStatus');
    
    Route::any('verifyPayment/offline/{paymentMethod}/{device}', 'Web\OfflinePaymentController@verifyPayment')
        ->name('verifyOfflinePayment');
});
Route::group(['prefix' => 'orderproduct'], function () {
//    Route::get('store', 'Web\OrderproductController@store');
    Route::post('checkout', 'Web\OrderproductController@checkOutOrderproducts');
});

Route::group(['prefix' => 'landing'], function () {
    
    Route::get('7' , 'Web\ProductController@landing7')->name('landing.7');
    Route::get('9' , 'Web\ProductController@landing9')->name('landing.9');
    Route::get('10' , 'Web\ProductController@landing10')->name('landing.10');
    
    Route::get('8' , 'Web\ProductController@landing8')->name('landing.8');
    
    Route::get('6' , [
        'as'   => 'landing.6',
        'uses' => 'Web\ProductController@landing6',
    ]);
    Route::get('5' , [
        'as'   => 'landing.5',
        'uses' => 'Web\ProductController@landing5',
    ]);
    Route::get('1' , [
        'as'   => 'landing.1',
        'uses' => 'Web\ProductController@landing1',
    ]);
    Route::get('2' , [
        'as'   => 'landing.2',
        'uses' => 'Web\ProductController@landing2',
    ]);
    Route::get('3', [
        'as'   => 'landing.3',
        'uses' => 'Web\ProductController@landing3',
    ]);
    Route::get('4',  [
        'as'   => 'landing.4',
        'uses' => 'Web\ProductController@landing4',
    ]);
});
Route::group(['middleware' => 'auth'], function () {
    
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::get('usersAdmin', 'Web\AdminController@admin');
    Route::get('consultantPanel', 'Web\AdminController@consultantAdmin');
    Route::get('consultantEntekhabReshtePanel', 'Web\HomeController@consultantEntekhabReshte');
    Route::get('consultantEntekhabReshteList', 'Web\HomeController@consultantEntekhabReshteList');
    Route::post('consultantStoreEntekhabReshte', 'Web\HomeController@consultantStoreEntekhabReshte');
    Route::get('productAdmin', 'Web\AdminController@adminProduct');
    Route::get('contentAdmin', 'Web\AdminController@adminContent');
    Route::get('blockAdmin', 'Web\AdminController@adminBlock')->name('blockAdmin');
    Route::get('blockAdmin/list', 'Web\BlockController@adminIndex');
    Route::resource('blockAdmin', 'Web\BlockController',
        [
            'except' => ['index'],
            'names' => [
                'edit' => 'blockAdmin.edit'
            ]
        ]
    );
    
    Route::get('ordersAdmin', 'Web\AdminController@adminOrder');
    Route::get('smsAdmin', 'Web\AdminController@adminSMS');
    Route::get('botAdmin', 'Web\BotsController@adminBot');
    Route::get('siteConfigAdmin', 'Web\AdminController@adminSiteConfig');
    Route::get('slideShowAdmin', 'Web\AdminController@adminSlideShow');
    Route::get('report', 'Web\AdminController@adminReport');
    Route::get('majorAdminPanel', 'Web\AdminController@adminMajor');
    Route::get('lotteryAdminPanel', 'Web\AdminController@adminLottery');
    Route::get('teleMarketingAdminPanel', 'Web\AdminController@adminTeleMarketing');
    Route::post('adminSendSMS', 'Web\HomeController@sendSMS');
    Route::get('asset', 'Web\UserController@userProductFiles')->name('user.asset');
    Route::get('complete-register', 'Web\UserController@completeRegister')
        ->name('completeRegister');
    Route::get('survey', 'Web\UserController@showSurvey');
    Route::get('97', 'Web\HomeController@submitKonkurResult');
    Route::post("transactionToDonate/{transaction}", "Web\TransactionController@convertToDonate");
    Route::post("completeTransaction/{transaction}", "Web\TransactionController@completeTransaction");
    Route::post("myTransaction/{transaction}", "Web\TransactionController@limitedUpdate");
    Route::get('getUnverifiedTransactions', 'Web\TransactionController@getUnverifiedTransactions');
    Route::any('paymentRedirect/{paymentMethod}/{device}', '\\'.RedirectUserToPaymentPage::class)
        ->name('redirectToBank');
    Route::get('exitAdminInsertOrder', 'Web\OrderController@exitAdminInsertOrder');
    Route::post('exchangeOrderproduct/{order}', 'Web\OrderController@exchangeOrderproduct');
    Route::get('MBTI-Participation', "Web\MbtianswerController@create");
    Route::get('MBTI-Introduction', "Web\MbtianswerController@introduction");
    
    Route::get('holdlottery', "Web\LotteryController@holdLottery");
    Route::get('givePrize', "Web\LotteryController@givePrizes");
    Route::get('smsbot', "Web\BotsController@smsBot");
    Route::get("bot", "Web\BotsController@bot");
    Route::get("pointBot", "Web\BotsController@pointBot");
    Route::post("walletBot", "Web\BotsController@walletBot");
    Route::post("excelBot", "Web\BotsController@excelBot");
    Route::get("zarinpalbot", "Web\BotsController@ZarinpalVerifyPaymentBot");
    Route::post("registerUserAndGiveOrderproduct", "Web\AdminController@registerUserAndGiveOrderproduct");
    Route::get("specialAddUser", "Web\AdminController@specialAddUser");
    Route::get("v/asiatech", "Web\UserController@voucherRequest");
    Route::put("v", "Web\UserController@submitVoucherRequest");
    
    Route::resource('orderproduct', 'Web\OrderproductController');
    
    Route::group(['prefix' => 'user'], function () {
        
        
        Route::get('{user}/dashboard', 'Web\DashboardPageController')
            ->name('web.user.dashboard');
        Route::get('sales-report', '\\'.SalesReportController::class);
        Route::get('profile', 'Web\UserController@show');
        Route::post('profile', 'Web\UserController@update')
            ->name('web.authenticatedUser.profile.update');
        
        Route::get('info', "Web\UserController@informationPublicUrl");
        Route::get('{user}/info', 'Web\UserController@information');
        Route::post('{user}/completeInfo', 'Web\UserController@completeInformation');
        Route::get('orders', 'Web\UserController@userOrders');
        Route::get('question', 'Web\UserController@uploads');
        Route::get('getVerificationCode', 'Web\UserController@sendVerificationCode');
        Route::post('sendSMS', 'Web\UserController@sendSMS');
        Route::post('submitWorkTime', 'Web\UserController@submitWorkTime');
        Route::post('removeFromLottery', 'Web\UserController@removeFromLottery');
        Route::get('uploadQuestion', 'Web\UserController@uploadConsultingQuestion');
        Route::get('orders', 'Web\UserController@userOrders');
        Route::get('question', 'Web\UserController@uploads');
        Route::get('getVerificationCode', 'Web\UserController@sendVerificationCode');
        Route::post('verifyAccount', 'Web\UserController@submitVerificationCode');
        Route::post('sendSMS', 'Web\UserController@sendSMS');
        Route::post('submitWorkTime', 'Web\UserController@submitWorkTime');
        Route::post('removeFromLottery', 'Web\UserController@removeFromLottery');
        Route::get('uploadQuestion', 'Web\UserController@uploadConsultingQuestion');
    });
    Route::group(['prefix' => 'order'], function () {
        Route::post('detachorderproduct', 'Web\OrderController@detachOrderproduct');
        Route::post('addOrderproduct/{product}', "Web\OrderController@addOrderproduct");
        Route::delete('removeOrderproduct/{product}', "Web\OrderController@removeOrderproduct");
        Route::post('submitCoupon', "Web\OrderController@submitCoupon");
        Route::get('RemoveCoupon', "Web\OrderController@removeCoupon");
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('{product}/live', 'Web\ProductController@showLive');
        Route::get('{product}/createConfiguration', 'Web\ProductController@createConfiguration');
        Route::post('{product}/makeConfiguration', 'Web\ProductController@makeConfiguration');
        Route::get('{product}/editAttributevalues', 'Web\ProductController@editAttributevalues');
        Route::post('{product}/updateAttributevalues', 'Web\ProductController@updateAttributevalues');
        Route::put('{product}/addGift', 'Web\ProductController@addGift');
        Route::delete('{product}/removeGift', 'Web\ProductController@removeGift');
        Route::post('{product}/copy', 'Web\ProductController@copy');
        Route::put('child/{product}', 'Web\ProductController@childProductEnable');
        Route::put('addComplimentary/{product}', 'Web\ProductController@addComplimentary');
        Route::put('removeComplimentary/{product}', 'Web\ProductController@removeComplimentary');
    });
    
    Route::resource('user', 'Web\UserController');
    Route::resource('userbon', 'Web\UserbonController');
    Route::resource('assignment', 'Web\AssignmentController');
    Route::resource('consultation', 'Web\ConsultationController');
    Route::resource('transaction', 'Web\TransactionController');
    Route::resource('order', 'Web\OrderController');
    Route::resource('permission', 'Web\PermissionController');
    Route::resource('role', 'Web\RoleController');
    Route::resource('coupon', 'Web\CouponController');
    Route::resource('attributevalue', 'Web\AttributevalueController');
    Route::resource('attribute', 'Web\AttributeController');
    Route::resource('attributeset', 'Web\AttributesetController');
    Route::resource('attributegroup', 'Web\AttributegroupController');
    Route::resource('userupload', 'Web\UseruploadController');
//    Route::resource('verificationmessage', 'Web\VerificationmessageController');
    Route::resource('contact', 'Web\ContactController');
    Route::resource('phone', 'Web\PhoneController');
    Route::resource('afterloginformcontrol', 'Web\AfterLoginFormController');
    Route::resource('articlecategory', 'Web\ArticlecategoryController');
    Route::resource('websiteSetting', 'Web\WebsiteSettingController');
    Route::resource('productfile', 'Web\ProductfileController');
    Route::resource('major', 'Web\MajorController');
    Route::resource('usersurveyanwser', "Web\UserSurveyAnswerController");
    Route::resource('eventresult', "Web\EventresultController");
    Route::resource('productphoto', "Web\ProductphotoController");
    Route::resource('mbtianswer', "Web\MbtianswerController");
    Route::resource('slideshow', "Web\SlideShowController");
    Route::resource('city', 'Web\CityController');
    Route::resource('file', 'Web\FileController');
    Route::resource('employeetimesheet', 'Web\EmployeetimesheetController');
    Route::resource('lottery', 'Web\LotteryController');
    Route::resource('cat', 'Web\CategoryController');
    
    Route::get("copylessonfromremote", "Web\RemoteDataCopyController@copyLesson");
    Route::get("copydepartmentfromremote", "Web\RemoteDataCopyController@copyDepartment");
    Route::get("copydepartmentlessonfromremote", "Web\RemoteDataCopyController@copyDepartmentlesson");
    Route::get("copyvideofromremote", "Web\RemoteDataCopyController@copyVideo");
    Route::get("copypamphletfromremote", "Web\RemoteDataCopyController@copyPamphlet");
    Route::get("copydepartmentlessontotakhtekhak", "Web\SanatisharifmergeController@copyDepartmentlesson");
    Route::get("copycontenttotakhtekhak", "Web\SanatisharifmergeController@copyContent");
    Route::get("tagbot", "Web\BotsController@tagbot");
    
    Route::get("donate", "Web\DonateController");
    Route::post("donateOrder", "Web\OrderController@donateOrder");
    Route::get('adminGenerateRandomCoupon', "Web\AdminController@adminGenerateRandomCoupon");

    Route::get('listContents/{set}', "Web\SetController@indexContent");
    Route::resource('set', 'Web\SetController');
});

Route::group(['prefix' => 'c'], function () {
    
    Route::get('search', 'Web\ContentController@search');
    Route::get('create2', 'Web\ContentController@create2');
    
    Route::get('{c}/favored', 'Web\FavorableController@getUsersThatFavoredThisFavorable');
    Route::post('{c}/favored', 'Web\FavorableController@markFavorableFavorite');
    
    Route::group(['prefix' => '{c}/attach'], function () {
        Route::post('set/{set}', 'Web\ContentController@attachContentToContentSet');
        Route::put('set/{set}', 'Web\ContentController@updateContentSetPivots');
    });
});

Route::group(['prefix' => 'product'], function () {
    Route::get('{product}/favored', 'Web\FavorableController@getUsersThatFavoredThisFavorable');
    Route::post('{product}/favored', 'Web\FavorableController@markFavorableFavorite');
});

Route::get("ctag", "Web\ContentController@retrieveTags");
Route::resource('product', 'Web\ProductController');

Route::resource('c', 'Web\ContentController')->names([
    'index' => 'content.index'
]);;
Route::resource("sanatisharifmerge", "Web\SanatisharifmergeController");
Route::resource('article', 'Web\ArticleController');
Route::resource('block', 'Web\BlockController');
Auth::routes(['verify' => true]);

Route::group(['prefix' => 'mobile'], function () {
    Route::get("verify", "Web\MobileVerificationController@show")
        ->name('mobile.verification.notice');
    Route::post("verify", "Web\MobileVerificationController@verify")
        ->name('mobile.verification.verify');
    Route::get("resend", "Web\MobileVerificationController@resend")
        ->name('mobile.verification.resend');
});
Route::post("cd3b472d9ba631a73cb7b66ba513df53", "Web\CouponController@generateRandomCoupon");
Route::view('uiTest', 'pages.certificates');

Route::get("tree", "Web\TopicsTreeController@lernitoTree");
Route::get("tree/getArrayString/{lnid}", "Web\TopicsTreeController@getTreeInPHPArrayString");
Route::any('goToPaymentRoute/{paymentMethod}/{device}/', '\\'.RedirectAPIUserToPaymentRoute::class)
    ->name('redirectToPaymentRoute');
