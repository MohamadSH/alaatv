var Alist1 = function () {

    function getItem(data) {

        var action =
            '    <div class="a--list1-action">\n' +
            '        ' + data.action + '\n' +
            '    </div>\n',
            tooltip = {
                title: '',
                info: '',
                desc: '',
            };

        if (typeof data.tooltip !== 'undefined' && data.tooltip) {
            tooltip = {
                title: 'data-toggle="m-tooltip" title="' + data.title + '" data-placement="top"',
                info: 'data-toggle="m-tooltip" title="' + data.info + '" data-placement="top"',
                desc: 'data-toggle="m-tooltip" title="' + data.desc + '" data-placement="top"',
            }
        }
        if (data.action === false) {
            action = '';
            data.class += ' noAction ';
        }

        return '' +
            '<div class="a--list1-item '+data.class+'" '+data.attr+'>\n' +
            '    <div class="a--list1-thumbnail">\n' +
            '        <a href="' + data.link + '">\n' +
            '            ' + data.img + '\n' +
            '        </a>\n' +
            '    </div>\n' +
            '    <div class="a--list1-content">\n' +
            '        <h2 class="a--list1-title">\n' +
            '            <a href="' + data.link + '" ' + tooltip.title + '>' + data.title + '</a>\n' +
            '        </h2>\n' +
            '        <div class="a--list1-info" ' + tooltip.info + '>\n' +
            '            ' + data.info + '\n' +
            '        </div>\n' +
            '        <div class="a--list1-desc" ' + tooltip.desc + '>\n' +
            '            ' + data.desc + '\n' +
            '        </div>\n' +
            '    </div>\n' +
                 action +
            '</div>';
    }

    return {
        getItem: getItem
    };

}();
