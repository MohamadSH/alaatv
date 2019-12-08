$(document).ready( function() {

    /*
     * Google TagManager
     */
    window.dataLayer = window.dataLayer || [];
    var userIpDimensionValue = GlobalJsVar.userIp();
    var userIdDimensionValue = GlobalJsVar.userId();
    dataLayer.push({
        'userIp': userIpDimensionValue,
        'dimension2': userIpDimensionValue,
        'userId': userIdDimensionValue,
        'user_id': userIdDimensionValue
    });

});

let imageObserver = LazyLoad.image();
let gtmEecProductObserver = LazyLoad.gtmEecProduct();
let gtmEecAdvertisementObserver = LazyLoad.gtmEecAdvertisement();

// Bootstrap 4 carousel lazy load
LazyLoad.carousel([imageObserver, gtmEecAdvertisementObserver]);

// top menu in mobile view
$(document).on('click', '#m_aside_header_topbar_mobile_toggle1', function () {
    $('#m_header_topbar .m-topbar__nav .m-nav__item.m-topbar__user-profile').toggleClass('m-dropdown--open');
});

// Impression Click
$(document).on('click' ,'.a--gtm-eec-product-click', function(e){
    GAEE.impressionClick($(this));
});

// Promotion Click
$(document).on('click' ,'.a--gtm-eec-advertisement-click', function(e){
    GAEE.promotionClick($(this));
});
