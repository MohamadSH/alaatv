var Alist2 = function () {

    function getItem(data) {
        // data : {
        //     link: 'http://...',
        //     img: '<img src="" alt="">',
        //     title: 'title',
        //     info: 'info',
        //     desc: 'desc',
        //     action: 'action',
        // }
        return '' +
            '<div class="a--list2-item '+data.class+'" '+data.attr+'>\n' +
            '    <div class="a--list2-thumbnail">\n' +
            '        <a href="' + data.link + '">\n' +
            '            ' + data.img + '\n' +
            '        </a>\n' +
            '    </div>\n' +
            '    <div class="a--list2-content">\n' +
            '        <h2 class="a--list2-title">\n' +
            '            <a href="' + data.link + '">' + data.title + '</a>\n' +
            '        </h2>\n' +
            '        <div class="a--list2-info">\n' +
            '            ' + data.info + '\n' +
            '        </div>\n' +
            '        <div class="a--list2-desc">\n' +
            '            ' + data.desc + '\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="a--list2-action">\n' +
            '        ' + data.action + '\n' +
            '    </div>\n' +
            '</div>';
    }

    return {
        getItem: getItem
    };

}();
