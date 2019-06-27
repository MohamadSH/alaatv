var UserAssets = function () {

    let lcokLoadNextPage = false;

    function loadContents(contentUrl, contentType, refresh) {

        if (lcokLoadNextPage || contentUrl.trim().length === 0) {
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
            // overlayColor: "#000000",
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

        lcokLoadNextPage = true;

        $.ajax({
            type: 'GET',
            url : contentUrl,
            data: {},
            dataType: 'json',
            success: function (data) {
                lcokLoadNextPage = false;
                if (data.error) {
                    let message = 'خطای سیستمی رخ داده است.';
                    $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').html(message);
                } else {
                    // contentType: video-pamphlet
                    let contents = data.result[contentType];

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
                lcokLoadNextPage = false;
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
                '    <i class="la la-download"></i>\n' +title+
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
            '                <i class="la la-eye"></i>\n' +
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
                '    <i class="la la-download"></i>\n' +title+
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
            '                <i class="la la-eye"></i>\n' +
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

    return {
        loadContents: function (contentUrl, contentType, refresh) {
            loadContents(contentUrl, contentType, refresh);
        },
    };
}();


$(document).ready(function () {
    var OwlCarouselType2Option = {
        OwlCarousel: {
            btnSwfitchEvent: function() {
                LazyLoad.image();
            }
        },
        grid: {
            btnSwfitchEvent: function() {
                LazyLoad.image();
            }
        },
    };
    $('#owlCarouselMyProduct').OwlCarouselType2(OwlCarouselType2Option);
    $('#owlCarouselMyFavoritSet').OwlCarouselType2(OwlCarouselType2Option);
    $('#owlCarouselMyFavoritContent').OwlCarouselType2(OwlCarouselType2Option);
    $('#owlCarouselMyFavoritProducts').OwlCarouselType2(OwlCarouselType2Option);
    $(document).on('click', '.btnViewVideo, .btnViewPamphlet', function () {
        let contentType = $(this).data('content-type');
        let contentUrl = $(this).data('content-url');
        let $nextPageUrl = null;
        if (contentType === 'video') {
            $nextPageUrl = $('#videoContentNextPageUrl');
        } else if (contentType === 'pamphlet') {
            $nextPageUrl = $('#pamphletContentNextPageUrl');
        }
        if ($nextPageUrl.val().trim().length === 0) {
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
