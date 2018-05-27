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
  var swiper_content_field = new Swiper('.swiper-content-field-all', {
      loop: true,
    slidesPerView: 'auto',
    spaceBetween: 14,
    slidesPerGroup: 1,
    grabCursor: true,
    noSwiping: false,
    navigation: {
      nextEl: '.i-all-next',
      prevEl: '.i-all-prev',
    },
    pagination: {
      el: '.content-field-pagination-all',
      clickable: true,
    },
    // autoplay: {
    //   delay: 6000,
    //   disableOnInteraction: false,
    // },

  });
  var swiper_content_field_experiential = new Swiper('.swiper-content-field-experiential', {
      loop: true,
    slidesPerView: 'auto',
    spaceBetween: 14,
    slidesPerGroup: 1,
    grabCursor: true,
    noSwiping: false,
    navigation: {
      nextEl: '.i-experiential-next',
      prevEl: '.i-experiential-prev',
    },
    pagination: {
      el: '.content-field-pagination-experiential',
      clickable: true,
    },
    // autoplay: {
    //   delay: 6000,
    //   disableOnInteraction: false,
    // },

  });
  var swiper_content_field_math = new Swiper('.swiper-content-field-math', {
      loop: true,
    slidesPerView: 'auto',
    spaceBetween: 14,
    slidesPerGroup: 1,
    grabCursor: true,
    noSwiping: false,
    navigation: {
      nextEl: '.i-math-next',
      prevEl: '.i-math-prev',
    },
    pagination: {
      el: '.content-field-pagination-math',
      clickable: true,
    },
    // autoplay: {
    //   delay: 6000,
    //   disableOnInteraction: false,
    // },

  });


})(jQuery);