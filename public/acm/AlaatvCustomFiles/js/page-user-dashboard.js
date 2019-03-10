var UserAssets = function () {
    
    let UserAssetsProducts = null;

    function getContents(productId, setId, contentType) {
        let contents = [];
        for (let index in UserAssetsProducts[productId].sets[setId].contents) {
            if (isNaN(index)) {
                continue;
            }
            let content = UserAssetsProducts[productId].sets[setId].contents[index];
            if (content.type === contentType) {
                contents.push(content);
            }
        }
        return contents;
    }

    function createContentList(productId, setId, contentType) {
        let contents = getContents(productId, setId, contentType);
        for (let index in contents) {
            if (isNaN(index)) {
                continue;
            }
            let content = contents[index];

        }
    }

    function loadContents(contentUrl, contentType) {

        let modalId = '';
        if (contentType === 'video') {
            modalId = 'videoModal';
        } else if (contentType === 'pamphlet') {
            modalId = 'pamphletModal';
        }
        $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').html('');
        $('#'+modalId).modal('show');

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

        //
        // $.ajax({
        //     type: 'GET',
        //     url : contentUrl,
        //     data: data,
        //     dataType: 'json',
        //     success: function (data) {
        //         if (data.error) {
        //             let message = 'خطای سیستمی رخ داده است.';
        //             $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').html(message);
        //         } else {
        //             $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').html(createList(data, contentType));
        //         }
        //         mApp.unblock('#'+modalId+' .modal-body');
        //     },
        //     error: function (jqXHR, textStatus, errorThrown) {
        //         let message = 'خطای سیستمی رخ داده است.';
        //         $('#'+modalId+' .modal-body .m-widget6 .m-widget6__body').html(message);
        //         mApp.unblock('#'+modalId+' .modal-body');
        //     }
        // });
    }

    function createList(data, contentType) {
        let list = '';
        for (let index in data) {
            if (isNaN(index)) {
                continue;
            }
            let content = data[index];
            let title = content.title;
            let viewLink = content.viewLink;
            let downloadLinks = content.downloadLinks;
            if (contentType === 'video') {
                list += getRowVideoContent(title, viewLink, downloadLinks);
            } else if (contentType === 'pamphlet') {
                list += getRowPamphletContent(title, viewLink, downloadLinks);
            }
        }
        return list;
    }

    function getRowVideoContent(title, viewLink, downloadLinks) {
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
            '                                        '+title+'\n' +
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

    function getRowPamphletContent(title, viewLink, downloadLinks) {
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
            '                                         '+title+'\n' +
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

    return {
        loadContents: function (contentUrl, contentType) {
            loadContents(contentUrl, contentType);
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
        UserAssets.loadContents(contentUrl, contentType);
    });
});