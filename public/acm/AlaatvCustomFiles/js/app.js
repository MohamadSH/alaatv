var AppGlobalInitInit = function() {

    var LazyLoad,
        Firebase;

    function initData(data) {
        LazyLoad = (typeof data.LazyLoad !== 'undefined') ? data.LazyLoad : null;
        Firebase = (typeof data.Firebase !== 'undefined') ? data.Firebase : null;
    }

    function initLazyLoad() {
        if (LazyLoad === null) {
            return;
        }
        window.imageObserver = LazyLoad.image();
        window.gtmEecProductObserver = LazyLoad.gtmEecProduct();
        window.gtmEecAdvertisementObserver = LazyLoad.gtmEecAdvertisement();
        // Bootstrap 4 carousel lazy load
        LazyLoad.carousel([imageObserver, gtmEecAdvertisementObserver]);
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

    function addClickEventOfBtnProfileInMobileView() {
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

    function addLoginBeforeClickEvent() {
        $(document).on('click', '.LoginBeforeClick', function () {
            var userId = GlobalJsVar.userId(),
                link = $(this).attr('data-href');
            if (userId.length > 0) {
                window.location.href = link;
            } else {
                AjaxLogin.showLogin(GlobalJsVar.loginActionUrl(), link);
            }
        });
    }

    function addEvents() {
        addClickEventOfBtnProfileInMobileView();
        addGtmEecEvents();
        addLoginBeforeClickEvent();
    }

    function initFirebase() {
        var fc = GlobalJsVar.getVar('firebaseConfig');
        fc = JSON.parse(fc);

        if (Firebase === null || typeof fc.firebaseConfig === 'undefined' || fc.firebaseConfig === null || fc.firebaseConfig === '') {
            return;
        }

        window.FirebaseObject = Firebase.init({
            firebaseConfig: fc.firebaseConfig,
            VapidKey: fc.VapidKey,
            ConsoleReport: fc.ConsoleReport,
            showMessage: function (payload) {
                if (typeof payload.data.script !== 'undefined') {
                    var payloadScript = payload.data.script,
                        payloadScriptFunction = new Function(payloadScript);
                    payloadScriptFunction();
                }
                if (typeof payload.data.title !== 'undefined') {
                    var title = payload.data.title,
                        body = (typeof payload.data.body !== 'undefined') ? payload.data.body : '',
                        icon = (typeof payload.data.icon !== 'undefined') ? payload.data.icon : '';
                    toastr.info( '<img src="'+icon+'" width="50" class="m--margin-right-10">' + title + '<br>' + body);
                }
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
        initData(data);
        initLazyLoad();
        addEvents();
        initFirebase();
        initGoogleTagManager();
    }

    return {
        init: init
    };
}();

AppGlobalInitInit.init({
    LazyLoad: LazyLoad,
    Firebase: Firebase
});
