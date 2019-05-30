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