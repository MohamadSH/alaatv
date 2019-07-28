$(document).ready( function() {

    /*
     * Google TagManager
     */
    window.dataLayer = window.dataLayer || [];
    var userIpDimensionValue = $('#js-var-userIp').val();
    var userIdDimensionValue = $('#js-var-userId').val();
    dataLayer.push({
        'userIp': userIpDimensionValue,
        'dimension2': userIpDimensionValue,
        'userId': userIdDimensionValue,
        'user_id': userIdDimensionValue
    });

    // toastr.options = {
    //     "closeButton": false,
    //     "debug": false,
    //     "newestOnTop": false,
    //     "progressBar": false,
    //     "positionClass": "toast-bottom-full-width",
    //     "preventDuplicates": false,
    //     "onclick": null,
    //     "showDuration": "300",
    //     "hideDuration": "1000",
    //     "timeOut": "5000",
    //     "extendedTimeOut": "1000",
    //     "showEasing": "swing",
    //     "hideEasing": "linear",
    //     "showMethod": "fadeIn",
    //     "hideMethod": "fadeOut"
    // };


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