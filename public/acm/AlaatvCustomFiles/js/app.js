var AppGlobalInitInit = function() {

    var LazyLoad;

    function initVars(data) {
        LazyLoad = (typeof data.LazyLoad !== 'undefined') ? data.LazyLoad : null;
    }

    function initLazyLoad() {
        if (LazyLoad !== null) {
            window.imageObserver = LazyLoad.image();
            window.gtmEecProductObserver = LazyLoad.gtmEecProduct();
            window.gtmEecAdvertisementObserver = LazyLoad.gtmEecAdvertisement();
            // Bootstrap 4 carousel lazy load
            LazyLoad.carousel([imageObserver, gtmEecAdvertisementObserver]);
        }
    }

    function addGtmEecEvents() {
        // Impression Click
        $(document).on('click' ,'.a--gtm-eec-product-click', function(e){
            GAEE.impressionClick($(this));
        });

        // Promotion Click
        $(document).on('click' ,'.a--gtm-eec-advertisement-click', function(e){
            GAEE.promotionClick($(this));
        });
    }

    function addClickEventofBtnProfileInMobileView() {
        if ($('#m_aside_header_topbar_mobile_toggle1').length > 0) {
            $('#m_aside_header_topbar_mobile_toggle1')[0].addEventListener('click', function(e) {
                var element = $('.m-nav__item.m-topbar__user-profile')[0].closest('.m-dropdown');
                var dropdown;

                if (mUtil.data(element).has('dropdown')) {
                    dropdown = mUtil.data(element).get('dropdown');
                } else {
                    dropdown = new mDropdown(element);
                }

                dropdown.toggle();

                e.stopPropagation();
                e.preventDefault();
            });
        }
    }

    function addEvents() {
        addClickEventofBtnProfileInMobileView();
        addGtmEecEvents();
    }

    function initFirebase() {
        Firebase.init({
            firebaseConfig: {
                apiKey: "AIzaSyBMSKsBzEFtfBHkudjHuLr9brCuRUJQYX4",
                authDomain: "alaa-office.firebaseapp.com",
                databaseURL: "https://alaa-office.firebaseio.com",
                projectId: "alaa-office",
                storageBucket: "alaa-office.appspot.com",
                messagingSenderId: "300754869233",
                appId: "1:300754869233:web:c730b68385257132ed8250",
                measurementId: "G-V614DM1FRK"
            },
            VapidKey: 'BKJlaTO0dnXtHHFho3i53VF_mGMkyxSv0dnC7ldF1wTZ8sRgXQIzYu2P4O3l2n0yKQ0H8BYcq86VOjbHAKAIFZY',
            showMessage: function (payload) {
                console.log(payload);
                toastr.info( '<img src="'+payload.data.icon+'" width="50" class="m--margin-right-10">' + payload.data.title + '<br>' + payload.data.body);
            },
            sendTokenToServer: function (currentToken) {

            },
            updateUIForPushEnabled: function (currentToken) {

            },
            updateUIForPushPermissionRequired: function () {

            }
        });
    }

    function initGoogleTagManager() {
        window.dataLayer = window.dataLayer || [];
        var userIpDimensionValue = GlobalJsVar.userIp();
        var userIdDimensionValue = GlobalJsVar.userId();
        dataLayer.push({
            'userIp': userIpDimensionValue,
            'dimension2': userIpDimensionValue,
            'userId': userIdDimensionValue,
            'user_id': userIdDimensionValue
        });
    }

    function init(data) {
        initVars(data)
        initLazyLoad();
        addEvents();
        // initFirebase();
        initGoogleTagManager();
    }

    return {
        init: init
    };
}();

AppGlobalInitInit.init({
    LazyLoad: LazyLoad
});
