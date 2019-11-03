<?php


use App\Http\Controllers\Web\BotsController;
use App\Http\Controllers\Web\FavorableController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LandingPageController;
use App\Http\Controllers\Web\LiveController;
use App\Http\Controllers\Web\SectionController;
use App\Http\Controllers\Web\SetController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\SurveyController;
use App\Http\Controllers\Web\WalletController;
use App\Http\Controllers\Web\ContentController;
use App\Http\Controllers\Web\LotteryController;
use App\Http\Controllers\Web\SitemapController;
use App\Http\Controllers\Web\ShopPageController;
use App\Http\Controllers\Web\ErrorPageController;
use App\Http\Controllers\Web\IndexPageController;
use App\Http\Controllers\Web\SalesReportController;
use App\Http\Controllers\Web\ConsultationController;
use App\Http\Controllers\Web\OrderproductController;
use App\Http\Controllers\Web\SharifSchoolController;
use App\Http\Controllers\Web\DashboardPageController;
use App\Http\Controllers\Web\PaymentStatusController;
use App\Http\Controllers\Web\ProductLandingController;
use App\Http\Controllers\Web\LiveDescriptionController;
use App\Http\Controllers\Web\EmployeetimesheetController;
use App\Http\Controllers\Web\MobileVerificationController;
use App\PaymentModule\Controllers\RedirectUserToPaymentPage;
use App\PaymentModule\Controllers\PaymentVerifierController;
use App\PaymentModule\Controllers\RedirectAPIUserToPaymentRoute;


Route::get('embed/c/{content}', 'Web\ContentController@embed');
Route::get('/', '\\'.IndexPageController::class)->name('web.index');
Route::get('shop', '\\'.ShopPageController::class)->name('web.shop');
Route::get('home', [HomeController::class , 'home'])->name('web.home');
Route::get('404',  [ErrorPageController::class , 'error404']);
Route::get('403',  [ErrorPageController::class , 'error403']);
Route::get('500',  [ErrorPageController::class , 'error500']);
Route::get('error', [ErrorPageController::class , 'errorPage']);
Route::get('download', [HomeController::class , 'download']);
Route::get('d/{data}', [HomeController::class , 'newDownload']);
Route::get('contactUs', 'Web\ContactUsController');
Route::get('rules', 'Web\RulesPageController');
Route::get('articleList', 'Web\ArticleController@showList');
Route::get('debug', 'Web\HomeController@debug');
Route::post('sendMail', [HomeController::class , 'sendMail']);
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
Route::get('sharif', [SharifSchoolController::class , 'schoolRegisterLanding']);
Route::get('sharifLanding', [SharifSchoolController::class , 'sharifLanding']);
Route::post('registerForSanatiSharifHighSchool', [SharifSchoolController::class , 'registerForSanatiSharifHighSchool']);

Route::get('sitemap.xml', [HomeController::class , 'siteMapXML']);
Route::group(['prefix' => 'sitemap'], function () {
    Route::get('/index.xml', 'Web\SitemapController@index');
    Route::get('product.xml', 'Web\SitemapController@product');
    Route::get('video-{page?}.xml', [SitemapController::class, 'video']);
    Route::get('pamphlet-{page?}.xml', 'Web\SitemapController@pamphlet');
    Route::get('article-{page?}.xml', 'Web\SitemapController@article');
    Route::get('set-{page?}.xml', 'Web\SitemapController@set');
    Route::get('redirect.xml', 'Web\SitemapController@redirect');
});

Route::group(['prefix' => 'checkout'], function () {
    Route::get('review', 'Web\OrderController@checkoutReview')
        ->name('checkoutReview');

    Route::any('verifyPayment/online/{paymentMethod}/{device}', [PaymentVerifierController::class, 'verify'])
        ->name('verifyOnlinePayment');

    Route::any('verifyPayment/online/{status}/{paymentMethod}/{device}', [PaymentStatusController::class, 'show'])
        ->name('showOnlinePaymentStatus');

    Route::any('verifyPayment/offline/{paymentMethod}/{device}', 'Web\OfflinePaymentController@verifyPayment')
        ->name('verifyOfflinePayment');
});

Route::group(['prefix' => 'landing'], function () {
    Route::get('1' , [ProductLandingController::class, 'landing1'])->name('landing.1');
    Route::get('2' , [ProductLandingController::class, 'landing2'])->name('landing.2');
    Route::get('3' , [ProductLandingController::class, 'landing3'])->name('landing.3');
    Route::get('4' , [ProductLandingController::class, 'landing4'])->name('landing.4');
    Route::get('5' , [ProductLandingController::class, 'landing5'])->name('landing.5');
    Route::get('6' , [ProductLandingController::class, 'landing6'])->name('landing.6');
    Route::get('7' , [ProductLandingController::class, 'landing7'])->name('landing.7');
    Route::get('8' , [ProductLandingController::class, 'landing8'])->name('landing.8');
    Route::get('9' , [ProductLandingController::class, 'landing9'])->name('landing.9');
    Route::get('10', [ProductLandingController::class, 'landing10'])->name('landing.10');
    Route::get('13Aban', [LandingPageController::class, 'roozeDaneshAmooz'])->name('landing.13Aban');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

    /*** Admin routes */
    Route::get('usersAdmin', [AdminController::class, 'admin'])->name('web.admin.users');
    Route::get('consultantPanel', [AdminController::class, 'consultantAdmin'])->name('web.admin.consultant');
    Route::get('productAdmin', [AdminController::class, 'adminProduct'])->name('web.admin.product');
    Route::get('contentAdmin', [AdminController::class, 'adminContent'])->name('web.admin.content');
    Route::get('blockAdmin', [AdminController::class, 'adminBlock'])->name('web.admin.block');
    Route::get('sales-report', [AdminController::class, 'adminSalesReport'])->name('web.admin.salesReport');
    Route::get('ordersAdmin', [AdminController::class, 'adminOrder'])->name('web.admin.order');
    Route::get('smsAdmin', [AdminController::class, 'adminSMS'])->name('web.admin.sms');
    Route::get('siteConfigAdmin', [AdminController::class, 'adminSiteConfig'])->name('web.admin.siteConfig');
    Route::get('slideShowAdmin', [AdminController::class, 'adminSlideShow'])->name('web.admin.slideshow');
    Route::get('report',[AdminController::class, 'adminReport'])->name('web.admin.report');
    Route::get('majorAdminPanel', [AdminController::class, 'adminMajor'])->name('web.admin.major');
    Route::get('lotteryAdminPanel', [AdminController::class, 'adminLottery'])->name('web.admin.lottery');
    Route::get('teleMarketingAdminPanel', [AdminController::class, 'adminTeleMarketing'])->name('web.admin.teleMarketing');
    Route::get('walletAdminPanel', [AdminController::class, 'adminGiveWalletCredit'])->name('web.admin.wallet');
    Route::get('cacheclearAdmin', [AdminController::class, 'adminCacheClear'])->name('web.admin.cacheclear');
    Route::get('registrationListAdminPanel', [AdminController::class, 'adminRegistrationList'])->name('web.admin.registrationList');
    Route::get('specialAddUser', [AdminController::class, 'specialAddUser'])->name('web.admin.specialAddUser');
    Route::get('adminGenerateRandomCoupon', [AdminController::class, 'adminGenerateRandomCoupon'])->name('web.admin.generateRandomCoupon');
    Route::get('adminBot', [AdminController::class, 'adminBot'])->name('web.admin.bots');
    Route::post('giveWalletCredit', [WalletController::class, 'giveCredit'])->name('web.admin.wallet.giveCredit');
    Route::post('registerUserAndGiveOrderproduct', [AdminController::class, 'registerUserAndGiveOrderproduct'])->name('web.admin.registerUserAndGiveOrderproduct');
    Route::post('adminSendSMS', [HomeController::class , 'sendSMS'])->name('web.sendSms');
    /*** Admin routes */


    Route::get('asset', [UserController::class, 'userProductFiles'])->name('user.asset');
    Route::get('complete-register', [UserController::class, 'completeRegister'])->name('completeRegister');
    Route::get('survey',  [SurveyController::class, 'show']);
    Route::resource('survey', '\\'. SurveyController::class);
    Route::post('transactionToDonate/{transaction}', 'Web\TransactionController@convertToDonate');
    Route::post('completeTransaction/{transaction}', 'Web\TransactionController@completeTransaction');
    Route::post('myTransaction/{transaction}', 'Web\TransactionController@limitedUpdate');
    Route::get('getUnverifiedTransactions', 'Web\TransactionController@getUnverifiedTransactions');
    Route::any('paymentRedirect/{paymentMethod}/{device}', '\\'.RedirectUserToPaymentPage::class)->name('redirectToBank');
    Route::get('exitAdminInsertOrder', 'Web\OrderController@exitAdminInsertOrder');
    Route::post('exchangeOrderproduct/{order}', 'Web\OrderController@exchangeOrderproduct');
    Route::get('MBTI-Participation', 'Web\MbtianswerController@create');
    Route::get('MBTI-Introduction', 'Web\MbtianswerController@introduction');

    Route::get('holdlottery', 'Web\LotteryController@holdLottery');
    Route::get('givePrize', 'Web\LotteryController@givePrizes');
    Route::get('bot', 'Web\BotsController@bot')->name('web.bots');
    Route::get('pointBot', [BotsController::class, 'pointBot'])->name('web.bot.point');
    Route::post('walletBot',[BotsController::class, 'walletBot'])->name('web.bot.wallet');
    Route::post('excelBot', [BotsController::class, 'excelBot'])->name('web.bot.excel');
    Route::post('zarinpalbot', [BotsController::class, 'ZarinpalVerifyPaymentBot'])->name('web.bot.verifyZarinpal');
    Route::post('thumbnailbot', [BotsController::class, 'fixthumbnail'])->name('web.bot.fixthumbnails');
    Route::post('introcontenttag', [BotsController::class, 'introContentTags'])->name('web.bot.introContentTags');
    Route::post('tagbot', [BotsController::class, 'fixtag'])->name('web.bot.fixtag');
    Route::post('close-orders-bot', [BotsController::class, 'closeOrders'])->name('web.bot.closeOrders');
    Route::post('generateMassiveRandomCoupon', [BotsController::class, 'generateMassiveRandomCoupon'])->name('web.bot.massive.random.coupon');
    Route::get('v/asiatech', 'Web\VoucherController@voucherRequest');
    Route::put('v', 'Web\VoucherController@submitVoucherRequest');

    Route::group(['prefix' => 'orderproduct'], function () {
        Route::post('restore', [OrderproductController::class, 'restore'])->name('web.orderproduct.restore');
    });
    Route::resource('orderproduct', 'Web\OrderproductController');


    Route::get('96', [UserController::class, 'submitKonkurResult']);
    Route::get('97', [UserController::class, 'submitKonkurResult']);
    Route::get('98', [UserController::class, 'submitKonkurResult'])->name('web.user.konkurResult');
    Route::group(['prefix' => 'user'], function () {
        Route::get('{user}/dashboard', '\\'. DashboardPageController::class)
            ->name('web.user.dashboard');
        Route::get('sales-report', '\\'.SalesReportController::class);
        Route::get('profile', 'Web\UserController@show');
        Route::post('profile', 'Web\UserController@update')
            ->name('web.authenticatedUser.profile.update');

        Route::get('info', [UserController::class, 'informationPublicUrl']);
        Route::get('{user}/info', 'Web\UserController@information');
        Route::post('{user}/completeInfo', [UserController::class, 'completeInformation']);
        Route::get('orders', 'Web\UserController@userOrders');
        Route::get('question', 'Web\UserController@uploads');
        Route::post('submitWorkTime/{employeetimesheet}', [EmployeetimesheetController::class, 'submitWorkTime'])->name('web.user.employeetime.submit.update');
        Route::post('submitWorkTime', [EmployeetimesheetController::class, 'submitWorkTime'])->name('web.user.employeetime.submit');
        Route::post('removeFromLottery', [LotteryController::class, 'removeFromLottery']);
        Route::get('uploadQuestion', [ConsultationController::class, 'uploadConsultingQuestion']);
        Route::get('orders', [UserController::class, 'userOrders']);
        Route::get('question', [UserController::class, 'userQuestions']);
        Route::post('sendSMS', [UserController::class, 'sendSMS']);
        Route::post('user/update/partialInfo', [UserController::class, 'partialUpdate']);
    });
    Route::group(['prefix' => 'order'], function () {
        Route::post('detachorderproduct', 'Web\OrderController@detachOrderproduct');
        Route::post('addOrderproduct/{product}', 'Web\OrderController@addOrderproduct');
        Route::delete('removeOrderproduct/{product}', 'Web\OrderController@removeOrderproduct');
        Route::post('submitCoupon', 'Web\OrderController@submitCoupon');
        Route::get('RemoveCoupon', 'Web\OrderController@removeCoupon');
    });
    Route::group(['prefix' => 'product'], function () {
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

    Route::get('consultantEntekhabReshtePanel', [ConsultationController::class, 'consultantEntekhabReshte']);
    Route::get('consultantEntekhabReshteList', [ConsultationController::class, 'consultantEntekhabReshteList']);
    Route::post('consultantStoreEntekhabReshte', [ConsultationController::class, 'consultantStoreEntekhabReshte']);


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
//  Route::resource('verificationmessage', 'Web\VerificationmessageController');
    Route::resource('contact', 'Web\ContactController');
    Route::resource('phone', 'Web\PhoneController');
    Route::resource('afterloginformcontrol', 'Web\AfterLoginFormController');
    Route::resource('articlecategory', 'Web\ArticlecategoryController');
    Route::resource('websiteSetting', 'Web\WebsiteSettingController');
    Route::resource('productfile', 'Web\ProductfileController');
    Route::resource('major', 'Web\MajorController');
    Route::resource('usersurveyanwser', 'Web\UserSurveyAnswerController');
    Route::resource('eventresult', 'Web\EventresultController');
    Route::resource('productphoto', 'Web\ProductphotoController');
    Route::resource('mbtianswer', 'Web\MbtianswerController');
    Route::resource('slideshow', 'Web\SlideShowController');
    Route::resource('city', 'Web\CityController');
    Route::resource('file', 'Web\FileController');
    Route::resource('employeetimesheet', 'Web\EmployeetimesheetController');
    Route::resource('lottery', 'Web\LotteryController');
    Route::resource('cat', 'Web\CategoryController');
    Route::resource('livedescription', '\\'.LiveDescriptionController::class );
    Route::resource('section', '\\'.SectionController::class );

    Route::get('copylessonfromremote', 'Web\RemoteDataCopyController@copyLesson');
    Route::get('copydepartmentfromremote', 'Web\RemoteDataCopyController@copyDepartment');
    Route::get('copydepartmentlessonfromremote', 'Web\RemoteDataCopyController@copyDepartmentlesson');
    Route::get('copyvideofromremote', 'Web\RemoteDataCopyController@copyVideo');
    Route::get('copypamphletfromremote', 'Web\RemoteDataCopyController@copyPamphlet');
    Route::get('copydepartmentlessontotakhtekhak', 'Web\SanatisharifmergeController@copyDepartmentlesson');
    Route::get('copycontenttotakhtekhak', 'Web\SanatisharifmergeController@copyContent');
    Route::get('tagbot', 'Web\BotsController@tagbot');

    Route::get('donate', 'Web\DonateController');
    Route::post('donateOrder', 'Web\OrderController@donateOrder');

    Route::get('listPendingDescriptionContents', [ContentController::class, 'indexPendingDescriptionContent'])->name('web.c.list.pending.description.content');

    Route::get('live' , '\\'.LiveController::class)->name('live');
    Route::post('startlive' , [LiveController::class, 'startLive'])->name('web.start.live');
    Route::post('endlive'   , [LiveController::class, 'endLive'])->name('web.end.live');

    Route::get('atest' , [HomeController::class, 'adTest']);
    Route::get('block/detach/{block}/{type}/{id}', 'Web\BlockController@detachFromBlock');
    Route::get('serpSim' , [AdminController::class, 'serpSim'] );
    Route::get('process_serpsim' , [AdminController::class, 'processSerpsim'] );
});

Route::group(['prefix' => 'set'], function () {
    Route::get('{set}/listContents', [SetController::class, 'indexContent'])->name('web.set.list.contents');
    Route::get('{set}/favored', [FavorableController::class, 'getUsersThatFavoredThisFavorable']);
    Route::post('{set}/favored', [FavorableController::class, 'markFavorableFavorite']);
});

Route::group(['prefix' => 'c'], function () {

    Route::get('search', 'Web\ContentController@search');
    Route::get('uploadContent',         [ContentController::class, 'uploadContent'])->name('c.upload.content');
    Route::get('createArticle',         [ContentController::class, 'createArticle'])->name('c.create.article');
    Route::post('updateTmpDescription',  [ContentController::class, 'createArticle'])->name('c.update.pending.description');

    Route::get('{c}/favored', [FavorableController::class, 'getUsersThatFavoredThisFavorable']);
    Route::post('{c}/favored', [FavorableController::class, 'markFavorableFavorite']);

    Route::post('{c}/updateSet' , [ContentController::class, 'updateSet'])->name('c.updateSet');

    Route::group(['prefix' => '{c}/attach'], function () {
        Route::post('set/{set}', 'Web\ContentController@attachContentToContentSet');
        Route::put('set/{set}', 'Web\ContentController@updateContentSetPivots');
    });
});

Route::group(['prefix' => 'product'], function () {
    Route::get('{product}/favored', [FavorableController::class, 'getUsersThatFavoredThisFavorable']);
    Route::post('{product}/favored', [FavorableController::class, 'markFavorableFavorite']);
});

Route::resource('product', 'Web\ProductController');
Route::resource('set', 'Web\SetController');
Route::resource('c', 'Web\ContentController')->names([
    'index' => 'content.index'
]);;
Route::resource('sanatisharifmerge', 'Web\SanatisharifmergeController');
Route::resource('article', 'Web\ArticleController');
Route::resource('block', 'Web\BlockController');
Auth::routes(['verify' => true]);

Route::group(['prefix' => 'mobile'], function () {
    Route::get('verify', [MobileVerificationController::class, 'show'])->name('mobile.verification.notice');
    Route::post('verify', [MobileVerificationController::class, 'verify'])->name('mobile.verification.verify');
    Route::get('resend', [MobileVerificationController::class, 'resend'])->name('mobile.verification.resend');
});
Route::post('cd3b472d9ba631a73cb7b66ba513df53', 'Web\CouponController@generateRandomCoupon');

Route::get('tree', 'Web\TopicsTreeController@lernitoTree');
Route::get('tree/getArrayString/{lnid}', 'Web\TopicsTreeController@getTreeInPHPArrayString');
Route::get('tree/ignoreUpdateItem/{iuid}', 'Web\TopicsTreeController@ignoreUpdateItem');
Route::any('goToPaymentRoute/{paymentMethod}/{device}/', '\\'.RedirectAPIUserToPaymentRoute::class)->name('redirectToPaymentRoute');
