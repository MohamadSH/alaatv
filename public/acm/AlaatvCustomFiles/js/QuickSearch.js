var QuickSearch = function () {

    function showDataOnQuickSearchResultPannel(html) {
        $('.a-quick-search .m-dropdown__content').html('');
        $('.a-quick-search .m-dropdown__content').append('<dvi class="a-dropdown__search-result">'+html+'</dvi>');
        window.imageObserver.observe();
    }

    function showResultForQuickSearch(res) {
        var maxRecordOfEachCategory = 3;
        var article = res.result.article;
        var pamphlet = res.result.pamphlet;
        var product = res.result.product;
        var set = res.result.set;
        var video = res.result.video;

        var html = '';

        html += gteQuickSearchResultCategory('article', 'مقالات', article, maxRecordOfEachCategory);
        html += gteQuickSearchResultCategory('pamphlet', 'جزوات', pamphlet, maxRecordOfEachCategory);
        html += gteQuickSearchResultCategory('product', 'محصولات', product, maxRecordOfEachCategory);
        html += gteQuickSearchResultCategory('set', 'دسته ها', set, maxRecordOfEachCategory);
        html += gteQuickSearchResultCategory('video', 'ویدیوها', video, maxRecordOfEachCategory);
        showDataOnQuickSearchResultPannel(html);
    }

    function getQuickSearchResultItem(data) {
        return Alist2.getItem({
            link: data.link,
            title: data.title,
            class: '',
            attr: '',
            info: data.subtitle,
            desc: '',
            action:
                '        <a href="' + data.fileLink + '" class="downloadPamphletIcon">\n' +
                '            <i class="fa fa-cloud-download-alt"></i>\n' +
                '        </a>\n',
            img: '<img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="'+data.photo+'" alt="" class="a--full-width lazy-image"  width="'+data.width+'" height="'+data.height+'">',
        });
    }

    function getInputDataForQuickSearchShowResult(categoryType, data) {
        if (categoryType === 'video') {
            return {
                title: data.author.full_name,
                subtitle: data.name,
                photo: data.thumbnail,
                link: data.url,
                width: '453',
                height: '254'
            };
        } else if (categoryType === 'set') {
            return {
                title: data.shortName,
                subtitle: data.name,
                photo: data.photo,
                link: data.url,
                width: '453',
                height: '254'
            };
        } else if (categoryType === 'product') {
            return {
                title: data.name,
                subtitle: '',
                photo: data.photo,
                link: data.url,
                width: '400',
                height: '400'
            };
        } else if (categoryType === 'pamphlet') {
            return {
                title: data.author.full_name,
                subtitle: data.name,
                photo: data.thumbnail,
                link: data.url,
                width: '453',
                height: '254'
            };
        } else if (categoryType === 'article') {
            return {
                title: data.author.full_name,
                subtitle: data.name,
                photo: data.thumbnail,
                link: data.url,
                width: '453',
                height: '254'
            };
        }
    }

    function gteQuickSearchResultCategory(categoryType, categoryName, data, maxRecordOfCategory) {
        var html = '';
        if (data !== null && data.total > 0) {
            html += '<div class="kt-quick-search__category">'+categoryName+'</div>';
            html += '<div class="a--list2">';
            for (var index in data.data) {
                if(isNaN(index)) {
                    continue;
                }
                if(index > maxRecordOfCategory) {
                    break;
                }
                var dataItem = data.data[index];
                var inputData = getInputDataForQuickSearchShowResult(categoryType, dataItem);
                html += getQuickSearchResultItem(inputData);
            }
            html += '</div>';
        }
        return html;
    }

    function onClose() {
        showDataOnQuickSearchResultPannel('');
    }

    function onKeyUp(the) {
        if ($('#m_quicksearch_input').val().trim().length < 3) {
            showDataOnQuickSearchResultPannel('');
            return false;
        }
        showDataOnQuickSearchResultPannel('کمی صبر کنید ...');
        the.showProgress();

        $.ajax({
            url: '/c?q=' + $('#m_quicksearch_input').val(),
            data: {},
            dataType: 'json',
            success: function(res) {
                the.hideProgress();
                the.showResult(res);

                showResultForQuickSearch(res);
            },
            error: function(res) {
                the.hideProgress();
                the.showError('مشکلی پیش آمده است. لطفا بعدا امتحان کنید.');
            }
        });
    }

    function init() {
        mLayout.initQuicksearch({
            onClose: onClose,
            onKeyUp: onKeyUp
        });
    }

    return {
        init: init
    };
}();
