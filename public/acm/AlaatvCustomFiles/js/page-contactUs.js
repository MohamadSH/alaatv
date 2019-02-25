var Inputmask = {
    init: function () {
        $('input[type="text"][name="email"]').inputmask({
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
            greedy: !1,
            onBeforePaste: function (m, a) {
                return (m = m.toLowerCase()).replace("mailto:", "")
            },
            definitions: {"*": {validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~-]", cardinality: 1, casing: "lower"}}
        });
        $('input[type="text"][name="phone"]').inputmask({
            mask: "9{8,11}",
            greedy: !1,
            onBeforePaste: function (m, a) {
                return (m = m.toLowerCase()).replace("mailto:", "")
            },
            definitions: {"*": {validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~-]", cardinality: 1, casing: "lower"}}
        });
    }
};
jQuery(document).ready(function () {
    Inputmask.init()
});