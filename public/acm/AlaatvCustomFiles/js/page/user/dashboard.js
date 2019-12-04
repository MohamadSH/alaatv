var UserAssets = function () {

    let lockLoadNextPage = false;

    function loadContents(contentUrl, contentType, refresh) {

        if (lockLoadNextPage || contentUrl.trim().length === 0) {
            return false;
        }

        let modalId = '';
        if (contentType === 'video') {
            modalId = 'videoModal';
        } else if (contentType === 'pamphlet') {
            modalId = 'pamphletModal';
        }

        if (refresh) {
            $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').html('');
            $('#'+modalId).modal('show');
        }

        mApp.block('#'+modalId+' .modal-body', {
            overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });

        // fix position of block in modal
        $('#'+modalId+' .modal-body .blockElement').css({
            'top': 'calc( 50% - 17px)',
            'left': 'calc( 50% - 81px)'
        });

        mApp.block('.btnLoadMoreInModal', {
            type: "loader",
            state: "success",
        });

        lockLoadNextPage = true;

        $.ajax({
            type: 'GET',
            url : contentUrl,
            data: {},
            dataType: 'json',
            success: function (data) {
                lockLoadNextPage = false;
                if (data.error) {
                    let message = 'خطای سیستمی رخ داده است.';
                    $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').html(message);
                } else {
                    // contentType: video-pamphlet
                    let contents = data.result[contentType];

                    createList1(data.result);

                    if (refresh) {
                        $('#' + modalId + ' .modal-body .m-widget6 .m-widget6__body').html(createList(contents, contentType));
                    } else {
                        $('#' + modalId + ' .modal-body .m-widget6 .m-widget6__body').append(createList(contents, contentType));
                    }
                    let $nextPageUrl = null;
                    if (contentType === 'video') {
                        $nextPageUrl = $('#videoContentNextPageUrl');
                        $nextPageUrl.val((data.result.video === null) ? '' : data.result.video.next_page_url);
                    } else if (contentType === 'pamphlet') {
                        $nextPageUrl = $('#pamphletContentNextPageUrl');
                        $nextPageUrl.val((data.result.pamphlet === null) ? '' : data.result.pamphlet.next_page_url);
                    }

                    if ($nextPageUrl.val().trim().length === 0) {
                        $('.btnLoadMoreInModal').fadeOut();
                    } else {
                        $('.btnLoadMoreInModal').fadeIn();
                    }
                }
                mApp.unblock('#'+modalId+' .modal-body');
                mApp.unblock('.btnLoadMoreInModal');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                lockLoadNextPage = false;
                let message = 'خطای سیستمی رخ داده است.';
                $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').html(message);
                mApp.unblock('#'+modalId+' .modal-body');
            }
        });
    }

    function createList(data, contentType) {
        let list = '';
        if (data === null) {
            return '<div class="alert alert-warning text-center" role="alert"><strong>تاکنون موردی منتشر نشده است!</strong></div>';
        }
        for (let index in data.data) {
            if (isNaN(index)) {
                continue;
            }
            let content = data.data[index];
            list += makeListItemBasedOnContentType(content, contentType);
        }
        return list;
    }

    function makeListItemBasedOnContentType(content, contentType) {
        let listItem = '';
        let title = content.name;

        if (contentType === 'video') {
            title += '<br>' + ' جلسه: ' + content.order;
        }
        let viewLink = content.url;
        let thumbnail = content.thumbnail;
        let downloadLinks = [];
        for (let index in content.file[contentType]) {
            downloadLinks.push({
                title: content.file[contentType][index].caption,
                // title: ' جلسه شماره: ' + content.order,
                url: content.file[contentType][index].link
            });
        }

        if (contentType === 'video') {
            listItem = getRowVideoContent(title, viewLink, downloadLinks, thumbnail);
        } else if (contentType === 'pamphlet') {
            listItem = getRowPamphletContent(title, viewLink, downloadLinks, thumbnail);
        }
        return listItem;
    }

    function getRowVideoContent(title, viewLink, downloadLinks, thumbnail) {
        let downloadBtns = '';
        for (let index in downloadLinks) {
            if (isNaN(index)) {
                continue;
            }
            let downloadLink = downloadLinks[index];
            let title = downloadLink.title;
            let url = downloadLink.url;
            downloadBtns +=
                '<a href="'+url+'" target="_blank" class="m-btn btn btn-success">\n' +
                '    <i class="fa fa-cloud-download-alt"></i>\n' +title+
                '</a>\n';
        }

        if (thumbnail === null) {
            thumbnail = '/assets/app/media/img/files/mp4.svg';
        }

        return '\n' +
            '<div class="m-widget6__item contentItem">\n' +
            '    <span class="m-widget6__text">\n' +
            '       <div class="a-widget6__thumbnail itemThumbnail">\n' +
            '           <a class="m-link" target="_blank" href="'+viewLink+'"><img src="'+thumbnail+'" alt="'+title+'"></a>\n' +
            '       </div>\n' +
            '       <div class="a-widget6__title">\n' +
            '           <a class="m-link" href="'+viewLink+'">'+title+'</a>\n' +
            '       </div>\n' +
            '    </span>\n' +
            '    <span class="m-widget6__text">\n' +
            '        <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">\n' +
            '            <a href="'+viewLink+'" target="_blank" class="m-btn btn btn-info">\n' +
            '                <i class="fa fa-edit"></i>\n' +
            '            </a>\n' +
                            downloadBtns+
            '        </div>\n' +
            '    </span>\n' +
            '</div>';
    }

    function getRowPamphletContent(title, viewLink, downloadLinks, thumbnail) {
        let downloadBtns = '';
        for (let index in downloadLinks) {
            if (isNaN(index)) {
                continue;
            }
            let downloadLink = downloadLinks[index];
            let title = downloadLink.title;
            let url = downloadLink.url;
            downloadBtns +=
                '<a href="'+url+'" target="_blank" class="m-btn btn btn-success">\n' +
                '    <i class="fa fa-cloud-download-alt"></i>\n' +title+
                '</a>\n';
        }
        if (thumbnail === null) {
            thumbnail = '/assets/app/media/img/files/pdf.svg';
        }
        return '\n' +
            '<div class="m-widget6__item contentItem">\n' +
            '    <span class="m-widget6__text">\n' +
            '       <div class="a-widget6__thumbnail itemThumbnail">\n' +
            '           <a class="m-link" target="_blank" href="'+viewLink+'"><img src="'+thumbnail+'" alt="'+title+'"></a>\n' +
            '       </div>\n' +
            '       <div class="a-widget6__title">\n' +
            '           <a class="m-link" target="_blank" href="'+viewLink+'">'+title+'</a>\n' +
            '       </div>\n' +
            '    </span>\n' +
            '    <span class="m-widget6__text">\n' +
            '        <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">\n' +
            '            <a href="'+viewLink+'" target="_blank" class="m-btn btn btn-info">\n' +
            '                <i class="fa fa-eye"></i>\n' +
            '            </a>\n' +
                         downloadBtns+
            '        </div>\n' +
            '    </span>\n' +
            '</div>';
    }

    function isScrolledIntoView(elem) {
        if (elem.length === 0) {
            return false;
        }
        let docViewTop = $(window).scrollTop();
        let docViewBottom = docViewTop + $(window).height();
        let elemTop = $(elem).offset().top;
        let elemBottom = elemTop + $(elem).height();
        return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom) && (elemBottom <= docViewBottom) && (elemTop >= docViewTop));
    }

    // new
    function createList1(data) {
        console.log(data);
    }

    function ajax(contentUrl, callback) {

        if (lockLoadNextPage || contentUrl.trim().length === 0) {
            return false;
        }

        AlaaLoading.show();
        //
        // // fix position of block in modal
        // $('#'+modalId+' .modal-body .blockElement').css({
        //     'top': 'calc( 50% - 17px)',
        //     'left': 'calc( 50% - 81px)'
        // });

        lockLoadNextPage = true;

        $.ajax({
            type: 'GET',
            url : contentUrl,
            data: {},
            dataType: 'json',
            success: function (data) {
                lockLoadNextPage = false;
                if (data.error) {
                    // let message = 'خطای سیستمی رخ داده است.';
                    // $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').html(message);
                } else {
                    // contentType: video-pamphlet
                    callback(data.result);
                }
                AlaaLoading.hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                lockLoadNextPage = false;
                // let message = 'خطای سیستمی رخ داده است.';
                // $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').html(message);
                AlaaLoading.hide();
            }
        });
    }

    function loadNewData(url) {
        ajax(url, callback)
    }

    function loadNextPage() {

    }

    function createVideoListHtmlData(data) {
        setNextPageUrlVideo(data.next_page_url);
        var htmlData = '',
            dataLength = data.data.length;
        for(var i = 0; i < dataLength; i++) {
            var item = data.data[i];
            htmlData += getVideoItem({
                src: item.thumbnail,
                title: item.name,
                link: item.url,
                setName: item.set.name,
                lastUpdate: item.updated_at,
                order: item.order,
            });
        }
        return htmlData;
    }

    function getVideoItem(data) {
        return '' +
            '<div class="item ">\n' +
            '    <div class="pic">\n' +
            '        <a href="http://alaatv.test/c/16839" class="d-block">\n' +
            '            <img src="https://cdn.alaatv.com/loder.jpg?w=1&h=1" data-src="'+data.src+'" alt="'+data.title+'" class="a--full-width lazy-image videoImage" width="253" height="142">\n' +
            '        </a>\n' +
            '    </div>\n' +
            '    <div class="content">\n' +
            '        <div class="title">\n' +
            '            <h2>\n' +
            '                <a href="'+data.link+'" class="m-link">\n' +
            '                    '+data.title +
            '                </a>\n' +
            '            </h2>\n' +
            '        </div>\n' +
            '        <div class="detailes">\n' +
            '            <div class="videoDetaileWrapper">\n' +
            '                <span>\n' +
            '                    <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon">\n' +
            '                        <path d="M3.67 8.67h14V11h-14V8.67zm0-4.67h14v2.33h-14V4zm0 9.33H13v2.34H3.67v-2.34zm11.66 0v7l5.84-3.5-5.84-3.5z" class="style-scope yt-icon"></path>\n' +
            '                    </svg>\n' +
            '                </span>\n' +
            '                <span> از دوره </span>\n' +
            '                <span>'+data.setName+'</span>\n' +
            '                <br>\n' +
            '                <i class="fa fa-calendar-alt m--margin-right-5"></i>\n' +
            '                <span>تاریخ بروزرسانی: </span>\n' +
            '                <span>'+data.lastUpdate+'</span>\n' +
            '                <div class="videoOrder">\n' +
            '                    <div class="videoOrder-title">جلسه</div>\n' +
            '                    <div class="videoOrder-number">'+data.order+'</div>\n' +
            '                    <div class="videoOrder-om"> اُم </div>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="itemHover"></div>\n' +
            '</div>';
    }

    function setNextPageUrlVideo(url) {
        $('#videoContentNextPageUrl').val(url);
    }

    function getNextPageUrlVideo() {
        return $('#videoContentNextPageUrl').val();
    }

    function appendToContentSetList(data) {
        $('#searchResult_video .searchResult .listType').html(data.video);
        $('#searchResult_pamphlet .m-widget4').html(data.pamphlet);
    }

    function loadNewContentSetList(data) {
        $('#searchResult_video .searchResult .listType').append(data.video);
        $('#searchResult_pamphlet .m-widget4').append(data.pamphlet);
    }

    return {
        loadContents: function (contentUrl, contentType, refresh) {
            loadContents(contentUrl, contentType, refresh);
        },
    };
}();

function moveUpBtns(dom) {
    $('.a--block-item .a--block-detailesWrapper').css({'position':'relative', 'top':'auto', 'left':'auto', 'width':'100%', 'transform':'scale(1)'});
    $('.a--block-item .a--block-detailesWrapper .btn-group-sm').css({'transform':'scale(1)'});
    $('.a--block-item .a--block-imageWrapper img').css({'filter':'none'});

    if ($(dom).parents('.a--block-item').find('.a--owl-carousel-show-detailes').length > 0) {
        $(dom).parents('.a--block-item').find('.a--owl-carousel-show-detailes').trigger('click');
    } else {
        $(dom).css({'filter':'blur(3px)'});
        $(dom).parents('.a--block-item').find('.a--block-detailesWrapper').css({'position':'absolute', 'top':'calc( 50% - 16px)', 'left':'0'});
        $(dom).parents('.a--block-item').find('.a--block-detailesWrapper .btn-group-sm').css({'transform':'scale(1.5)'});
    }
}

$(document).ready(function () {
    var OwlCarouselType2Option = {
        OwlCarousel: {
            btnSwfitchEvent: function() {
                imageObserver.observe();
                gtmEecProductObserver.observe();
            }
        },
        grid: {
            btnSwfitchEvent: function() {
                imageObserver.observe();
                gtmEecProductObserver.observe();
            }
        },
        defaultView: 'grid',
    };
    $('#owlCarouselMyProduct').OwlCarouselType2(OwlCarouselType2Option);
    $('#owlCarouselMyFavoritSet').OwlCarouselType2(OwlCarouselType2Option);
    $('#owlCarouselMyFavoritContent').OwlCarouselType2(OwlCarouselType2Option);
    $('#owlCarouselMyFavoritProducts').OwlCarouselType2(OwlCarouselType2Option);
    $(document).on('click', '.btnViewVideo, .btnViewPamphlet, .select-item', function () {
        let contentType = $(this).data('content-type'),
            contentUrl = $(this).data('content-url'),
            $nextPageUrl = null;

        if ($(this).hasClass('select-item')) {
            contentType = $(this).find('btnViewVideo').data('content-type');
            contentUrl = $(this).find('btnViewVideo').data('content-url');
        }

        if (contentType === 'video') {
            $nextPageUrl = $('#videoContentNextPageUrl');
        } else if (contentType === 'pamphlet') {
            $nextPageUrl = $('#pamphletContentNextPageUrl');
        }
        if ($nextPageUrl !== null && $nextPageUrl.val().trim().length === 0) {
            $('.btnLoadMoreInModal').fadeOut();
        } else {
            $('.btnLoadMoreInModal').fadeIn();
        }

        UserAssets.loadContents(contentUrl, contentType, true);
    });
    $(document).on('click', '.btnLoadMoreInModal', function () {
        let $nextPageUrl = null;
        let contentType = $(this).data('content-type');
        if (contentType === 'video') {
            $nextPageUrl = $('#videoContentNextPageUrl');
        } else if (contentType === 'pamphlet') {
            $nextPageUrl = $('#pamphletContentNextPageUrl');
        }
        UserAssets.loadContents($nextPageUrl.val(), contentType, false);
    });
});
