var Alist3 = function () {

    function getItem(data) {
        return '' +
            '<div class="a--list3-item '+data.class+'" '+data.attr+'>\n' +
            '    <div class="a--list3-thumbnail">\n' +
            '        <a href="' + data.link + '">\n' +
            '            ' + data.img + '\n' +
            '        </a>\n' +
            '    </div>\n' +
            '    <div class="a--list3-content">\n' +
            '        <h2 class="a--list3-title">\n' +
            '            <a href="' + data.link + '">' + data.title + '</a>\n' +
            '        </h2>\n' +
            '        <div class="a--list3-info">\n' +
            '            ' + data.info + '\n' +
            '        </div>\n' +
            '        <div class="a--list3-desc">\n' +
            '            ' + data.desc + '\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="a--list3-action">\n' +
            '        ' + data.action + '\n' +
            '    </div>\n' +
            '</div>';
    }

    return {
        getItem: getItem
    };

}();
