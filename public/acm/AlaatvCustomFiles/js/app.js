var AppGlobalInit = function() {

    function ajaxSetup() {
        $(function () {
            /**
             * Set token for ajax request
             */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                }
            });
        });
    }

    function initFlash() {
        flashGAEE();
        showFlashMessage();
    }

    function flashGAEE() {
        var gaee  = Cookie.get('gaee');
        if (gaee.trim().length === 0 || !isJson(gaee)) {
            return;
        }
        gaee = JSON.parse(gaee);
        for (var i = 0; (typeof gaee[i] !== 'undefined'); i++) {
            applyGAEE(gaee[i]);
        }
        Cookie.remove('gaee');
    }

    function applyGAEE(gaeeItem) {
        var actionFieldList = gaeeItem.actionFieldList;
        if (actionFieldList === 'product.addToCart') {
            var products = gaeeItem.products;
            GAEE.productAddToCart('product.addToCart', products);
        } else if (actionFieldList === 'impressionView') {
            var impressions = gaeeItem.impressions;
            GAEE.productAddToCart(impressions);
        }
    }

    function showFlashMessage() {
        var flashMessage  = Cookie.get('flashMessage');
        if (flashMessage.trim().length === 0) {
            return;
        }

        if (isJson(flashMessage)) {
            flashMessage = JSON.parse(flashMessage);
            flashMessage.title = flashMessage.title.split('+').join(' ');
            flashMessage.body = flashMessage.body.split('+').join(' ');
            showAlaaAppModal(flashMessage.title, flashMessage.body);
        } else {
            showAlaaAppModal('', flashMessage);
        }
        Cookie.remove('flashMessage');
    }

    function isJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }

    function getModalTemplate(title, content) {
        return '' +
            '<div class="modal" tabindex="-1" role="dialog" id="AlaaAppModal">\n' +
            '  <div class="modal-dialog modal-dialog-centered" role="document">\n' +
            '    <div class="modal-content">\n' +
            '      <div class="modal-header">\n' +
            '        <h5 class="modal-title">'+title+'</h5>\n' +
            '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\n' +
            '          <span aria-hidden="true">&times;</span>\n' +
            '        </button>\n' +
            '      </div>\n' +
            '      <div class="modal-body">\n' +
            '         \n' + content +
            '      </div>\n' +
            '      <div class="modal-footer">\n' +
            '        <button type="button" class="btn btn-secondary d-none" data-dismiss="modal">بستن</button>\n' +
            '      </div>\n' +
            '    </div>\n' +
            '  </div>\n' +
            '</div>';
    }

    function checkExistLoginModal() {
        return ($('#AlaaAppModal').length !== 0);
    }

    function appendLoginModalToBody(title, content) {
        $('body').append(getModalTemplate(title, content));
    }

    function setAlaaAppModalData(title, content) {
        $('#AlaaAppModal .modal-body').html(content);
        $('#AlaaAppModal .modal-title').html(title);
    }

    function showAlaaAppModal(title, content) {
        if (!checkExistLoginModal()) {
            appendLoginModalToBody(title, content);
        } else {
            setAlaaAppModalData(title, content)
        }
        $('#AlaaAppModal').modal('show');
    }

    function initLazyLoad() {
        if (!isDefined('LazyLoad')) {
            return;
        }
        window.imageObserver = window.LazyLoad.image();
        window.gtmEecProductObserver = window.LazyLoad.gtmEecProduct();
        window.gtmEecAdvertisementObserver = window.LazyLoad.gtmEecAdvertisement();
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


        $("#carouselMainSlideShow").on('slid.bs.carousel', function (e) {
            window.imageObserver.observe();
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
        if (!isDefined('GlobalJsVar')) {
            return;
        }
        $(document).on('click', '.LoginBeforeClick', function () {
            var userId = window.GlobalJsVar.userId(),
                link = $(this).attr('data-href');
            if (userId.length > 0) {
                window.location.href = link;
            } else {
                AjaxLogin.showLogin(window.GlobalJsVar.loginActionUrl(), link);
            }
        });
    }

    function addEvents() {
        addClickEventOfBtnProfileInMobileView();
        addGtmEecEvents();
        addLoginBeforeClickEvent();
    }

    function initFirebase() {
        if (!isDefined('Firebase') || !isDefined('GlobalJsVar')) {
            return;
        }

        var fc = window.GlobalJsVar.getVar('firebaseConfig');
        fc = JSON.parse(fc);

        if (typeof fc.firebaseConfig === 'undefined' || fc.firebaseConfig === null || fc.firebaseConfig === '') {
            return;
        }

        window.FirebaseObject = window.Firebase.init({
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
        if (!isDefined('GlobalJsVar')) {
            return;
        }
        window.dataLayer = window.dataLayer || [];
        var userIpDimensionValue = window.GlobalJsVar.userIp();
        var userIdDimensionValue = window.GlobalJsVar.userId();
        dataLayer.push({
            'userIp': userIpDimensionValue,
            'dimension2': userIpDimensionValue,
            'userId': userIdDimensionValue,
            'user_id': userIdDimensionValue
        });
    }

    function initAlaaAdBanner() {
        if (!isDefined('AlaaAdBanner') || !isDefined('GlobalJsVar')) {
            return;
        }
        window.AlaaAdBanner.promote(JSON.parse(window.GlobalJsVar.getVar('AlaaAdBanner')));
    }

    function isDefined(object) {
        return (typeof window[object] !== 'undefined' && window[object] !== null)
    }

    function init() {
        ajaxSetup();
        initLazyLoad();
        addEvents();
        initFirebase();
        initGoogleTagManager();
        initFlash();
        initAlaaAdBanner();
    }

    return {
        init: init
    };
}();

jQuery(document).ready( function() {
    AppGlobalInit.init();
});
