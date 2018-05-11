<?php
/**
 * Created by PhpStorm.
 * User: mohamamad
 * Date: 11/9/2016
 * Time: 4:41 PM
 */

return [
    // Default Roles
    'ROLE_ADMIN'  => 'admin',
    'ROLE_CONSULTANT'  => 'consultant',
    'ROLE_TECH'  => 'tech',
    'EMPLOYEE_ROLE'  => 'employee', // Couldn't use ROLE_EMPLOYEE because it returns 6 instead of employee!
    'BOOK_POST_MAN_ROLE'=>'bookPostMan' ,
    'SHARIF_SCHOOL_REGISTER' => 'sharifSchoolRegister',
    // Permissions :
    'ADMIN_PANEL_ACCESS' => "adminPanel",
    'GIVE_SYSTEM_ROLE' => "giveSystemRole" ,
    'USER_ADMIN_PANEL_ACCESS' => "userAdminPanel",
    'PRODUCT_ADMIN_PANEL_ACCESS' => "productAdminPanel",
    'CONTENT_ADMIN_PANEL_ACCESS' => "contentAdminPanel",
    'SMS_ADMIN_PANEL_ACCESS' => 'smsAdminPanel',
    'ORDER_ADMIN_PANEL_ACCESS' => 'orderAdminPanel',
    'SITE_CONFIG_ADMIN_PANEL_ACCESS' => 'siteConfigAdminPanel',
    'LIST_ASSIGNMENT_ACCESS'=>'listAssignment',
    'INSERT_ASSIGNMENT_ACCESS' => "insertAssignment",
    'EDIT_ASSIGNMENT_ACCESS' => "editAssignment",
    'REMOVE_ASSIGNMENT_ACCESS'=>'removeAssignment',
    'SHOW_ASSIGNMENT_ACCESS'=>'showAssignment',
    'LIST_CONSULTATION_ACCESS'=>'listConsultation',
    'INSERT_CONSULTATION_ACCESS' => "insertConsultation",
    'EDIT_CONSULTATION_ACCESS' => "editConsultation",
    'REMOVE_CONSULTATION_ACCESS'=>'removeConsultation',
    'SHOW_CONSULTATION_ACCESS'=>'showConsultation',
    'LIST_USER_ACCESS'=>'listUser',
    'INSERT_USER_ACCESS' => "insertUser",
    'EDIT_USER_ACCESS' => "editUser",
    'REMOVE_USER_ACCESS'=>'removeUser',
    'SHOW_USER_ACCESS'=>'showUser',
    'SEND_SMS_TO_USER_ACCESS'=>'sendSMSUser',
    'INSERT_USER_BON_ACCESS' => 'insertUserBon',
    'LIST_USER_BON_ACCESS' => 'listUserBon',
    'REMOVE_USER_BON_ACCESS' => 'removeUserBon',
    'DOWNLOAD_ASSIGNMENT_ACCESS' => 'downloadAssignment',
    'DOWNLOAD_PRODUCT_FILE' => 'downloadProductFile',
    'LIST_PRODUCT_ACCESS'=>'listProduct',
    'INSERT_PRODUCT_ACCESS' => "insertProduct",
    'EDIT_PRODUCT_ACCESS' => "editProduct",
    'REMOVE_PRODUCT_ACCESS'=>'removeProduct',
    'COPY_PRODUCT_ACCESS'=>'copyProduct',
    'SHOW_PRODUCT_ACCESS'=>'showProduct',
    'LIST_ORDER_ACCESS'=>'listOrder',
    'INSERT_ORDER_ACCESS' => "insertOrder",
    'EDIT_ORDER_ACCESS' => "editOrder",
    'REMOVE_ORDER_ACCESS'=>'removeOrder',
    'SHOW_ORDER_ACCESS'=>'showOrder',
    'SHOW_OPENBYADMIN_ORDER' => 'showOpenByAdminOrders',
    'LIST_PERMISSION_ACCESS'=>'listPermission',
    'INSERT_PERMISSION_ACCESS' => "insertPermission",
    'EDIT_PERMISSION_ACCESS' => "editPermission",
    'REMOVE_PERMISSION_ACCESS'=>'removePermission',
    'SHOW_PERMISSION_ACCESS'=>'showPermission',
    'INSET_USER_ROLE'=>'insertUserRole',
    'LIST_COUPON_ACCESS'=>'listCoupon',
    'INSERT_COUPON_ACCESS' => "insertCoupon",
    'EDIT_COUPON_ACCESS' => "editCoupon",
    'REMOVE_COUPON_ACCESS'=>'removeCoupon',
    'SHOW_COUPON_ACCESS'=>'showCoupon',
    'LIST_QUESTION_ACCESS'=>'listStudentQuestion',
    'CONSULTANT_PANEL_ACCESS'=>'consultantPanel',
    'SHOW_QUESTION_ACCESS'=>'showStudentQuestion',
    'LIST_ATTRIBUTE_ACCESS'=>'listAttribute',
    'INSERT_ATTRIBUTE_ACCESS' => "insertAttribute",
    'EDIT_ATTRIBUTE_ACCESS' => "editAttribute",
    'REMOVE_ATTRIBUTE_ACCESS'=>'removeAttribute',
    'SHOW_ATTRIBUTE_ACCESS'=>'showAttribute',
    'LIST_ATTRIBUTESET_ACCESS'=>'listAttributeset',
    'INSERT_ATTRIBUTESET_ACCESS' => "insertAttributeset",
    'EDIT_ATTRIBUTESET_ACCESS' => "editAttributeset",
    'REMOVE_ATTRIBUTESET_ACCESS'=>'removeAttributeset',
    'SHOW_ATTRIBUTESET_ACCESS'=>'showAttributeset',
    'LIST_ATTRIBUTEVALUE_ACCESS'=>'listAttributevalue',
    'INSERT_ATTRIBUTEVALUE_ACCESS' => "insertAttributevalue",
    'EDIT_ATTRIBUTEVALUE_ACCESS' => "editAttributevalue",
    'REMOVE_ATTRIBUTEVALUE_ACCESS'=>'removeAttributevalue',
    'SHOW_ATTRIBUTEVALUE_ACCESS'=>'showAttributevalue',
    'LIST_ATTRIBUTEGROUP_ACCESS'=>'listAttributegroup',
    'INSERT_ATTRIBUTEGROUP_ACCESS' => "insertAttributegroup",
    'EDIT_ATTRIBUTEGROUP_ACCESS' => "editAttributegroup",
    'REMOVE_ATTRIBUTEGROUP_ACCESS'=>'removeAttributegroup',
    'SHOW_ATTRIBUTEGROUP_ACCESS'=>'showAttributegroup',
    'LIST_TRANSACTION_ACCESS'=>'listTransaction',
    'SHOW_TRANSACTION_TOTAL_COST_ACCESS'=>'showTransactionTotalCost',
    'SHOW_TRANSACTION_TOTAL_FILTERED_COST_ACCESS'=>'showTransactionTotalFilteredCost',
    'EDIT_TRANSACTION_ACCESS' => 'editTransaction',
    'INSERT_TRANSACTION_ACCESS' => 'insertTransaction' ,
    'SHOW_TRANSACTION_ACCESS'=> 'showTransaction' ,
    'EDIT_TRANSACTION_ORDERID_ACCESS' => 'editTransactionOrderID',
    'LIST_MBTIANSWER_ACCESS'=>'listMBTIAnswer',
    'LIST_CONTACT_ACCESS'=>'listContact',
    'INSERT_CONTACT_ACCESS' => "insertContact",
    'EDIT_CONTACT_ACCESS' => "editContact",
    'REMOVE_CONTACT_ACCESS'=>'removeContact',
    'SHOW_USER_EMAIL'=>'showUserEmail',
    'SHOW_USER_MOBILE'=>'showUserMobile',
    'SHOW_ARTICLE_ACCESS' => 'showArticle',
    'LIST_ARTICLE_ACCESS' => 'listArticle',
    'INSERT_ARTICLE_ACCESS' => 'insertArticle',
    'EDIT_ARTICLE_ACCESS' => "editArticle",
    'REMOVE_ARTICLE_ACCESS' => 'removeArticle',
    'SHOW_ARTICLECATEGORY_ACCESS' => 'showArticlecategory',
    'LIST_ARTICLECATEGORY_ACCESS' => 'listArticlecategory',
    'INSERT_ARTICLECATEGORY_ACCESS' => 'insertArticlecategory',
    'EDIT_ARTICLECATEGORY_ACCESS' => "editArticlecategory",
    'REMOVE_ARTICLECATEGORY_ACCESS' => 'removeArticlecategory',
    'LIST_SLIDESHOW_ACCESS'=>'listSlideShow',
    'INSERT_SLIDESHOW_ACCESS' => "insertSlideShow",
    'EDIT_SLIDESHOW_ACCESS' => "editSlideShow",
    'REMOVE_SLIDESHOW_ACCESS'=>'removeSlideShow',
    'SHOW_SLIDESHOW_ACCESS'=>'showSlideShow',
    'LIST_CONFIGURE_PRODUCT_ACCESS'=>'listConfigureProduct',
    'INSERT_CONFIGURE_PRODUCT_ACCESS' => "insertConfigureProduct",
    'EDIT_CONFIGURE_PRODUCT_ACCESS' => "editConfigureProduct",
    'REMOVE_CONFIGURE_PRODUCT_ACCESS'=>'removeConfigureProduct',
    'SHOW_CONFIGURE_PRODUCT_ACCESS'=>'showConfigureProduct',
    'LIST_PRODUCT_FILE_ACCESS'=>'listProductFile',
    'LIST_PRODUCT_SAMPLE_PHOTO_ACCESS' => 'listProductSamplePhoto' ,
    'INSERT_PRODUCT_SAMPLE_PHOTO_ACCESS' => 'insertProductSamplePhoto' ,
    'EDIT_PRODUCT_SAMPLE_PHOTO_ACCESS' => 'editProductSamplePhoto',
    'REMOVE_PRODUCT_SAMPLE_PHOTO_ACCESS' => 'removeProductSamplePhoto',
    'INSERT_PRODUCT_FILE_ACCESS' => "insertProductFile",
    'EDIT_PRODUCT_FILE_ACCESS' => "editProductFile",
    'REMOVE_PRODUCT_FILE_ACCESS'=>'removeProductFile',
    'SHOW_PRODUCT_FILE_ACCESS'=>'showProductFile',
    'LIST_SITE_CONFIG_ACCESS'=>'listSiteSetting',
    'INSERT_SITE_CONFIG_ACCESS' => "insertSiteSetting",
    'EDIT_SITE_CONFIG_ACCESS' => "editSiteSetting",
    'REMOVE_SITE_CONFIG_ACCESS'=>'removeSiteSetting',
    'SHOW_SITE_CONFIG_ACCESS'=>'showSiteSetting',
    'LIST_EVENTRESULT_ACCESS' => 'listEventResult',
    'LIST_SHARIF_REGISTER_ACCESS' => 'listSharifRegister',
    'LIST_BELONGING_ACCESS'=>'listBelonging' ,
    'INSERT_BELONGING_ACCESS'=>'insertBelonging',
    'REMOVE_BELONGING_ACCESS'=>'removeBelonging',
    'LIST_EDUCATIONAL_CONTENT_ACCESS' => 'listEducationalContent' ,
    'INSERT_EDUCATIONAL_CONTENT_ACCESS' => 'insertEducationalContent',
    "EDIT_EDUCATIONAL_CONTENT" => 'editEducationalContent',
    'REMOVE_EDUCATIONAL_CONTENT_ACCESS' => 'removeEducationalContent',
    'SHOW_EDUCATIONAL_CONTENT_ACCESS' => 'showEducationalContent',
    'REPORT_ADMIN_PANEL_ACCESS' => 'reportAdminPanelAccess',
    'INSERT_EMPLOPYEE_WORK_SHEET' => 'insertEmployeeWorkSheet' ,
    'LIST_EMPLOPYEE_WORK_SHEET' => 'listEmployeeWorkSheet' ,
    'EDIT_EMPLOPYEE_WORK_SHEET' => 'editEmployeeWorkSheet' ,
    'REMOVE_EMPLOPYEE_WORK_SHEET' => 'removeEmployeeWorkSheet' ,
    'ORDER_ANY_THING' => 'orderAnyThing' ,
    'GET_BOOK_SELL_REPORT' => 'getBookSellReport' ,
    'SEE_PAID_COST' =>'seePaidCost' ,
    'INSERT_MAJOR' => 'insertMajor' ,
    'GET_USER_REPORT' => 'getUserReport',
    'TELEMARKETING_PANEL_ACCESS' => 'telemarketingPanel',


    //Technician
    'SET_TECH_CODE' => 'insertTechCode',
    'UPDATE_TECH_CODE' => 'updateTechCode',

    //bons
    'BON1'=>'alaa',
    'BON2' =>'alaaPoint',

    //fileSystem disks
    'DISK1' => 'profileImage',
    'DISK2' => 'assignmentQuestionFile',
    'DISK3' => 'assignmentSolutionFile',
    'DISK4' => 'productImage',
    'DISK5' => 'productCatalog_PDF',
    'DISK6' => 'consultingAudioQuestions',
    'DISK7' => 'consultationThumbnail',
    'DISK8' => 'articleImage',
    'DISK9' => 'homeSlideShowPic',
    'DISK10' => 'orderFile',
    'DISK11' => 'general',
    'DISK12' => 'belongingIDCard',
    'DISK13' => 'productFile',
    'DISK14' => 'eventReport',
    'DISK15' => 'articleSlideShowPic',
    'DISK16' => 'digitalSignatureCertificates',
    'DISK17' => 'digitalSignatures' ,
    'DISK18'=>'exam',
    'DISK18_CLOUD'=>'examSftp',
    'DISK19'=>'pamphlet',
    'DISK19_CLOUD'=>'pamphletSftp',
    'DISK20'=>'book',
    'DISK20_CLOUD'=>'bookSftp',

    //Profile default image
    'PROFILE_DEFAULT_IMAGE' => 'default_avatar.png',
    'CONSULTATION_DEFAULT_IMAGE' => 'default_consultant_thumbnail.jpg',
    'ARTICLE_DEFAULT_IMAGE' =>'default_article_image.png',

    //Mobile verification code wait expiration (in minutes)
    'MOBILE_VERIFICATION_TIME_LIMIT'=>'30',
    'MOBILE_VERIFICATION_WAIT_TIME'=>'14' , //waiting time between sending two mobile verification code sms
    'GENERATE_PASSWORD_WAIT_TIME'=>'14' , //waiting time between sending two password sms

    //Number of mbti questions (it is temporary)
    'MBTI_NUMBER_OF_QUESTIONS' => '80',

    //loading gif
    'FILTER_LOADING_GIF' => '/assets/extra/loading-cogs.gif',
    'ADMIN_LOADING_BAR_GIF' => '/assets/extra/filter-loading-bar.gif',

    //sms payment
    'COST_PER_SMS_1' => 100,
    'COST_PER_SMS_2' => 110,
    'COST_PER_SMS_3' => 130,

    'SMS_PROVIDER_NUMBER' => [
        "phone" => [
            98100020400 => 98100020400,
            9810000066009232 => 9810000066009232,
            98100009 => 98100009,
            98500010409232 => 98500010409232,
            985000145 => 985000145,
            985000949 => 985000949,
            "98sim" => "98sim"
        ],
        "cost" => [
            98100020400 => 110,
            9810000066009232 => 110,
            98100009 => 110,
            98500010409232 => 95,
            985000145 => 95,
            985000949 => 95,
            "98sim" => 130
        ]
    ],
    'google' => [
        'analytics' => env('GOOGLE_ANALYTICS','UA-43695756-1'),
    ],


    'UI_META_TITLE_LIMIT' =>  70 ,
    'UI_META_KEYWORD_LIMIT' =>  155 ,
    'UI_META_DESCRIPTION_LIMIT' => 155 ,
    'META_TITLE_LIMIT' => 129 ,
    'META_KEYWORDS_LIMIT' => 286 ,
    'META_DESCRIPTION_LIMIT' => 286,

    'WORKDAY_ID_USUAL' => 1,
    'WORKDAY_ID_EXTRA'=> 2,
    'HAMAYESH_PRODUCT' => [119 , 123 , 127 , 131 , 135 , 139 , 143 , 147 , 151 , 155 , 159 , 163] ,
    'HAMAYESH_CHILDREN' => [124 , 125 ,120,121 , 164,165 , 160 , 161 , 156 , 157 , 152,153 , 148,149,144 , 145 , 140 , 141,136,    137,132,133,128,129] ,
    'ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT'=>[196,200,201,203,204,205,206],
    'ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ROOT'=>196,
    'ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ALLTOGHETHER'=>206,
    'ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_DEFAULT'=>204,
    'ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_NOT_DEFAULT'=>[200 , 201  , 203 , 205],
    'ORDOO_HOZOORI_NOROOZ_97_PRODUCT'=>[184,185,186 ],
    'HOME_EXCLUDED_PRODUCTS' => [119,123,127,131,135,139,143,147,151,155,159,163,110,112],
//    'HOME_PRODUCTS_OFFER' => [104 , 91 , 92],
    'EXCLUDED_RELATED_PRODUCTS' => [110 , 112 , 104 , 91 , 92],
    'EXCLUSIVE_RELATED_PRODUCTS' => [91 , 92 , 104] ,
    'EDUCATIONAL_CONTENT_EXCLUDED_PRODUCTS' => [110,112],
    'PRODUCT_SEARCH_EXCLUDED_PRODUCTS' => [119,123,127,131,135,139,143,147,151,155,159,163],
    'DONATE_PRODUCT' => [180],
    'HAMAYESH_DEY_LOTTERY'=> 'hamyeshDey',
    'HAMAYESH_LOTTERY_EXCHANGE_DISCOUNT' => 35,

    //Cache
    'CACHE_600' => 600,
    'CACHE_60' => 60,
    'CACHE_10' => 0,
    'CACHE_5' => 0,
    'CACHE_3' => 0,
    'CACHE_1' =>0 ,

];
