$('body').addClass('m-aside-left--hide');
$(document).ready(function () {
    let messageHeight = $('.errorPage .message').height();
    $('.errorPage .message').css({'top':'calc( 50% - ' + (messageHeight/2) + 'px)'});
});