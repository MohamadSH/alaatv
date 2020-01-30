var CustomInit = function () {

    function persianDatepicker(selector, altSelector, timePicker) {

        $(selector).persianDatepicker({
            altField: altSelector,
            altFormat: "YYYY MM DD",
            observer: true,
            format: 'YYYY/MM/DD HH:mm:ss',
            timePicker: {
                enabled: timePicker,
                meridiem: {
                    enabled: true
                }
            },
            altFieldFormatter: function (unixDate) {
                var targetDatetime = new Date(unixDate);
                if (timePicker) {
                    return targetDatetime.getFullYear() + "-" + (targetDatetime.getMonth() + 1) + "-" + targetDatetime.getDate() + ' ' + targetDatetime.getHours() + ':' + targetDatetime.getMinutes() + ':' + targetDatetime.getSeconds();
                } else {
                    return targetDatetime.getFullYear() + "-" + (targetDatetime.getMonth() + 1) + "-" + targetDatetime.getDate();
                }
            }
        });
    }


    return {
        persianDatepicker: function (selector, altSelector, timePicker) {
            persianDatepicker(selector, altSelector, timePicker);
        },
    };
}();
