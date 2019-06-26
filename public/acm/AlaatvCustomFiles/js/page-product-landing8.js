$(document).ready(function () {
    var el = document.querySelector('.konkourTimer');
    var date  = new Date(2019, 6, 3, 24, 0, 0, 0);
    var clock = new FlipClock(el, date, {
        autoPlay: false,
        language: {
            'years': 'سال',
            'months': 'ماه',
            'days': 'روز',
            'hours': 'ساعت',
            'minutes': 'دقیقه',
            'seconds': 'ثانیه'
        },
        face: 'DayCounter',
        // face: 'HourCounter',
        countdown: true,
        showSeconds: true
    });
});