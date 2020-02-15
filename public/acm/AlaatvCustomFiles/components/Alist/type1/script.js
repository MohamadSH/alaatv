var Alist1 = function () {

    function getItem(data) {
        return '' +
            '<div class="a--list1-item '+data.class+'" '+data.attr+'>\n' +
            '    <div class="a--list1-thumbnail">\n' +
            '        <a href="' + data.link + '">\n' +
            '            ' + data.img + '\n' +
            '        </a>\n' +
            '    </div>\n' +
            '    <div class="a--list1-content">\n' +
            '        <h2 class="a--list1-title">\n' +
            '            <a href="' + data.link + '">' + data.title + '</a>\n' +
            '        </h2>\n' +
            '        <div class="a--list1-info">\n' +
            '            ' + data.info + '\n' +
            '        </div>\n' +
            '        <div class="a--list1-desc">\n' +
            '            ' + data.desc + '\n' +
            '        </div>\n' +
            '    </div>\n' +
            '    <div class="a--list1-action">\n' +
            '        ' + data.action + '\n' +
            '    </div>\n' +
            '</div>';
    }

    return {
        getItem: getItem
    };

}();
