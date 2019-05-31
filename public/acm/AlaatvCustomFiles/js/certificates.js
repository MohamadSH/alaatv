$('.alaaAlert').fadeOut(0);
$('.hightschoolAlert').fadeOut(0);
$(document).on('click', '.certificatesLogo', function(){
    let logoName = $(this).data('name');
    console.log(logoName);
    if (logoName === 'alaa') {
        $('.hightschoolAlert').fadeOut(0);
        $('.alaaAlert').slideDown();
    } else if (logoName === 'sharif-school') {
        $('.alaaAlert').fadeOut(0);
        $('.hightschoolAlert').slideDown();
    } else {
        $('.alaaAlert').fadeOut(0);
        $('.hightschoolAlert').fadeOut(0);
    }
});
$( window ).resize(function() {
    initCertificatesItemsHeight();
});
function initCertificatesItemsHeight() {
    var calcTop = ($('.certificates-col').height()/2)-($('.certificates-items').height()/2);
    $('.certificates-items').css({'position':'absolute', 'top':calcTop+'px'});
}

$(document).ready(function () {
    initCertificatesItemsHeight();
});