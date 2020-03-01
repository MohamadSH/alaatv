// change quality in mobile fix
$(document).on('touchend', '.vjs-menu-content.vjs-qlist li', function(e) {
    $('.vjs-menu-content.vjs-qlist li[data-res="'+$(this).attr('data-res')+'"]').trigger('click');
});
