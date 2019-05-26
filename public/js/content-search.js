var MultiLevelSearch = function () {
  var selectorItems = [];
  var selectorId = '';

  function getSelectorItems(MultiLevelSearchSelectorId) {
    selectorId = MultiLevelSearchSelectorId;
    selectorItems = $('#' + selectorId + ' .selectorItem');
    return selectorItems;
  }

  function getSelectorItem(selectorIndex) {
    return $('#' + selectorId + ' .selectorItem[data-select-order="' + selectorIndex + '"]');
  }

  function getSelectorSubitems(selectorIndex) {
    return $('#' + selectorId + ' .selectorItem[data-select-order="' + selectorIndex + '"] .subItem');
  }

  function showSelectorItem(selectorIndex) {
    var selectorItem = getSelectorItem(selectorIndex);

    if (selectorItem.length === 0) {
      refreshNavbar(selectorIndex);
      return false;
    }

    selectorItems.fadeOut(0);
    var title = selectorItem.data('select-title');
    var showType = selectorItem.data('select-display');

    if (typeof showType === 'undefined') {
      if (getSelectorSubitems(selectorIndex).length > 10) {
        showType = 'select2';
      } else {
        showType = 'grid';
      }

      selectorItem.attr('data-select-display', showType);
    }

    if (showType === 'grid') {
      if (selectorItem.find('.selectorItemTitle').length > 0) {
        selectorItem.find('.selectorItemTitle').html(title);
      } else {
        selectorItem.prepend('<div class="col-12 selectorItemTitle">' + title + '</div>');
      }

      if (selectorItem.length > 0) {
        selectorItem.fadeIn();
      }
    } else if (showType === 'select2') {
      var selectorSubitems = getSelectorSubitems(selectorIndex);
      selectorSubitems.fadeOut(0);
      var select2Html = '';
      var select2Id = 'MultiLevelSearch-select2-' + selectorId + '-' + selectorIndex;

      if (selectorItem.find('.selectorItemTitle').length > 0) {
        selectorItem.find('.selectorItemTitle').html(title);
      } else {
        selectorItem.prepend('<div class="col-12 selectorItemTitle">' + title + '</div>');
      }

      for (var index in selectorSubitems) {
        if (!isNaN(index)) {
          var selected = '';

          if ($(selectorSubitems[index]).attr('selected') === 'selected') {
            selected = 'selected="selected"';
          }

          select2Html += '<option value="' + selectorSubitems[index].innerHTML + '" ' + selected + '>' + selectorSubitems[index].innerHTML + '</option>';
        }
      }

      if (selectorItem.find('.form-control.select2').length > 0) {
        var oldSelect2 = $('#' + select2Id);

        if (!oldSelect2.data('select2')) {
          oldSelect2.select2('destroy');
        }

        selectorItem.find('.select2warper').remove();
        selectorItem.append('<div class="col-12 col-sm-9 col-md-7 col-lg-6 select2warper"><div><select class="form-control select2" id="' + select2Id + '">' + select2Html + '</select></div></div>');
        $('#' + select2Id).select2({
          closeOnSelect: true
        }).on('select2:select', function (event) {
          $('.a--multi-level-search select').select2("close");
        }).on('select2:close', function (event) {
          $('.a--multi-level-search select').select2('destroy');
          $('.a--multi-level-search select').select2({
            closeOnSelect: true
          });
          $('.a--multi-level-search select').select2("close");
          $('.a--multi-level-search select').select2("close");
        });
        selectorItem.fadeIn();
      } else {
        selectorItem.append('<div class="col-12 col-sm-9 col-md-7 col-lg-6 select2warper"><div><select class="form-control select2" id="' + select2Id + '">' + select2Html + '</select></div></div>');
        $('#' + select2Id).select2({
          closeOnSelect: true
        }).on('select2:select', function (event) {
          $('.a--multi-level-search select').select2('destroy');
          $('.a--multi-level-search select').select2({
            closeOnSelect: true
          });
          $('.a--multi-level-search select').select2("close");
          $('.a--multi-level-search select').select2("close");
        }).on('select2:close', function (event) {
          $('.a--multi-level-search select').select2('destroy');
          $('.a--multi-level-search select').select2({
            closeOnSelect: true
          });
          $('.a--multi-level-search select').select2("close");
          $('.a--multi-level-search select').select2("close");
        });
        selectorItem.fadeIn();
      }
    }

    refreshNavbar(selectorIndex);
  }

  function setValueOfSelector(selectorIndex, value) {
    getSelectorItem(selectorIndex).attr('data-select-value', value);
  }

  function getValueOfSelector(selectorIndex) {
    var value = getSelectorItem(selectorIndex).attr('data-select-value');
    return typeof value !== 'undefined' ? value : null;
  }

  function getActiveStepOrder() {
    if ($('#' + selectorId + ' .selectorItem[data-select-active="true"]').length > 0) {
      return parseInt($('#' + selectorId + ' .selectorItem[data-select-active="true"]').data('select-order'));
    } else {
      return 0;
    }
  }

  function setActiveStep(selectorIndex) {
    $('#' + selectorId + ' .selectorItem').attr('data-select-active', 'false');
    getSelectorItem(selectorIndex).attr('data-select-active', 'true');
  }

  function getMaxOrder() {
    var maxOrder = 0;

    for (var index in selectorItems) {
      if (!isNaN(index)) {
        var order = parseInt($(selectorItems[index]).data('select-order'));

        if (maxOrder < order) {
          maxOrder = order;
        }
      }
    }

    return maxOrder;
  }

  function refreshNavbar(selectorIndex) {
    var filterNavigationWarper = $('#' + selectorId + ' .filterNavigationWarper');
    filterNavigationWarper.html('');
    selectorItems = $('#' + selectorId + ' .selectorItem');

    for (var index in selectorItems) {
      if (!isNaN(index)) {
        var title = $(selectorItems[index]).data('select-title');
        var order = $(selectorItems[index]).data('select-order');
        var activeString = 'deactive';

        if (parseInt(order) < parseInt(selectorIndex)) {
          activeString = 'active';
        } else if (parseInt(order) === parseInt(selectorIndex)) {
          activeString = 'current';
        } else {
          setValueOfSelector(order, '');
        }

        var selectedText = '';

        if (activeString === 'deactive') {
          $(selectorItems[index]).attr('data-select-value', '');
        }

        selectedText = getValueOfSelector(order);

        if (selectedText === null || selectedText.trim().length === 0) {
          selectedText = title;
        }

        if (activeString === 'current') {
          selectedText = '(' + 'انتخاب ' + title + ')';
        }

        filterNavigationWarper.append('<li class="filterNavigationStep ' + activeString + '" data-select-order="' + order + '">' + selectedText + '</li>');
      }
    }
  }

  function refreshNavbar1(selectorIndex) {
    var filterNavigationWarper = $('#' + selectorId + ' .filterNavigationWarper');
    filterNavigationWarper.html('');
    selectorItems = $('#' + selectorId + ' .selectorItem');

    for (var index in selectorItems) {
      if (!isNaN(index)) {
        var title = $(selectorItems[index]).data('select-title');
        var order = $(selectorItems[index]).data('select-order');
        var activeString = 'deactive';

        if (parseInt(order) < parseInt(selectorIndex)) {
          activeString = 'active';
        } else if (parseInt(order) === parseInt(selectorIndex)) {
          activeString = 'current';
        } else {
          setValueOfSelector(order, '');
        }

        var selectedText = '';

        if (activeString === 'deactive') {
          $(selectorItems[index]).attr('data-select-value', '');
        }

        selectedText = getValueOfSelector(order); // filterNavigationWarper.append('<div class="col ' + activeString + ' filterNavigationStep" data-select-order="' + order + '"><div class="filterStepText">' + title + '</div><div class="filterStepSelectedText">'+selectedText+'</div></div>');

        if (selectedText === null || selectedText.trim().length === 0) {
          selectedText = '(' + title + ')';
        }

        filterNavigationWarper.append('<div class="col ' + activeString + ' filterNavigationStep" data-select-order="' + order + '"><div class="filterStepText">' + selectedText + '</div></div>');
      }
    }
  }

  function onChangeFilter(selectorOrder, initOptions) {
    if (typeof initOptions.selector !== 'undefined' && typeof initOptions.selector[selectorOrder] !== 'undefined' && typeof initOptions.selector[selectorOrder].ajax !== 'undefined' && initOptions.selector[selectorOrder].ajax !== null) {// ajax load ...
    } else {
      showSelectorItem(parseInt(selectorOrder) + 1);

      if (getMaxOrder() >= parseInt(selectorOrder) + 1) {
        setActiveStep(parseInt(selectorOrder) + 1);
      }
    }
  }

  function onFilterNavCliked(selectorOrder, initOptions) {
    if (typeof initOptions.selector !== 'undefined' && typeof initOptions.selector[selectorOrder] !== 'undefined' && typeof initOptions.selector[selectorOrder].ajax !== 'undefined' && initOptions.selector[selectorOrder].ajax !== null) {// ajax load ...
    } else {
      if (selectorOrder < getActiveStepOrder()) {
        showSelectorItem(parseInt(selectorOrder));
        setActiveStep(selectorOrder);
      }
    }
  }

  function _getSelectedData() {
    var data = [];
    selectorItems = $('#' + selectorId + ' .selectorItem');

    for (var index in selectorItems) {
      if (isNaN(index)) {
        continue;
      }

      var selectorItem = selectorItems[index];
      var title = $(selectorItem).data('select-title');
      var order = $(selectorItem).data('select-order');
      var selectValue = $(selectorItem).attr('data-select-value');
      var selectActive = $(selectorItem).attr('data-select-active');
      var selectedText = null;

      if (typeof selectValue !== 'undefined' && typeof selectActive !== 'undefined' && (selectActive !== 'true' || getMaxOrder() === order)) {
        selectedText = selectValue;
      }

      data.push({
        title: title,
        order: order,
        selectedText: selectedText
      });
    }

    return data;
  }

  return {
    init: function init(initOptions, onChangeCallback, beforeChangeFilterCallback) {
      var multiSelector = $('#' + initOptions.selectorId);
      multiSelector.fadeOut(0);
      getSelectorItems(initOptions.selectorId);
      showSelectorItem(getActiveStepOrder());
      $(document).on('click', '#' + initOptions.selectorId + ' .selectorItem .subItem', function () {
        var parent = $(this).parents('.selectorItem');
        var selectorOrder = parent.data('select-order');
        parent.attr('data-select-value', $(this).html());
        var data = {
          selectorOrder: selectorOrder,
          selectorType: 'grid'
        };
        beforeChangeFilterCallback(data);
        onChangeFilter(selectorOrder, initOptions);
        onChangeCallback(data);
      });
      $(document).on('change', '#' + initOptions.selectorId + ' .selectorItem .select2', function () {
        var parent = $(this).parents('.selectorItem');
        var selectorOrder = parent.data('select-order');
        parent.attr('data-select-value', $(this).select2('data')[0].text.trim()); // parent.attr('data-select-value', $(this).find(':selected').text.trim());

        var data = {
          selectorOrder: selectorOrder,
          selectorType: 'select2'
        };
        beforeChangeFilterCallback(data);
        onChangeFilter(selectorOrder, initOptions);
        onChangeCallback(data);
      });
      $(document).on('click', '#' + initOptions.selectorId + ' .filterNavigationStep', function () {
        // var selectorOrder = $(this).parents('.filterNavigationStep').data('select-order');
        var selectorOrder = $(this).data('select-order');
        onFilterNavCliked(selectorOrder, initOptions);
        onChangeCallback('click on filterNavigationStep');
      });
      multiSelector.fadeIn();
    },
    getSelectedData: function getSelectedData() {
      return _getSelectedData();
    }
  };
}();

var contentSearchFilterData = {
  "lessonTeacher": {
    "همه_دروس": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "آقاجانی",
      "firstName": "محمد رضا",
      "value": "محمد_رضا_آقاجانی"
    }, {
      "lastName": "آقاجانی",
      "firstName": "رضا",
      "value": "رضا_آقاجانی"
    }, {
      "lastName": "آهویی",
      "firstName": "محسن",
      "value": "محسن_آهویی"
    }, {
      "lastName": "ارشی",
      "firstName": "",
      "value": "ارشی"
    }, {
      "lastName": "امینی راد",
      "firstName": "مهدی",
      "value": "مهدی_امینی_راد"
    }, {
      "lastName": "امینی راد",
      "firstName": "محمد علی",
      "value": "محمد_علی_امینی_راد"
    }, {
      "lastName": "بهمند",
      "firstName": "یاشار",
      "value": "یاشار_بهمند"
    }, {
      "lastName": "تاج بخش",
      "firstName": "عمار",
      "value": "عمار_تاج_بخش"
    }, {
      "lastName": "تفتی",
      "firstName": "مهدی",
      "value": "مهدی_تفتی"
    }, {
      "lastName": "ثابتی",
      "firstName": "محمد صادق",
      "value": "محمد_صادق_ثابتی"
    }, {
      "lastName": "جعفری",
      "firstName": "ابوالفضل",
      "value": "ابوالفضل_جعفری"
    }, {
      "lastName": "جعفری",
      "firstName": "",
      "value": "جعفری"
    }, {
      "lastName": "جعفری نژاد",
      "firstName": "مصطفی",
      "value": "مصطفی_جعفری_نژاد"
    }, {
      "lastName": "جلادتی",
      "firstName": "مهدی",
      "value": "مهدی_جلادتی"
    }, {
      "lastName": "جلالی",
      "firstName": "سید حسام الدین",
      "value": "سید_حسام_الدین_جلالی"
    }, {
      "lastName": "جهانبخش",
      "firstName": "",
      "value": "جهانبخش"
    }, {
      "lastName": "حاجی سلیمانی",
      "firstName": "روح الله",
      "value": "روح_الله_حاجی_سلیمانی"
    }, {
      "lastName": "حدادی",
      "firstName": "مسعود",
      "value": "مسعود_حدادی"
    }, {
      "lastName": "حسین انوشه",
      "firstName": "محمد",
      "value": "محمد_حسین_انوشه"
    }, {
      "lastName": "حسین خانی",
      "firstName": "میثم",
      "value": "میثم__حسین_خانی"
    }, {
      "lastName": "حسین شکیباییان",
      "firstName": "محمد",
      "value": "محمد_حسین_شکیباییان"
    }, {
      "lastName": "حسینی فرد",
      "firstName": "محمد رضا",
      "value": "محمد_رضا_حسینی_فرد"
    }, {
      "lastName": "حشمتی",
      "firstName": "ناصر",
      "value": "ناصر_حشمتی"
    }, {
      "lastName": "داداشی",
      "firstName": "فرشید",
      "value": "فرشید_داداشی"
    }, {
      "lastName": "درویش",
      "firstName": "",
      "value": "درویش"
    }, {
      "lastName": "راستی بروجنی",
      "firstName": "عباس",
      "value": "عباس_راستی_بروجنی"
    }, {
      "lastName": "راوش",
      "firstName": "داریوش",
      "value": "داریوش_راوش"
    }, {
      "lastName": "رحیمی",
      "firstName": "شهروز",
      "value": "شهروز_رحیمی"
    }, {
      "lastName": "رحیمی",
      "firstName": "پوریا",
      "value": "پوریا_رحیمی"
    }, {
      "lastName": "رمضانی",
      "firstName": "علیرضا",
      "value": "علیرضا_رمضانی"
    }, {
      "lastName": "رنجبرزاده",
      "firstName": "جعفر",
      "value": "جعفر_رنجبرزاده"
    }, {
      "lastName": "زاهدی",
      "firstName": "امید",
      "value": "امید_زاهدی"
    }, {
      "lastName": "سبطی",
      "firstName": "هامون",
      "value": "هامون_سبطی"
    }, {
      "lastName": "شامیزاده",
      "firstName": "رضا",
      "value": "رضا_شامیزاده"
    }, {
      "lastName": "شاه محمدی",
      "firstName": "",
      "value": "شاه_محمدی"
    }, {
      "lastName": "شهریان",
      "firstName": "محسن",
      "value": "محسن_شهریان"
    }, {
      "lastName": "صادقی",
      "firstName": "محمد",
      "value": "محمد_صادقی"
    }, {
      "lastName": "صدری",
      "firstName": "علی",
      "value": "علی_صدری"
    }, {
      "lastName": "صنیعی طهرانی",
      "firstName": "مهدی",
      "value": "مهدی_صنیعی_طهرانی"
    }, {
      "lastName": "طلوعی",
      "firstName": "پیمان",
      "value": "پیمان_طلوعی"
    }, {
      "lastName": "عزتی",
      "firstName": "علی اکبر",
      "value": "علی_اکبر_عزتی"
    }, {
      "lastName": "علیمرادی",
      "firstName": "پدرام",
      "value": "پدرام_علیمرادی"
    }, {
      "lastName": "فدایی فرد",
      "firstName": "حمید",
      "value": "حمید_فدایی_فرد"
    }, {
      "lastName": "فراهانی",
      "firstName": "کیاوش",
      "value": "کیاوش_فراهانی"
    }, {
      "lastName": "مؤذنی پور",
      "firstName": "بهمن",
      "value": "بهمن_مؤذنی_پور"
    }, {
      "lastName": "محمد زاده",
      "firstName": "خسرو",
      "value": "خسرو_محمد_زاده"
    }, {
      "lastName": "مرادی",
      "firstName": "عبدالرضا",
      "value": "عبدالرضا_مرادی"
    }, {
      "lastName": "مرصعی",
      "firstName": "حسن",
      "value": "حسن_مرصعی"
    }, {
      "lastName": "معینی",
      "firstName": "سروش",
      "value": "سروش_معینی"
    }, {
      "lastName": "معینی",
      "firstName": "محسن",
      "value": "محسن_معینی"
    }, {
      "lastName": "مقصودی",
      "firstName": "محمدرضا",
      "value": "محمدرضا_مقصودی"
    }, {
      "lastName": "موقاری",
      "firstName": "جلال",
      "value": "جلال_موقاری"
    }, {
      "lastName": "نادریان",
      "firstName": "",
      "value": "نادریان"
    }, {
      "lastName": "ناصح زاده",
      "firstName": "میلاد",
      "value": "میلاد_ناصح_زاده"
    }, {
      "lastName": "ناصر شریعت",
      "firstName": "مهدی",
      "value": "مهدی_ناصر_شریعت"
    }, {
      "lastName": "نایب کبیر",
      "firstName": "جواد",
      "value": "جواد_نایب_کبیر"
    }, {
      "lastName": "نباخته",
      "firstName": "محمدامین",
      "value": "محمدامین_نباخته"
    }, {
      "lastName": "نصیری",
      "firstName": "سیروس",
      "value": "سیروس_نصیری"
    }, {
      "lastName": "پازوکی",
      "firstName": "محمد",
      "value": "محمد_پازوکی"
    }, {
      "lastName": "پویان نظر",
      "firstName": "حامد",
      "value": "حامد_پویان_نظر"
    }, {
      "lastName": "کازرانیان",
      "firstName": "",
      "value": "کازرانیان"
    }, {
      "lastName": "کاظمی",
      "firstName": "کاظم",
      "value": "کاظم_کاظمی"
    }, {
      "lastName": "کبریایی",
      "firstName": "وحید",
      "value": "وحید_کبریایی"
    }, {
      "lastName": "کرد",
      "firstName": "حسین",
      "value": "حسین_کرد"
    }],
    "دیفرانسیل": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "ثابتی",
      "firstName": "محمد صادق",
      "value": "محمد_صادق_ثابتی"
    }, {
      "lastName": "شامیزاده",
      "firstName": "رضا",
      "value": "رضا_شامیزاده"
    }, {
      "lastName": "شهریان",
      "firstName": "محسن",
      "value": "محسن_شهریان"
    }, {
      "lastName": "نصیری",
      "firstName": "سیروس",
      "value": "سیروس_نصیری"
    }],
    "گسسته": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "شامیزاده",
      "firstName": "رضا",
      "value": "رضا_شامیزاده"
    }, {
      "lastName": "مؤذنی پور",
      "firstName": "بهمن",
      "value": "بهمن_مؤذنی_پور"
    }, {
      "lastName": "محمدی",
      "firstName": "شاه",
      "value": "شاه_محمدی"
    }, {
      "lastName": "معینی",
      "firstName": "سروش",
      "value": "سروش_معینی"
    }],
    "تحلیلی": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "ثابتی",
      "firstName": "محمد صادق",
      "value": "محمد_صادق_ثابتی"
    }, {
      "lastName": "حسینی فرد",
      "firstName": "محمد رضا",
      "value": "محمد_رضا_حسینی_فرد"
    }, {
      "lastName": "شامیزاده",
      "firstName": "رضا",
      "value": "رضا_شامیزاده"
    }],
    "هندسه_پایه": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "حسینی فرد",
      "firstName": "محمد رضا",
      "value": "محمد_رضا_حسینی_فرد"
    }, {
      "lastName": "شامیزاده",
      "firstName": "رضا",
      "value": "رضا_شامیزاده"
    }, {
      "lastName": "مرصعی",
      "firstName": "حسن",
      "value": "حسن_مرصعی"
    }, {
      "lastName": "کبریایی",
      "firstName": "وحید",
      "value": "وحید_کبریایی"
    }],
    "حسابان": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "ثابتی",
      "firstName": "محمد صادق",
      "value": "محمد_صادق_ثابتی"
    }, {
      "lastName": "رحیمی",
      "firstName": "شهروز",
      "value": "شهروز_رحیمی"
    }, {
      "lastName": "مقصودی",
      "firstName": "محمدرضا",
      "value": "محمدرضا_مقصودی"
    }],
    "جبر_و_احتمال": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "شامیزاده",
      "firstName": "رضا",
      "value": "رضا_شامیزاده"
    }, {
      "lastName": "کرد",
      "firstName": "حسین",
      "value": "حسین_کرد"
    }],
    "ریاضی_پایه": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "امینی راد",
      "firstName": "مهدی",
      "value": "مهدی_امینی_راد"
    }, {
      "lastName": "شامیزاده",
      "firstName": "رضا",
      "value": "رضا_شامیزاده"
    }, {
      "lastName": "شهریان",
      "firstName": "محسن",
      "value": "محسن_شهریان"
    }, {
      "lastName": "مقصودی",
      "firstName": "محمدرضا",
      "value": "محمدرضا_مقصودی"
    }, {
      "lastName": "نایب کبیر",
      "firstName": "جواد",
      "value": "جواد_نایب_کبیر"
    }],
    "ریاضی_تجربی": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "امینی راد",
      "firstName": "مهدی",
      "value": "مهدی_امینی_راد"
    }, {
      "lastName": "حسینی فرد",
      "firstName": "محمد رضا",
      "value": "محمد_رضا_حسینی_فرد"
    }, {
      "lastName": "شامیزاده",
      "firstName": "رضا",
      "value": "رضا_شامیزاده"
    }, {
      "lastName": "صدری",
      "firstName": "علی",
      "value": "علی_صدری"
    }, {
      "lastName": "نباخته",
      "firstName": "محمدامین",
      "value": "محمدامین_نباخته"
    }],
    "ریاضی_انسانی": {
      "0": {
        "lastName": "همه دبیرها",
        "firstName": "",
        "value": "همه_دبیرها"
      },
      "2": {
        "lastName": "امینی راد",
        "firstName": "مهدی",
        "value": "مهدی_امینی_راد"
      },
      "1": {
        "lastName": "محمد زاده",
        "firstName": "خسرو",
        "value": "خسرو_محمد_زاده"
      }
    },
    "عربی": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "آهویی",
      "firstName": "محسن",
      "value": "محسن_آهویی"
    }, {
      "lastName": "تاج بخش",
      "firstName": "عمار",
      "value": "عمار_تاج_بخش"
    }, {
      "lastName": "جلادتی",
      "firstName": "مهدی",
      "value": "مهدی_جلادتی"
    }, {
      "lastName": "حشمتی",
      "firstName": "ناصر",
      "value": "ناصر_حشمتی"
    }, {
      "lastName": "رنجبرزاده",
      "firstName": "جعفر",
      "value": "جعفر_رنجبرزاده"
    }, {
      "lastName": "علیمرادی",
      "firstName": "پدرام",
      "value": "پدرام_علیمرادی"
    }, {
      "lastName": "ناصح زاده",
      "firstName": "میلاد",
      "value": "میلاد_ناصح_زاده"
    }, {
      "lastName": "ناصر شریعت",
      "firstName": "مهدی",
      "value": "مهدی_ناصر_شریعت"
    }],
    "شیمی": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "آقاجانی",
      "firstName": "محمد رضا",
      "value": "محمد_رضا_آقاجانی"
    }, {
      "lastName": "انوشه",
      "firstName": "محمد حسین",
      "value": "محمد_حسین_انوشه"
    }, {
      "lastName": "جعفری",
      "firstName": "",
      "value": "جعفری"
    }, {
      "lastName": "حاجی سلیمانی",
      "firstName": "روح الله ",
      "value": "روح_الله_حاجی_سلیمانی"
    }, {
      "lastName": "شکیباییان",
      "firstName": "محمد حسین ",
      "value": "محمد_حسین_شکیباییان"
    }, {
      "lastName": "طهرانی",
      "firstName": "مهدی صنیعی",
      "value": "مهدی_صنیعی_طهرانی"
    }, {
      "lastName": "معینی",
      "firstName": "محسن ",
      "value": "محسن_معینی"
    }, {
      "lastName": "پویان نظر",
      "firstName": "حامد ",
      "value": "حامد_پویان_نظر"
    }],
    "فیزیک": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "جهانبخش",
      "firstName": "",
      "value": "جهانبخش"
    }, {
      "lastName": "داداشی",
      "firstName": "فرشید",
      "value": "فرشید_داداشی"
    }, {
      "lastName": "رمضانی",
      "firstName": "علیرضا",
      "value": "علیرضا_رمضانی"
    }, {
      "lastName": "طلوعی",
      "firstName": "پیمان",
      "value": "پیمان_طلوعی"
    }, {
      "lastName": "فدایی فرد",
      "firstName": "حمید",
      "value": "حمید_فدایی_فرد"
    }, {
      "lastName": "نادریان",
      "firstName": "",
      "value": "نادریان"
    }, {
      "lastName": "کازرانیان",
      "firstName": "",
      "value": "کازرانیان"
    }],
    "زبان_انگلیسی": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "درویش",
      "firstName": "",
      "value": "درویش"
    }, {
      "lastName": "عزتی",
      "firstName": "علی اکبر",
      "value": "علی_اکبر_عزتی"
    }, {
      "lastName": "فراهانی",
      "firstName": "کیاوش",
      "value": "کیاوش_فراهانی"
    }],
    "دین_و_زندگی": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "تفتی",
      "firstName": "مهدی",
      "value": "مهدی_تفتی"
    }, {
      "lastName": "رنجبرزاده",
      "firstName": "جعفر",
      "value": "جعفر_رنجبرزاده"
    }],
    "زبان_و_ادبیات_فارسی": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "خانی حسین",
      "firstName": "میثم",
      "value": "میثم__حسین_خانی"
    }, {
      "lastName": "راوش",
      "firstName": "داریوش",
      "value": "داریوش_راوش"
    }, {
      "lastName": "سبطی",
      "firstName": "هامون",
      "value": "هامون_سبطی"
    }, {
      "lastName": "صادقی",
      "firstName": "محمد",
      "value": "محمد_صادقی"
    }, {
      "lastName": "مرادی",
      "firstName": "عبدالرضا",
      "value": "عبدالرضا_مرادی"
    }, {
      "lastName": "کاظمی",
      "firstName": "کاظم",
      "value": "کاظم_کاظمی"
    }],
    "آمار_و_مدلسازی": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "امینی راد",
      "firstName": "مهدی",
      "value": "مهدی_امینی_راد"
    }, {
      "lastName": "شامیزاده",
      "firstName": "رضا",
      "value": "رضا_شامیزاده"
    }, {
      "lastName": "کبریایی",
      "firstName": "وحید",
      "value": "وحید_کبریایی"
    }],
    "زیست_شناسی": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "ارشی",
      "firstName": "",
      "value": "ارشی"
    }, {
      "lastName": "امینی راد",
      "firstName": "محمد علی",
      "value": "محمد_علی_امینی_راد"
    }, {
      "lastName": "جعفری",
      "firstName": "ابوالفضل",
      "value": "ابوالفضل_جعفری"
    }, {
      "lastName": "حدادی",
      "firstName": "مسعود",
      "value": "مسعود_حدادی"
    }, {
      "lastName": "راستی بروجنی",
      "firstName": "عباس",
      "value": "عباس_راستی_بروجنی"
    }, {
      "lastName": "رحیمی",
      "firstName": "پوریا",
      "value": "پوریا_رحیمی"
    }, {
      "lastName": "موقاری",
      "firstName": "جلال",
      "value": "جلال_موقاری"
    }, {
      "lastName": "پازوکی",
      "firstName": "محمد",
      "value": "محمد_پازوکی"
    }],
    "ریاضی_و_آمار": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "امینی راد",
      "firstName": "مهدی",
      "value": "مهدی_امینی_راد"
    }],
    "منطق": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "آقاجانی",
      "firstName": "رضا",
      "value": "رضا_آقاجانی"
    }, {
      "lastName": "الدین جلالی",
      "firstName": "سید حسام",
      "value": "سید_حسام_الدین_جلالی"
    }],
    "المپیاد_فیزیک": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "جعفری نژاد",
      "firstName": "مصطفی",
      "value": "مصطفی_جعفری_نژاد"
    }],
    "المپیاد_نجوم": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "بهمند",
      "firstName": "یاشار",
      "value": "یاشار_بهمند"
    }],
    "مشاوره": [{
      "lastName": "همه دبیرها",
      "firstName": "",
      "value": "همه_دبیرها"
    }, {
      "lastName": "امینی راد",
      "firstName": "محمد علی",
      "value": "محمد_علی_امینی_راد"
    }, {
      "lastName": "زاهدی",
      "firstName": "امید",
      "value": "امید_زاهدی"
    }]
  },
  "allLessons": [{
    "value": "همه_دروس",
    "index": "همه دروس"
  }, {
    "value": "آمار_و_مدلسازی",
    "index": "آمار و مدلسازی"
  }, {
    "value": "اخلاق",
    "index": "اخلاق"
  }, {
    "value": "المپیاد_فیزیک",
    "index": "المپیاد فیزیک"
  }, {
    "value": "المپیاد_نجوم",
    "index": "المپیاد نجوم"
  }, {
    "value": "تحلیلی",
    "index": "تحلیلی"
  }, {
    "value": "جبر_و_احتمال",
    "index": "جبر و احتمال"
  }, {
    "value": "حسابان",
    "index": "حسابان"
  }, {
    "value": "دیفرانسیل",
    "index": "دیفرانسیل"
  }, {
    "value": "دین_و_زندگی",
    "index": "دین و زندگی"
  }, {
    "value": "ریاضی_انسانی",
    "index": "ریاضی انسانی"
  }, {
    "value": "ریاضی_تجربی",
    "index": "ریاضی تجربی"
  }, {
    "value": "ریاضی_و_آمار",
    "index": "ریاضی و آمار"
  }, {
    "value": "ریاضی_پایه",
    "index": "ریاضی پایه"
  }, {
    "value": "زبان_انگلیسی",
    "index": "زبان انگلیسی"
  }, {
    "value": "زبان_و_ادبیات_فارسی",
    "index": "زبان و ادبیات فارسی"
  }, {
    "value": "زیست_شناسی",
    "index": "زیست شناسی"
  }, {
    "value": "شیمی",
    "index": "شیمی"
  }, {
    "value": "عربی",
    "index": "عربی"
  }, {
    "value": "فیزیک",
    "index": "فیزیک"
  }, {
    "value": "مشاوره",
    "index": "مشاوره"
  }, {
    "value": "منطق",
    "index": "منطق"
  }, {
    "value": "هندسه_پایه",
    "index": "هندسه پایه"
  }, {
    "value": "گسسته",
    "index": "گسسته"
  }],
  "riaziLessons": [{
    "value": "همه_دروس",
    "index": "همه دروس"
  }, {
    "value": "آمار_و_مدلسازی",
    "index": "آمار و مدلسازی"
  }, {
    "value": "المپیاد_فیزیک",
    "index": "المپیاد فیزیک"
  }, {
    "value": "المپیاد_نجوم",
    "index": "المپیاد نجوم"
  }, {
    "value": "تحلیلی",
    "index": "تحلیلی"
  }, {
    "value": "جبر_و_احتمال",
    "index": "جبر و احتمال"
  }, {
    "value": "حسابان",
    "index": "حسابان"
  }, {
    "value": "دیفرانسیل",
    "index": "دیفرانسیل"
  }, {
    "value": "دین_و_زندگی",
    "index": "دین و زندگی"
  }, {
    "value": "ریاضی_پایه",
    "index": "ریاضی پایه"
  }, {
    "value": "زبان_انگلیسی",
    "index": "زبان انگلیسی"
  }, {
    "value": "زبان_و_ادبیات_فارسی",
    "index": "زبان و ادبیات فارسی"
  }, {
    "value": "شیمی",
    "index": "شیمی"
  }, {
    "value": "عربی",
    "index": "عربی"
  }, {
    "value": "فیزیک",
    "index": "فیزیک"
  }, {
    "value": "مشاوره",
    "index": "مشاوره"
  }, {
    "value": "هندسه_پایه",
    "index": "هندسه پایه"
  }, {
    "value": "گسسته",
    "index": "گسسته"
  }],
  "tajrobiLessons": [{
    "value": "همه_دروس",
    "index": "همه دروس"
  }, {
    "value": "آمار_و_مدلسازی",
    "index": "آمار و مدلسازی"
  }, {
    "value": "المپیاد_فیزیک",
    "index": "المپیاد فیزیک"
  }, {
    "value": "المپیاد_نجوم",
    "index": "المپیاد نجوم"
  }, {
    "value": "دین_و_زندگی",
    "index": "دین و زندگی"
  }, {
    "value": "ریاضی_تجربی",
    "index": "ریاضی تجربی"
  }, {
    "value": "ریاضی_پایه",
    "index": "ریاضی پایه"
  }, {
    "value": "زبان_انگلیسی",
    "index": "زبان انگلیسی"
  }, {
    "value": "زبان_و_ادبیات_فارسی",
    "index": "زبان و ادبیات فارسی"
  }, {
    "value": "زیست_شناسی",
    "index": "زیست شناسی"
  }, {
    "value": "شیمی",
    "index": "شیمی"
  }, {
    "value": "عربی",
    "index": "عربی"
  }, {
    "value": "فیزیک",
    "index": "فیزیک"
  }, {
    "value": "مشاوره",
    "index": "مشاوره"
  }, {
    "value": "هندسه_پایه",
    "index": "هندسه پایه"
  }],
  "ensaniLessons": [{
    "value": "همه_دروس",
    "index": "همه دروس"
  }, {
    "value": "آمار_و_مدلسازی",
    "index": "آمار و مدلسازی"
  }, {
    "value": "اخلاق",
    "index": "اخلاق"
  }, {
    "value": "دین_و_زندگی",
    "index": "دین و زندگی"
  }, {
    "value": "ریاضی_انسانی",
    "index": "ریاضی انسانی"
  }, {
    "value": "ریاضی_و_آمار",
    "index": "ریاضی و آمار"
  }, {
    "value": "زبان_انگلیسی",
    "index": "زبان انگلیسی"
  }, {
    "value": "زبان_و_ادبیات_فارسی",
    "index": "زبان و ادبیات فارسی"
  }, {
    "value": "عربی",
    "index": "عربی"
  }, {
    "value": "مشاوره",
    "index": "مشاوره"
  }, {
    "value": "منطق",
    "index": "منطق"
  }],
  "major": [{
    name: 'همه رشته ها',
    value: 'همه_رشته_ها',
    lessonKey: 'allLessons'
  }, {
    name: 'رشته ریاضی',
    value: 'رشته_ریاضی',
    lessonKey: 'riaziLessons'
  }, {
    name: 'رشته تجربی',
    value: 'رشته_تجربی',
    lessonKey: 'tajrobiLessons'
  }, {
    name: 'رشته انسانی',
    value: 'رشته_انسانی',
    lessonKey: 'ensaniLessons'
  }],
  "maghtaGhadim": [{
    name: 'همه مقاطع',
    value: 'همه_مقاطع'
  }, {
    name: 'کنکور',
    value: 'کنکور'
  }, {
    name: 'اول دبیرستان',
    value: 'اول_دبیرستان'
  }, {
    name: 'دوم دبیرستان',
    value: 'دوم_دبیرستان'
  }, {
    name: 'سوم دبیرستان',
    value: 'سوم_دبیرستان'
  }, {
    name: 'چهارم دبیرستان',
    value: 'چهارم_دبیرستان'
  }, {
    name: 'المپیاد',
    value: 'المپیاد'
  }],
  "maghtaJadid": [{
    name: 'همه مقاطع',
    value: 'همه_مقاطع'
  }, {
    name: 'دهم',
    value: 'دهم'
  }, {
    name: 'یازدهم',
    value: 'یازدهم'
  }, {
    name: 'دوازدهم',
    value: 'دوازدهم'
  }, {
    name: 'کنکور',
    value: 'کنکور'
  }, {
    name: 'المپیاد',
    value: 'المپیاد'
  }],
  "nezam": [{
    name: 'نظام قدیم',
    value: 'نظام_آموزشی_قدیم',
    maghtaKey: 'maghtaGhadim'
  }, {
    name: 'نظام جدید',
    value: 'نظام_آموزشی_جدید',
    maghtaKey: 'maghtaJadid'
  }]
};

var Alaasearch = function () {
  var productAjaxLock = 0;
  var videoAjaxLock = 0;
  var setAjaxLock = 0;
  var articleAjaxLock = 0;
  var pamphletAjaxLock = 0;

  function getProductCarouselItem(data) {
    var widgetActionLink = data.url;
    var widgetActionName = '<i class="flaticon-bag"></i>' + ' / ' + '<i class="fa fa-eye"></i>';
    var widgetPic = data.photo;
    var widgetTitle = data.name;
    var price = data.price;
    var priceHtml = '<span class = "m-badge m-badge--danger m-badge--wide m-badge--rounded a--productPrice">';

    if (price.base !== price["final"]) {
      priceHtml += '    <span class = "m-badge m-badge--warning a--productRealPrice">' + price.base.toLocaleString('fa') + '</span>\n';
    }

    priceHtml += '    ' + price["final"].toLocaleString('fa') + ' تومان \n';

    if (price.base !== price["final"]) {
      priceHtml += '    <span class = "m-badge m-badge--info a--productDiscount">' + Math.round((1 - price["final"] / price.base) * 100) + '%</span>\n';
    }

    priceHtml += '</span>';
    return '<div class = "item">\n' + '    <!--begin:: Widgets/Blog-->\n' + '    <div class = "m-portlet m-portlet--bordered-semi m-portlet--rounded-force">\n' + '   <div class="m-portlet__head m-portlet__head--fit"> \
                    <div class="m-portlet__head-caption"> \
                        <div class="m-portlet__head-action"> \
                        </div> \
                    </div> \
                </div> ' + '        <div class = "m-portlet__body">\n' + '            <div class = "a-widget19 m-widget19">\n' + '                <div class = "m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" >\n' + '                    <a href="' + widgetActionLink + '" class = "btn btn-sm m-btn--pill btn-brand btnViewMore">' + widgetActionName + '</a>\n' + '                    <img src = "' + widgetPic + '" alt = "' + widgetTitle + '"/>\n' + '                    <div class = "m-widget19__shadow"></div>\n' + '                </div>\n' + '                <div class = "m-widget19__content">\n' + '                    <div class="owl-carousel-fileTitle">\n' + '                        <a href = "' + widgetActionLink + '" class = "m-link">\n' + '                            <h6>\n' + '                                <span class="m-badge m-badge--info m-badge--dot"></span> ' + widgetTitle + '\n' + '                            </h6>\n' + '                        </a>\n' + '                    </div>\n' + '                    <div class = "m-widget19__header">\n' + '                        <div class = "m-widget19__info">\n' + priceHtml + '                        </div>\n' + '                    </div>\n' + '                </div>\n' + '            </div>\n' + '        </div>\n' + '    </div>\n' + '    <!--end:: Widgets/Blog-->\n' + '</div>';
  }

  function getVideoCarouselItem(data) {
    var widgetActionLink = data.url;
    var widgetActionName = '<i class="fa fa-play"></i>' + ' / ' + '<i class="fa fa-cloud-download-alt"></i>';
    var widgetPic = typeof data.photo === 'undefined' || data.photo == null ? data.thumbnail : data.photo;
    var widgetTitle = data.name;
    var widgetAuthor = {
      photo: typeof data.author.photo === 'undefined' || data.author.photo == null ? null : data.author.photo,
      name: data.author.firstName,
      full_name: data.author.full_name
    };
    var widgetLink = data.url;
    return '<div class = \"item\"> \
    <!--begin:: Widgets/Blog--> \
    <div class = \"m-portlet m-portlet--bordered-semi m-portlet--rounded-force\"> \
        <div class = \"m-portlet__head m-portlet__head--fit\"> \
            <div class = \"m-portlet__head-caption\"> \
                <div class = \"m-portlet__head-action\"> \
                </div> \
            </div> \
        </div> \
        <div class = \"m-portlet__body\"> \
            <div class = \"a-widget19 m-widget19\"> \
                <div class = \"m-widget19__pic m-portlet-fit--top m-portlet-fit--sides\" > \
                    <a href=\"' + widgetActionLink + '\" class = \"btn btn-sm m-btn--pill btn-brand btnViewMore\">' + widgetActionName + '</a> \
                    <img src = \"' + widgetPic + '\" alt = \" ' + widgetTitle + '\"/> \
                    <div class = \"m-widget19__shadow\"></div> \
                </div> \
                <div class = \"m-widget19__content\"> \n' + '                    <div class="owl-carousel-fileTitle">\n' + '                        <a href = "' + widgetActionLink + '" class = "m-link">\n' + '                            <h6>\n' + '                                <span class="m-badge m-badge--info m-badge--dot"></span> ' + widgetTitle + '\n' + '                            </h6>\n' + '                        </a>\n' + '                    </div>\
                    <div class = \"m-widget19__header\"> \
                        <div class = \"m-widget19__user-img\"> \
                            <img class = \"m-widget19__img\" src = \" ' + widgetAuthor.photo + '\" alt = \"' + widgetAuthor.name + '\"> \
                        </div> \
                        <div class = \"m-widget19__info\"> \
                            <span class = \"m-widget19__username\"> \
                            ' + widgetAuthor.full_name + ' \
                            </span> \
                            <br> \
                            <span class = \"m-widget19__time\"> \
                            موسسه غیرتجاری آلاء \
                            </span> \
                        </div> \
                    </div> \
                </div> \
                <!--<div class = \"m-widget19__action\"> \
                    <a href = \"' + widgetLink + '\" class = \"btn m-btn--pill    btn-outline-warning m-btn m-btn--outline-2x \">نمایش فیلم های این دوره</a> \
                </div> --> \
            </div> \
        </div> \
    </div> \
    <!--end:: Widgets/Blog--> \
</div>';
  }

  function getSetCarouselItem(data) {
    var widgetActionLink = data.url;
    var widgetActionName = 'نمایش این دوره';
    var widgetPic = typeof data.photo === 'undefined' || data.photo == null ? data.thumbnail : data.photo;
    var widgetTitle = data.name;
    var widgetAuthor = {
      photo: data.author.photo,
      name: data.author.firstName,
      full_name: data.author.full_name
    };
    var widgetCount = data.contents_count;
    var widgetLink = data.url;
    return '<div class = \"item\"> \
    <!--begin:: Widgets/Blog--> \
    <div class = \"m-portlet m-portlet--bordered-semi m-portlet--rounded-force\"> \
        <div class = \"m-portlet__head m-portlet__head--fit\"> \
            <div class = \"m-portlet__head-caption\"> \
                <div class = \"m-portlet__head-action\"> \
                </div> \
            </div> \
        </div> \
        <div class = \"m-portlet__body\"> \
            <div class = \"a-widget19 m-widget19\"> \
                <div class = \"m-widget19__pic m-portlet-fit--top m-portlet-fit--sides\" > \
                    <a href=\"' + widgetActionLink + '\" class = \"btn btn-sm m-btn--pill btn-brand btnViewMore\">' + widgetActionName + '</a> \
                    <img src = \"' + widgetPic + '\" alt = \" ' + widgetTitle + '\"/> \
                    <div class = \"m-widget19__shadow\"></div> \
                </div> \
                <div class = \"m-widget19__content\"> \n' + '                    <div class="owl-carousel-fileTitle">\n' + '                        <a href = "' + widgetActionLink + '" class = "m-link">\n' + '                            <h6>\n' + '                                <span class="m-badge m-badge--info m-badge--dot"></span> ' + widgetTitle + '\n' + '                            </h6>\n' + '                        </a>\n' + '                    </div>\
                    <div class = \"m-widget19__header\"> \
                        <div class = \"m-widget19__user-img\"> \
                            <img class = \"m-widget19__img\" src = \" ' + widgetAuthor.photo + '\" alt = \"' + widgetAuthor.name + '\"> \
                        </div> \
                        <div class = \"m-widget19__info\"> \
                            <span class = \"m-widget19__username\"> \
                            ' + widgetAuthor.full_name + ' \
                            </span> \
                            <br> \
                            <span class = \"m-widget19__time\"> \
                            موسسه غیرتجاری آلاء \
                            </span> \
                        </div> \
                        <div class = \"m-widget19__stats\"> \
                            <span class = \"m-widget19__number m--font-brand\"> \
                            ' + widgetCount + ' \
                            </span> \
                            <span class = \"m-widget19__comment\"> \
                            محتوا  \
                            </span> \
                        </div> \
                    </div> \
                </div> \
                <!--<div class = \"m-widget19__action\"> \
                    <a href = \"' + widgetLink + '\" class = \"btn m-btn--pill    btn-outline-warning m-btn m-btn--outline-2x \">نمایش فیلم های این دوره</a> \
                </div> --> \
            </div> \
        </div> \
    </div> \
    <!--end:: Widgets/Blog--> \
</div>';
  }

  function getSetPamphletItem(data) {
    var widgetActionLink = data.url;
    var widgetTitle = data.name;
    var widgetThumbnail = data.thumbnail;
    var widgetAuthor = {
      photo: data.author !== null ? data.author.photo : '',
      name: data.author !== null ? data.author.firstName : '',
      full_name: data.author !== null ? data.author.full_name : ''
    };

    if (widgetThumbnail !== null && widgetThumbnail.length !== 0) {
      widgetThumbnail = '<div class="m-widget4__img m-widget4__img--pic">\n' + '    <img src="' + widgetThumbnail + '" alt="' + widgetTitle + '">\n' + '</div>\n';
    } else {
      widgetThumbnail = '';
    }

    return '\n' + '<div class="m-widget4__item m--padding-top-5 m--padding-bottom-5">\n' + '    <div class="m-widget4__img m-widget4__img--pic">\n' + '        <img src="' + widgetAuthor.photo + '" alt="">\n' + '    </div>\n' + '    <div class="m-widget4__info">\n' + '            <span class="m-widget4__title">\n' + '                <a href="' + widgetActionLink + '" class="m-link">\n' + '                    ' + widgetTitle + '\n' + '                </a>\n' + '            </span>\n' + '        <br>\n' + '        <span class="m-widget4__sub">\n' + '                <a href="' + widgetActionLink + '" class="m-link">\n' + '                    ' + widgetAuthor.full_name + '\n' + '                </a>\n' + '            </span>\n' + '    </div>\n' + widgetThumbnail + '</div>';
  }

  function makeWidgetFromJsonResponse(data, type) {
    switch (type) {
      case 'product':
        return getProductCarouselItem(data);

      case 'video':
        return getVideoCarouselItem(data);

      case 'set':
        return getSetCarouselItem(data);

      case 'pamphlet':
        return getSetPamphletItem(data);

      case 'article':
        return getSetPamphletItem(data);
    }
  }

  function addContentToVerticalWidget(vw, data, type) {
    $.each(data, function (index, value) {
      vw.append(makeWidgetFromJsonResponse(value, type));
    });
  }

  function addContentToOwl(owl, data, type) {
    $.each(data, function (index, value) {
      owl.trigger('add.owl.carousel', [// jQuery('<div class="owl-item">' + makeWidgetFromJsonResponse(value) + '</div>');
      jQuery(makeWidgetFromJsonResponse(value, type))]);
    });
    owl.trigger('refresh.owl.carousel');
  }

  function ajaxSetup() {
    $.ajaxSetup({
      cache: false,
      headers: {
        'X-CSRF-TOKEN': window.Laravel.csrfToken
      }
    });
  }

  function loadData(owl, action, type, callback) {
    ajaxSetup();
    $.ajax({
      type: "GET",
      url: action,
      accept: "application/json; charset=utf-8",
      dataType: "json",
      contentType: "application/json; charset=utf-8",
      statusCode: {
        200: function _(response) {
          removeLoadingItem(owl, type);

          if (type === 'product' || type === 'video' || type === 'set') {
            addContentToOwl(owl, response.result[type].data, type);
          } else if (type === 'pamphlet') {
            loadPamphletFromJson(response.result[type]);
          } else if (type === 'article') {
            loadArticleFromJson(response.result[type]);
          } // responseMessage = response.responseText;


          callback(response.result[type].next_page_url);
        },
        403: function _(response) {// responseMessage = response.responseJSON.message;
        },
        404: function _(response) {},
        422: function _(response) {},
        429: function _(response) {},
        //The status for when there is error php code
        500: function _() {
          removeLoadingItem(owl, type);
        }
      }
    });
  }

  function lockAjax(type) {
    switch (type) {
      case 'product':
        productAjaxLock = 1;
        break;

      case 'video':
        videoAjaxLock = 1;
        break;

      case 'set':
        setAjaxLock = 1;
        break;

      case 'pamphlet':
        pamphletAjaxLock = 1;
        break;

      case 'article':
        articleAjaxLock = 1;
        break;
    }
  }

  function unLockAjax(type) {
    switch (type) {
      case 'product':
        productAjaxLock = 0;
        break;

      case 'video':
        videoAjaxLock = 0;
        break;

      case 'set':
        setAjaxLock = 0;
        break;

      case 'pamphlet':
        pamphletAjaxLock = 0;
        break;

      case 'article':
        articleAjaxLock = 0;
        break;
    }
  }

  function load(event, nextPageUrl, owl, owlType, callback) {
    if (owlType === 'product' || owlType === 'video' || owlType === 'set') {
      var perPage = typeof owl.data("per-page") === "number" ? owl.data("per-page") : 6;

      if (nextPageUrl !== null && nextPageUrl.length !== 0 && event.namespace && event.property.name === 'position' && event.property.value >= event.relatedTarget.items().length - perPage) {
        lockAjax(owlType);
        addLoadingItem(owl, owlType); // load, add and update

        loadData(owl, nextPageUrl, owlType, callback);
      }
    } else if (owlType === 'pamphlet' || owlType === 'article') {
      if (nextPageUrl !== null && nextPageUrl.length !== 0) {
        lockAjax(owlType);
        addLoadingItem(owl, owlType);
        loadData(owl, nextPageUrl, owlType, callback);
      }
    }
  }

  function loadProductFromJson(data) {
    addContentToOwl($('#product-carousel.owl-carousel'), data.data, 'product');
    $('#owl--js-var-next-page-product-carousel-url').val(decodeURI(data.next_page_url));
  }

  function initProduct(data) {
    loadProductFromJson(data);
    $('#product-carousel.owl-carousel').on('change.owl.carousel', function (event) {
      var owlType = 'product';
      var nextPageUrl = $('#owl--js-var-next-page-product-carousel-url');
      var owl = $(this);

      if (!productAjaxLock && nextPageUrl.val() !== "null") {
        load(event, nextPageUrl.val(), owl, owlType, function (newPageUrl) {
          if (newPageUrl === null) {
            newPageUrl = '';
          }

          $('#owl--js-var-next-page-product-carousel-url').val(decodeURI(newPageUrl));
          unLockAjax(owlType);
        });
      }
    });
  }

  function loadVideoFromJson(data) {
    if (data === null) {
      return false;
    }

    addContentToOwl($('#video-carousel.owl-carousel'), data.data, 'video');
    $('#owl--js-var-next-page-video-url').val(decodeURI(data.next_page_url));
  }

  function initVideo(data) {
    loadVideoFromJson(data);
    $('#video-carousel.owl-carousel').on('change.owl.carousel', function (event) {
      var owlType = "video";
      var nextPageUrl = $('#owl--js-var-next-page-video-url');
      var owl = $(this);

      if (!videoAjaxLock && nextPageUrl.val() !== "null") {
        load(event, nextPageUrl.val(), owl, owlType, function (newPageUrl) {
          $('#owl--js-var-next-page-video-url').val(decodeURI(newPageUrl));
          unLockAjax(owlType);
        });
      }
    });
  }

  function loadSetFromJson(data) {
    addContentToOwl($('#set-carousel.owl-carousel'), data.data, 'video');
    $('#owl--js-var-next-page-set-url').val(decodeURI(data.next_page_url));
  }

  function initSet(data) {
    loadSetFromJson(data);
    $('#set-carousel.owl-carousel').on('change.owl.carousel', function (event) {
      var owlType = "set";
      var nextPageUrl = $('#owl--js-var-next-page-set-url');
      var owl = $(this);

      if (!setAjaxLock && nextPageUrl.val() !== "null") {
        load(event, nextPageUrl.val(), owl, owlType, function (newPageUrl) {
          $('#owl--js-var-next-page-set-url').val(decodeURI(newPageUrl));
          unLockAjax(owlType);
        });
      }
    });
  }

  function loadPamphletFromJson(data) {
    if (data === null) {
      return false;
    }

    var pamphletverticalWidget = '#pamphlet-vertical-widget'; // $('.pamphlet-lastITemSensor').remove();

    $('.pamphlet-wraperShowMore').remove();
    addContentToVerticalWidget($(pamphletverticalWidget), data.data, 'pamphlet'); // $(pamphletverticalWidget).append('<div class="pamphlet-lastITemSensor"></div>');

    if (data.next_page_url !== null) {
      $(pamphletverticalWidget).append('<div class="pamphlet-wraperShowMore text-center"><button class="btn m-btn--pill m-btn--air btn-primary pamphlet-btnShowMore">نمایش بیشتر</button></div>');
    }

    $('#vertical-widget--js-var-next-page-pamphlet-url').val(decodeURI(data.next_page_url));
  }

  function initPamphlet(data) {
    loadPamphletFromJson(data);
    $(document).on('click', '.pamphlet-btnShowMore', function () {
      var pamphletBtnShowMore = '.pamphlet-btnShowMore';
      $(pamphletBtnShowMore).fadeOut();
      var vwType = 'pamphlet';
      var nextPageUrl = $('#vertical-widget--js-var-next-page-pamphlet-url');
      var vw = $('#pamphlet-vertical-widget');

      if (!pamphletAjaxLock && nextPageUrl.val() !== "null") {
        load(event, nextPageUrl.val(), vw, vwType, function (newPageUrl) {
          $('#vertical-widget--js-var-next-page-pamphlet-url').val(decodeURI(newPageUrl));
          unLockAjax(vwType);
          $(pamphletBtnShowMore).fadeOut(0).fadeIn();
        });
      }
    }); // $(window).scroll(function () {
    //     if (isScrolledIntoView($('.pamphlet-lastITemSensor'))) {
    //
    //         var vwType = 'pamphlet';
    //         var nextPageUrl = $('#vertical-widget--js-var-next-page-pamphlet-url');
    //         var vw = $('#pamphlet-vertical-widget');
    //
    //         if (!pamphletAjaxLock && nextPageUrl.val() !== "null") {
    //             load(event, nextPageUrl.val(), vw, vwType, function (newPageUrl) {
    //                 $('#vertical-widget--js-var-next-page-pamphlet-url').val(decodeURI(newPageUrl));
    //                 unLockAjax(vwType);
    //             });
    //         }
    //
    //     }
    // });
  }

  function loadArticleFromJson(data) {
    if (data === null) {
      return false;
    }

    var articleVerticalWidget = '#article-vertical-widget'; // $('#pamphlet-vertical-widget').find('.article-lastITemSensor').remove();

    $('.article-wraperShowMore').remove();
    addContentToVerticalWidget($(articleVerticalWidget), data.data, 'article');

    if (data.next_page_url !== null) {
      $(articleVerticalWidget).append('<div class="article-wraperShowMore text-center"><button class="btn m-btn--pill m-btn--air btn-primary article-btnShowMore">نمایش بیشتر</button></div>');
    }

    $('#vertical-widget--js-var-next-page-article-url').val(decodeURI(data.next_page_url)); // $('#pamphlet-vertical-widget').append('<div class="article-lastITemSensor"></div>');
  }

  function initArticle(data) {
    loadArticleFromJson(data);
    $(document).on('click', '.article-btnShowMore', function () {
      $('.article-btnShowMore').fadeOut();
      var vwType = 'pamphlet';
      var nextPageUrl = $('#vertical-widget--js-var-next-page-article-url');
      var vw = $('#article-vertical-widget');

      if (!articleAjaxLock && nextPageUrl.val() !== "null") {
        load(event, nextPageUrl.val(), vw, vwType, function (newPageUrl) {
          $('#vertical-widget--js-var-next-page-article-url').val(decodeURI(newPageUrl));
          unLockAjax(vwType);
          $('.article-btnShowMore').fadeOut(0).fadeIn();
        });
      }
    }); // $(window).scroll(function () {
    //     if (isScrolledIntoView($('.article-lastITemSensor'))) {
    //
    //         var vwType = 'pamphlet';
    //         var nextPageUrl = $('#vertical-widget--js-var-next-page-article-url');
    //         var vw = $('#article-vertical-widget');
    //
    //         if (!articleAjaxLock && nextPageUrl.val() !== "null") {
    //             load(event, nextPageUrl.val(), vw, vwType, function (newPageUrl) {
    //                 $('#vertical-widget--js-var-next-page-article-url').val(decodeURI(newPageUrl));
    //                 unLockAjax(vwType);
    //             });
    //         }
    //
    //     }
    // });
  }

  function loadAjaxContent(contentData) {
    var hasPamphletOrArticle = false;
    var hasItem = false;
    var hasPamphlet = false;

    if (typeof contentData.product !== 'undefined' && contentData.product !== null && contentData.product.total > 0) {
      initProduct(contentData.product);
      $('#product-carousel-warper').fadeIn();
      hasItem = true;
    } else {
      $('#product-carousel-warper').fadeOut();
    }

    if (typeof contentData.video !== 'undefined' && contentData.video !== null && contentData.video.total > 0) {
      initVideo(contentData.video);
      $('#video-carousel-warper').fadeIn();
      hasItem = true;
    } else {
      $('#video-carousel-warper').fadeOut();
    }

    if (typeof contentData.set !== 'undefined' && contentData.set !== null && contentData.set.total > 0) {
      initSet(contentData.set);
      $('#set-carousel-warper').fadeIn();
      hasItem = true;
    } else {
      $('#set-carousel-warper').fadeOut();
    }

    if (typeof contentData.pamphlet !== 'undefined' && contentData.pamphlet !== null && contentData.pamphlet.total > 0) {
      hasPamphlet = true;
      initPamphlet(contentData.pamphlet); // $('#pamphlet-vertical-tabpanel').fadeIn();

      $('#pamphlet-vertical-tab').fadeIn();
      $('#pamphlet-vertical-tab a').trigger('click');
      hasPamphletOrArticle = true;
      hasItem = true;
    } else {
      // $('#pamphlet-vertical-tabpanel').fadeOut();
      $('#pamphlet-vertical-tab').fadeOut();
    }

    if (typeof contentData.article !== 'undefined' && contentData.article !== null && contentData.article.data.length > 0) {
      initArticle(contentData.article); // $('#article-vertical-tabpanel').fadeIn();

      $('#article-vertical-tab').fadeIn();

      if (!hasPamphlet) {
        $('#article-vertical-tab a').trigger('click');
      }

      hasPamphletOrArticle = true;
      hasItem = true;
    } else {
      // $('#article-vertical-tabpanel').fadeOut();
      $('#article-vertical-tab').fadeOut();
    }

    if (hasPamphletOrArticle) {
      $('.ProductAndSetAndVideoWraper').removeClass('col').addClass('col-12 col-md-9');
      $('.PamphletAndArticleWraper').removeClass('d-none');
    } else {
      $('.ProductAndSetAndVideoWraper').removeClass('col-12 col-md-9').addClass('col');
      $('.PamphletAndArticleWraper').removeClass('d-none').addClass('d-none');
    }

    var contentSearchFilter = '#contentSearchFilter';
    $(contentSearchFilter).removeClass('lockActiveStep');

    if (!hasItem) {
      $('.notFoundMessage').fadeIn();
      var contentSearchFilterSelectorItem = '#contentSearchFilter .selectorItem[data-select-active="true"]';

      if (typeof $(contentSearchFilterSelectorItem).attr('data-select-order') !== 'undefined' && parseInt($(contentSearchFilterSelectorItem).attr('data-select-order')) !== 4) {
        $(contentSearchFilter).addClass('lockActiveStep');
      }
    } else {
      $('.notFoundMessage').fadeOut();
    }
  }

  function addLoadingItem(owl, owlType) {
    if (owlType === 'product' || owlType === 'video' || owlType === 'set') {
      var loadingHtml = '<div class="a--owlCarouselLoading"><div style="width: 30px; display: inline-block;" class="m-loader m-loader--primary m-loader--lg"></div></div>';
      owl.trigger('add.owl.carousel', [jQuery(loadingHtml)]);
    } else if (owlType === 'pamphlet' || owlType === 'article') {
      owl.append('<div class="a--vw-Loading"><div style="width: 30px; display: inline-block;" class="m-loader m-loader--primary m-loader--lg"></div></div>');
    }
  }

  function removeLoadingItem(owl, owlType) {
    if (owlType === 'product' || owlType === 'video' || owlType === 'set') {
      var lastIndex = owl.find('.owl-item').length;
      owl.trigger('remove.owl.carousel', [lastIndex - 1]).trigger('refresh.owl.carousel');
    } else if (owlType === 'pamphlet' || owlType === 'article') {
      owl.find('.a--vw-Loading').remove();
    }
  } // function isScrolledIntoView(elem) {
  //     if (elem.length === 0) {
  //         return false;
  //     }
  //     var docViewTop = $(window).scrollTop();
  //     var docViewBottom = docViewTop + $(window).height();
  //     var elemTop = $(elem).offset().top;
  //     var elemBottom = elemTop + $(elem).height();
  //     return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom) && (elemBottom <= docViewBottom) && (elemTop >= docViewTop));
  // }


  function clearOwlcarousel(owl) {
    var length = owl.find('.item').length;

    while (length > 0) {
      owl.trigger('remove.owl.carousel', 0).trigger('refresh.owl.carousel');
      length = owl.find('.item').length;
    }
  }

  return {
    init: function init(contentData) {
      loadAjaxContent(contentData);
    },
    clearFields: function clearFields() {
      clearOwlcarousel($('#product-carousel-warper .a--owl-carousel-type-1'));
      clearOwlcarousel($('#set-carousel-warper .a--owl-carousel-type-1'));
      clearOwlcarousel($('#video-carousel-warper .a--owl-carousel-type-1'));
      $('#pamphlet-vertical-widget').html('');
      $('#article-vertical-widget').html('');
    }
  };
}();

var CustomInitMultiLevelSearch = function () {
  var filterData = null;
  var tags = null;
  var tagsFromController = null;
  var selectedVlues = null;
  var emptyFields = null;

  function _addUnderLine(string) {
    if (typeof string === 'undefined' || string === null) {
      return '';
    }

    return string.replace(/ /g, '_');
  }

  function _removeUnderLine(string) {
    return string.replace(/_/g, ' ');
  }

  function getTags() {
    // var url = new URL(window.location.href);
    // var tags = url.searchParams.getAll("tags[]");
    var tags = getUrlParams(window.location.href, /(tags\[[0-9]*\])/g);
    var tagValue = [];

    for (var index in tags) {
      tagValue.push(tags[index].value);
    }

    return tagValue;
  }

  function getUrlParams(url, param) {
    var res = url.match(/(\?|\&)([^=]+)\=([^&]+)/g);
    var params = [];

    for (var index in res) {
      var tagItem = res[index];
      var paramValue = tagItem.replace(/(\?|\&)([^=]+)\=/g, '');
      var paramName = tagItem.replace('=' + paramValue, '').replace('?', '').replace('&', '');

      if (typeof param !== 'undefined' && paramName.search(param) !== -1) {
        params.push({
          name: paramName,
          value: paramValue
        });
      } else {
        params.push({
          name: paramName,
          value: paramValue
        });
      }
    }

    return params;
  }

  function activeFilter(filterClass) {
    $('.selectorItem').attr('data-select-active', 'false');
    $('.selectorItem.' + filterClass).attr('data-select-active', 'true');
  }

  function getTagsFromControllerOrUrl() {
    var tags = [];

    if (tagsFromController !== null && typeof tagsFromController !== 'undefined') {
      tags = tagsFromController;
    } else {
      tags = getTags();
    }

    return tags;
  }

  function setSelectedNezamFromTags() {
    var selectedVal = filterData.nezam[1];
    var existInTags = false;
    var tags = getTagsFromControllerOrUrl();

    for (var tagsIndex in tags) {
      for (var nezamIndex in filterData.nezam) {
        var item = filterData.nezam[nezamIndex];

        if (item.value === tags[tagsIndex]) {
          selectedVal = item;
          activeFilter('maghtaSelector');
          existInTags = true;
          break;
        }
      }
    }

    selectedVlues.nezam = selectedVal;

    if (existInTags) {
      var name = _removeUnderLine(selectedVal.value);

      $('.selectorItem.nezamSelector').attr('data-select-value', name);
      return name;
    } else {
      return false;
    }
  }

  function setSelectedMaghtaFromTags() {
    var selectedNezam = selectedVlues.nezam;
    var selectedMaghta = filterData[selectedNezam.maghtaKey][0];
    var existInTags = false;
    var tags = getTagsFromControllerOrUrl();

    for (var tagsIndex in tags) {
      for (var maghtaIndex in filterData[selectedNezam.maghtaKey]) {
        var item = filterData[selectedNezam.maghtaKey][maghtaIndex];

        if (item.value === tags[tagsIndex]) {
          selectedMaghta = item;
          activeFilter('majorSelector');
          existInTags = true;
          break;
        }
      }
    }

    selectedVlues[selectedNezam.maghtaKey] = selectedMaghta;

    if (existInTags) {
      var name = _removeUnderLine(selectedMaghta.value);

      $('.selectorItem.maghtaSelector').attr('data-select-value', name);
      return name;
    } else {
      return false;
    }
  }

  function setSelectedMajorFromTags() {
    var selectedVal = filterData.major[0];
    var existInTags = false;
    var tags = getTagsFromControllerOrUrl();

    for (var tagsIndex in tags) {
      for (var majorIndex in filterData.major) {
        var value = filterData.major[majorIndex].value;

        if (value === tags[tagsIndex]) {
          selectedVal = filterData.major[majorIndex];
          activeFilter('lessonSelector');
          existInTags = true;
          break;
        }
      }
    }

    selectedVlues.major = selectedVal;

    if (existInTags) {
      var name = _removeUnderLine(selectedVal.value);

      $('.selectorItem.majorSelector').attr('data-select-value', name);
      return name;
    } else {
      return false;
    }
  }

  function setSelectedLessonFromTags() {
    var selectedMajor = selectedVlues.major;
    var selectedLesson = filterData[selectedMajor.lessonKey][0];
    var existInTags = false;
    var tags = getTagsFromControllerOrUrl();

    for (var tagsIndex in tags) {
      for (var lessonIndex in filterData[selectedMajor.lessonKey]) {
        var item = filterData[selectedMajor.lessonKey][lessonIndex];

        if (item.value === tags[tagsIndex]) {
          selectedLesson = item;
          activeFilter('teacherSelector');
          existInTags = true;
          break;
        }
      }
    }

    selectedVlues.lesson = selectedLesson;

    if (existInTags) {
      var name = _removeUnderLine(selectedLesson.index);

      $('.selectorItem.lessonSelector').attr('data-select-value', name);
      return name;
    } else {
      return false;
    }
  }

  function setSelectedTeacherFromTags() {
    var selectedLesson = selectedVlues.lesson.value;
    var selectedTeacher = filterData.lessonTeacher[selectedLesson][0];
    var existInTags = false;
    var tags = getTagsFromControllerOrUrl();

    for (var tagsIndex in tags) {
      for (var teacherIndex in filterData.lessonTeacher[selectedLesson]) {
        var item = filterData.lessonTeacher[selectedLesson][teacherIndex];

        if (item.value === tags[tagsIndex]) {
          selectedTeacher = item;
          activeFilter('teacherSelector');
          existInTags = true;
          break;
        }
      }
    }

    selectedVlues.teacher = selectedTeacher;

    if (existInTags) {
      var name = _removeUnderLine(selectedTeacher.value);

      $('.selectorItem.teacherSelector').attr('data-select-value', name);
      return name;
    } else {
      return false;
    }
  }

  function initSelectorItem(selectorClass, selectedValue, filterDataArray) {
    $(selectorClass).find('.subItem').remove();
    appendSubItems(filterDataArray, selectorClass, selectedValue);
    fadeOutSubItemsIfDisplayTypeIsSelect2(selectorClass, filterDataArray, selectedValue);
  }

  function initNezam() {
    var selectorClass = '.nezamSelector';
    var selectedValue = setSelectedNezamFromTags();
    var filterDataArray = filterData.nezam;
    initSelectorItem(selectorClass, selectedValue, filterDataArray);
    setSelectedNezamFromTags();
  }

  function initMaghta() {
    var selectorClass = '.maghtaSelector';
    var selectedValue = setSelectedMaghtaFromTags();
    var maghta = selectedVlues.nezam.maghtaKey;
    var filterDataArray = filterData[maghta];
    initSelectorItem(selectorClass, selectedValue, filterDataArray);
    setSelectedMaghtaFromTags();
  }

  function initMajor() {
    var selectorClass = '.majorSelector';
    var selectedValue = setSelectedMajorFromTags();
    var filterDataArray = filterData.major;
    initSelectorItem(selectorClass, selectedValue, filterDataArray);
  }

  function initLessons() {
    var selectorClass = '.lessonSelector';
    var selectedValue = setSelectedLessonFromTags();
    var major = selectedVlues.major.lessonKey;
    var filterDataArray = filterData[major];
    initSelectorItem(selectorClass, selectedValue, filterDataArray);
  }

  function initTeacher() {
    var selectorClass = '.teacherSelector';
    var selectedValue = setSelectedTeacherFromTags();
    var lesson = selectedVlues.lesson.value;
    var filterDataArray = filterData.lessonTeacher[lesson];
    initSelectorItem(selectorClass, selectedValue, filterDataArray);
  }

  function fadeOutSubItemsIfDisplayTypeIsSelect2(selectorClass, filterDataArray, selectedValue) {
    var showType = getDisaplayType(selectorClass);

    if (showType === 'select2') {
      var selectorOrder = $(selectorClass).attr('data-select-order');

      if (selectedValue === false) {
        if ($('.filterNavigationStep[data-select-order="' + selectorOrder + '"]').hasClass('current')) {
          selectedValue = null;
        } else {
          selectedValue = $(selectorClass).attr('data-select-value');
        }
      }

      $(selectorClass).find('.subItem').fadeOut(0);
      $(selectorClass).find('.form-control.select2').empty();

      for (var index in filterDataArray) {
        var name = filterDataArray[index].value;
        name = _removeUnderLine(name);

        if (selectedValue === name) {
          $(selectorClass).find('.form-control.select2').append("<option value='" + name + "' selected>" + name + "</option>");
        } else {
          $(selectorClass).find('.form-control.select2').append("<option value='" + name + "'>" + name + "</option>");
        }
      }
    } else if (showType === 'grid') {
      $(selectorClass).find('.subItem').fadeIn(0);
    }
  }

  function appendSubItems(filterDataArray, selectorClass, selectedValue) {
    for (var index in filterDataArray) {
      var name = filterDataArray[index].value;
      name = _removeUnderLine(name);

      if (selectedValue === name) {
        $(selectorClass).append('<div class="col subItem" selected="selected">' + name + '</div>');
      } else {
        $(selectorClass).append('<div class="col subItem">' + name + '</div>');
      }
    }
  }

  function _checkEmptyField(string) {
    for (var index in emptyFields) {
      var item = emptyFields[index];

      if (_addUnderLine(item) === _addUnderLine(string)) {
        return '';
      }
    }

    return _addUnderLine(string);
  }

  function getDisaplayType(selectorClass) {
    var showType = $(selectorClass).data('select-display');

    if (typeof showType === 'undefined') {
      showType = 'grid';
    }

    return showType;
  }

  function initSelectedValues() {
    selectedVlues = {
      nezam: filterData.nezam[1],
      maghta: filterData.maghtaJadid[0],
      major: filterData.major[0],
      lesson: filterData.allLessons[0],
      teacher: filterData.lessonTeacher.همه_دروس[0].value
    };
  }

  function initEmptyFields() {
    emptyFields = [filterData.lessonTeacher.همه_دروس[0].value, filterData.allLessons[0].value, filterData.major[0].value, filterData.maghtaGhadim[0].value, filterData.maghtaJadid[0].value];
  }

  return {
    initFilters: function initFilters(contentSearchFilterData, inputTags) {
      filterData = contentSearchFilterData;
      tagsFromController = inputTags;
      initSelectedValues();
      initNezam();
      initMaghta();
      initMajor();
      initLessons();
      initTeacher();
      tagsFromController = null;
    },
    checkEmptyField: function checkEmptyField(contentSearchFilterData, string) {
      initEmptyFields();
      return _checkEmptyField(string);
    },
    addUnderLine: function addUnderLine(string) {
      return _addUnderLine(string);
    },
    removeUnderLine: function removeUnderLine(string) {
      return _removeUnderLine(string);
    }
  };
}();

var GetAjaxData = function () {
  function _refreshTags(contentSearchFilterData) {
    var pageTagsListBadge = '.pageTags .m-list-badge__items';
    $(pageTagsListBadge).find('.m-list-badge__item').remove();
    var searchFilterData = MultiLevelSearch.getSelectedData();
    var url = document.location.href.split('?')[0];
    var tagsValue = '';

    for (var index in searchFilterData) {
      var selectedText = searchFilterData[index].selectedText;
      selectedText = CustomInitMultiLevelSearch.checkEmptyField(contentSearchFilterData, selectedText);

      if (typeof selectedText !== 'undefined' && selectedText !== null && selectedText !== '') {
        tagsValue += '&tags[]=' + selectedText;
        $(pageTagsListBadge).append('<span class="m-list-badge__item m-list-badge__item--focus m--padding-10 m--margin-top-5 m--block-inline  tag_0">\n' + '    <a class="m-link m--font-light" href="' + url + '?tags[]=' + CustomInitMultiLevelSearch.addUnderLine(selectedText) + '">' + CustomInitMultiLevelSearch.removeUnderLine(selectedText) + '</a>\n' + '</span>');
      }
    }

    if (tagsValue !== '') {
      tagsValue = tagsValue.substr(1);
    }

    url += '?' + tagsValue;
    window.addEventListener('popstate', function (event) {
      console.log('popstate fired!');
    }); // window.history.pushState('data to be passed', 'Title of the page', url);
    // The above will add a new entry to the history so you can press Back button to go to the previous state.
    // To change the URL in place without adding a new entry to history use

    history.replaceState('data to be passed', 'Title of the page', url);
    return tagsValue;
  }

  function runWaiting() {
    Alaasearch.clearFields();
    $('.notFoundMessage').fadeOut();
    $('#product-carousel-warper').fadeIn();
    $('#video-carousel-warper').fadeIn();
    $('#set-carousel-warper').fadeIn(); // $('#pamphlet-vertical-tabpanel').fadeIn();

    $('#pamphlet-vertical-tabpanel').removeClass('d-none'); // $('#article-vertical-tabpanel').fadeIn();

    $('#article-vertical-tabpanel').removeClass('d-none');
    $('#pamphlet-vertical-tab').fadeIn();
    $('#article-vertical-tab').fadeIn();
    $('.ProductAndSetAndVideoWraper').removeClass('col').addClass('col-12 col-md-9');
    $('.PamphletAndArticleWraper').removeClass('d-none');
    mApp.block('#product-carousel-warper, #set-carousel-warper, #video-carousel-warper, #pamphlet-vertical-widget, #article-vertical-widget', {
      overlayColor: "#000000",
      type: "loader",
      state: "success",
      message: "کمی صبر کنید..."
    });
  }

  function stopWaiting() {
    mApp.unblock('#product-carousel-warper, #set-carousel-warper, #video-carousel-warper, #pamphlet-vertical-widget, #article-vertical-widget');
  }

  function _getNewDataBaseOnTags(contentSearchFilterData) {
    runWaiting(); // document.location.href

    var tagsValue = _refreshTags(contentSearchFilterData);

    var originUrl = document.location.origin;
    var pathnameUrl = document.location.pathname;
    $.ajax({
      type: 'GET',
      // url: document.location.href,
      url: originUrl + pathnameUrl + '?' + tagsValue,
      data: {},
      dataType: 'json',
      success: function success(data) {
        if (typeof data === 'undefined' || data.error) {
          var message = '';

          if (typeof data !== 'undefined') {
            message = data.error.message;
          }

          toastr.error('خطای سیستمی رخ داده است.' + '<br>' + message);
        } else {
          Alaasearch.init(data.result);
        }

        stopWaiting();
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        var message = ''; // if (jqXHR.status === 403) {
        //     message = 'کد وارد شده اشتباه است.';
        // } else if (jqXHR.status === 422) {
        //     message = 'کد را وارد نکرده اید.';
        // } else {
        //     message = 'خطای سیستمی رخ داده است.';
        // }

        message = 'خطای سیستمی رخ داده است.';
        toastr.error(message);
        stopWaiting();
      }
    });
  }

  return {
    refreshTags: function refreshTags(contentSearchFilterData) {
      _refreshTags(contentSearchFilterData);
    },
    getNewDataBaseOnTags: function getNewDataBaseOnTags(contentSearchFilterData) {
      _getNewDataBaseOnTags(contentSearchFilterData);
    }
  };
}();

jQuery(document).ready(function () {
  $.ajaxSetup({
    cache: false
  });
  var owl = jQuery('.a--owl-carousel-type-1');
  owl.each(function () {
    $(this).owlCarousel({
      stagePadding: 0,
      loop: false,
      rtl: true,
      nav: true,
      dots: false,
      margin: 10,
      mouseDrag: true,
      touchDrag: true,
      pullDrag: true,
      responsiveClass: true,
      responsive: {
        0: {
          items: 1
        },
        400: {
          items: 2
        },
        600: {
          items: 3
        },
        800: {
          items: 4
        },
        1190: {
          items: 3
        },
        1400: {
          items: 4
        }
      }
    });
  });
  Alaasearch.init(contentData);
  CustomInitMultiLevelSearch.initFilters(contentSearchFilterData, tags);
  MultiLevelSearch.init({
    selectorId: 'contentSearchFilter'
  }, function () {
    GetAjaxData.refreshTags(contentSearchFilterData);
    CustomInitMultiLevelSearch.initFilters(contentSearchFilterData);
    GetAjaxData.getNewDataBaseOnTags(contentSearchFilterData);
  }, function () {
    GetAjaxData.refreshTags(contentSearchFilterData);
    CustomInitMultiLevelSearch.initFilters(contentSearchFilterData);
  });
});
