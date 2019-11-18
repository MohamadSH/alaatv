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


// Impression Click
$(document).on('click' ,'.a--gtm-eec-product-click', function(e){
    GAEE.impressionClick($(this));
});

// Promotion Click
$(document).on('click' ,'.a--gtm-eec-advertisement-click', function(e){
    GAEE.promotionClick($(this));
});