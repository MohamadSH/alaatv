(function ($) {
  "use strict";

  $('.navbar-header .menu-item-has-children').on('click', function () {
    $(this).toggleClass('open');
  });

  /*-------------------------------------
        </> @author Mohammadreza pazani
     </> MTabs
     </> @version 1.0
     </> @version 1.0.1 Initial tab
     </> @version 1.0.2 Default tab
     </> @version 1.0.3 Navigation arrows
     </> @version 1.0.4 Initial default tab if it isn't initialed
    ------------------------------------*/
  $('[data-tabindex]').each(function () {
    var index = $(this).attr('data-tabindex');
    var active = false;
    $('[data-tabindex="' + index + '"] [data-tabc]').hide();
    $('[data-tabindex="' + index + '"] .tab-title [data-tab]').each(function () {
      if ($(this).hasClass('active')) {
        var i = $(this).attr('data-tab');
        $('[data-tabindex="' + index + '"] [data-tabc="' + i + '"]').fadeIn();
        active = true;
        return false;
      }
    });
    if (active === false) {
      $('[data-tabindex="' + index + '"] [data-tabc]:first-of-type').fadeIn();
      $('[data-tabindex="' + index + '"] [data-tab]:first-of-type').addClass('active');
    }
    $('[data-tabindex="' + index + '"] .tab-title [data-tab]')
      .on('click', function () {
        var t = $(this).attr('data-tab');
        $('[data-tabindex="' + index + '"] .tab-title [data-tab]').removeClass('active');
        $(this).addClass('active');
        $('[data-tabindex="' + index + '"] [data-tabc]').hide();
        $('[data-tabindex="' + index + '"] [data-tabc="' + t + '"]').fadeIn();
      });
    $('[data-tabindex="' + index + '"]  nav .prev').on('click', function () {
      var t = parseInt($('[data-tabindex="' + index + '"]  .tab-title [data-tab].active').attr('data-tab')) - 1;
      if (t == 0)
        return false;
      $('[data-tabindex="' + index + '"] .tab-title [data-tab].active').removeClass('active');
      $('[data-tabindex="' + index + '"] [data-tabc]').hide();
      $('[data-tabindex="' + index + '"] [data-tab="' + t + '"]').addClass('active');
      $('[data-tabindex="' + index + '"] [data-tabc="' + t + '"]').fadeIn();
    });
    $('[data-tabindex="' + index + '"] nav .next').on('click', function () {
      var t = parseInt($('[data-tabindex="' + index + '"] .tab-title [data-tab].active').attr('data-tab'));
      var list = $('[data-tabindex="' + index + '"] .tab-title [data-tab]').length;
      if (t == list)
        return false;
      t++;
      $('[data-tabindex="' + index + '"] .tab-title [data-tab].active').removeClass('active');
      $('[data-tabindex="' + index + '"] [data-tabc]').hide();
      $('[data-tabindex="' + index + '"] [data-tab="' + t + '"]').addClass('active');
      $('[data-tabindex="' + index + '"] [data-tabc="' + t + '"]').fadeIn();
    });
  });

  /*-------------------------------------
     </> Swipers
     </> introduction
    ------------------------------------*/
  var swiper_content_main = new Swiper('.swiper-content-main', {
    slidesPerView: 1,
    grabCursor: true,
    noSwiping: false,
    loop: true,
    pagination: {
      el: '.swiper-pagination-red',
      clickable: true,
    },
    navigation: {
      nextEl: '.arrow-next',
      prevEl: '.arrow-prev',
    },
    // autoplay: {
    //   delay: 6000,
    //   disableOnInteraction: false,
    // },

  });


  /*-------------------------------------
     </> mmenu
    ------------------------------------*/
  var $menu = $('#menu').mmenu({
    extensions: [
      'pagedim-black',
      'border-offset',
      'fx-menu-slide',
      'fx-panels-none'
    ],
    navbar: {
      add: false,
      title: 'منو',
      titleLink: 'parent'
    },
    slidingSubmenus: false,
    offCanvas: {
      position: 'right',
      zposition: 'back'
    },
    keyboardNavigation: {
      enable: 'default',
      enhance: true
    },
    lazySubmenus: {
      load: true
    },
    setSelected: {
      current: 'detect',
      hover: true,
      parent: true
    }
  }, {
    transitionDuration: 500,
    offCanvas: {
      pageSelector: '#main-page'
    },
    screenReader: {
      text: {
        closeMenu: 'بستن منو',
        closeSubmenu: 'بستن زیر منو',
        openSubmenu: 'بازکردن زیر منو',
        toggleSubmenu: 'باز و بسته کردن منو'
      }
    }
  });
  var API = $menu.data('mmenu');
  $('#navbar-toggler').on('click', function () {
    API.open();
  });
  $('#menu .menu-item-has-children').on('click', function () {
    $(this).find('> div.mm-panel.mm-vertical').slideToggle();
    $(this).toggleClass('active');
  });

})(jQuery);