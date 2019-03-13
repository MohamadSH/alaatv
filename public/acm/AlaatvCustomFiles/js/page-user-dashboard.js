var UserAssets = function () {

    let lcokLoadNextPage = false;

    function loadContents(contentUrl, contentType, refresh) {

        if (lcokLoadNextPage || contentUrl.trim().length === 0) {
            return false;
        }

        /*$(window).scroll(function () {
            let $sensor = null;
            let $nextPageUrl = null;
            if (contentType === 'video') {
                $sensor = $('#video-lastItemSensor');
                $nextPageUrl = $('#videoContentNextPageUrl');
            } else if (contentType === 'pamphlet') {
                $sensor = $('#pamphlet-lastItemSensor');
                $nextPageUrl = $('#pamphletContentNextPageUrl');
            }

            if (isScrolledIntoView($sensor)) {
                if (!lcokLoadNextPage) {
                    loadContents($nextPageUrl.val(), contentType, false);
                }
            }
        });*/

        let modalId = '';
        if (contentType === 'video') {
            modalId = 'videoModal';
        } else if (contentType === 'pamphlet') {
            modalId = 'pamphletModal';
        }

        if (refresh) {
            $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').html('');
            $('#'+modalId).modal('show');
        } else {
            $('.waitingForLoadMoreInModal').fadeIn();
        }

        mApp.block('#'+modalId+' .modal-body', {
            // overlayColor: "#000000",
            type: "loader",
            state: "success",
            message: "کمی صبر کنید..."
        });
        $('#'+modalId+' .modal-body .blockElement').css({
            'top': 'calc( 50% - 17px)',
            'left': 'calc( 50% - 81px)'
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
                    let contents = [];
                    if (contentType === 'video') {
                        contents = data.result.video;
                    } else if (contentType === 'pamphlet') {
                        contents = data.result.pamphlet;
                    }


                    if (refresh) {
                        $('#' + modalId + ' .modal-body .m-widget6 .m-widget6__body').html(createList(contents, contentType));
                    } else {
                        $('#' + modalId + ' .modal-body .m-widget6 .m-widget6__body').append(createList(contents, contentType));
                        $('.waitingForLoadMoreInModal').fadeOut();
                    }
                    let $nextPageUrl = null;
                    if (contentType === 'video') {
                        $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').after('<div id="video-lastItemSensor"></div>');
                        $nextPageUrl = $('#videoContentNextPageUrl');
                        $nextPageUrl.val((data.result.video === null) ? '' : data.result.video.next_page_url);
                    } else if (contentType === 'pamphlet') {
                        $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').after('<div id="pamphlet-lastItemSensor"></div>');
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
            return '<div class="alert alert-warning text-center" role="alert"><strong>موردی یافت نشد!</strong></div>';
        }
        for (let index in data.data) {
            if (isNaN(index)) {
                continue;
            }
            let content = data.data[index];
            let title = content.name;
            let viewLink = content.url;
            let thumbnail = content.thumbnail;
            let downloadLinks = [];

            for (let videoIndex in content.file.video) {
                downloadLinks.push({
                    title: content.file.video[videoIndex].caption,
                    url: content.file.video[videoIndex].link
                });
            }

            for (let videoIndex in content.file.pamphlet) {
                downloadLinks.push({
                    title: content.file.video[videoIndex].caption,
                    url: content.file.video[videoIndex].link
                });
            }

            if (contentType === 'video') {
                $('#video-lastItemSensor').remove();
                list += getRowVideoContent(title, viewLink, downloadLinks, thumbnail);
            } else if (contentType === 'pamphlet') {
                $('#pamphlet-lastItemSensor').remove();
                list += getRowPamphletContent(title, viewLink, downloadLinks, thumbnail);
            }
        }
        return list;
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
                '                                                <a href="'+url+'" class="m-btn btn btn-success">\n' +
                '                                                    <i class="la la-download"></i>\n' +title+
                '                                                </a>\n';
        }

        return '\n' +
            '                                    <div class="m-widget6__item">\n' +
            '                                        <span class="m-widget6__text">\n' +
            '                                           <div class="a-widget6__thumbnail">\n' +
            '                                               <a class="m-link" href="'+viewLink+'"><img src="'+thumbnail+'" alt=""></a>\n' +
            '                                           </div>\n' +
            '                                           <div class="a-widget6__title">\n' +
            '                                               <a class="m-link" href="'+viewLink+'">'+title+'</a>\n' +
            '                                           </div>\n' +
            '                                        </span>\n' +
            '                                        <span class="m-widget6__text">\n' +
            '                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">\n' +
            '                                                <a href="'+viewLink+'" class="m-btn btn btn-info">\n' +
            '                                                    <i class="la la-eye"></i>\n' +
            '                                                </a>\n' +
                                                             downloadBtns+
            '                                            </div>\n' +
            '                                        </span>\n' +
            '                                    </div>';
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
                '                                                <a href="'+url+'" class="m-btn btn btn-success">\n' +
                '                                                    <i class="la la-download"></i>\n' +title+
                '                                                </a>\n';
        }
        return '\n' +
            '                                    <div class="m-widget6__item">\n' +
            '                                        <span class="m-widget6__text">\n' +
            '                                           <div class="a-widget6__thumbnail">\n' +
            '                                               <a class="m-link" href="'+viewLink+'"><img src="'+thumbnail+'" alt=""></a>\n' +
            '                                           </div>\n' +
            '                                           <div class="a-widget6__title">\n' +
            '                                               <a class="m-link" href="'+viewLink+'">'+title+'</a>\n' +
            '                                           </div>\n' +
            '                                        </span>\n' +
            '                                        <span class="m-widget6__text">\n' +
            '                                            <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="First group">\n' +
            '                                                <a href="'+viewLink+'" class="m-btn btn btn-info">\n' +
            '                                                    <i class="la la-eye"></i>\n' +
            '                                                </a>\n' +
                                                             downloadBtns+
            '                                            </div>\n' +
            '                                        </span>\n' +
            '                                    </div>';
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
    $('#owlCarouselMyProduct').OwlCarouselType2();
    $('#owlCarouselMyFavoritSet').OwlCarouselType2();
    $('#owlCarouselMyFavoritContent').OwlCarouselType2();
    $('#owlCarouselMyFavoritProducts').OwlCarouselType2();
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