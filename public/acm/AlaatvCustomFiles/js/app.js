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


    function checkNoCache() {
        var userId = GlobalJsVar.userId();
        if (userId.trim().length===0) {
            Cookie.set('nocache', 0, 1);
        } else {
            Cookie.set('nocache', 1, 1);
        }
    }

});

let imageObserver = LazyLoad.image();
let gtmEecProductObserver = LazyLoad.gtmEecProduct();
let gtmEecAdvertisementObserver = LazyLoad.gtmEecAdvertisement();

// Bootstrap 4 carousel lazy load
LazyLoad.carousel([imageObserver, gtmEecAdvertisementObserver]);

// top menu in mobile view
if ($('#m_aside_header_topbar_mobile_toggle1').length > 0) {
    $('#m_aside_header_topbar_mobile_toggle1')[0].addEventListener("click", function(e) {
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

// Impression Click
$(document).on('click' ,'.a--gtm-eec-product-click', function(e){
    GAEE.impressionClick($(this));
});

// Promotion Click
$(document).on('click' ,'.a--gtm-eec-advertisement-click', function(e){
    GAEE.promotionClick($(this));
});
