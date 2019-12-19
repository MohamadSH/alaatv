var config = {
    type: 'line',
    data: {
        labels: MONTHS,
        datasets: configBackendDatasets
    },
    options: {
        elements: {
            line: {
                tension: 0
            }
        },
        responsive: true,
        title: {
            display: false,
            text: 'مجموع دونیت ها / مجموع هزینه ها'
        },
        tooltips: {
            mode: 'index',
            intersect: false,
            callbacks: {
                label: function (tooltipItem, data) {
                    return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                },
            },
        },
        hover: {
            mode: 'nearest',
            intersect: true
        },
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: ''
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: ''
                },
                ticks: {
                    callback: function (label, index, labels) {
                        var amount = label / 1000000;
                        if (amount < 1) {
                            amount = amount * 1000;
                            return amount + " هزار تومان";
                        }
                        return amount + " میلیون تومان";

                    },
                    beginAtZero: true,
                    max: 25000000,
                },

            }]
        }
    }
};

var config2 = {
    type: 'pie',
    data: {
        datasets: [{
            data: [
                40,
                4,
                15,
                19,
                22,
                18,
            ],
            backgroundColor: [
                '#c7c7c7',
                '#dadada',
                '#2ae58b',
                '#39e4ce',
                '#ffd555',
                '#ff839c',
            ],
            label: 'دونیت ها بر اساس استان'
        }],
        labels: [
            'فارس',
            'تهران',
            'اصفهان',
            'یزد',
            'هرمزگان',
            'بوشهر'
        ]
    },
    options: {
        responsive: true,
        legend: {display: false}
    }
};

function getCurrencyUnit(value) {
    if (value/1000000>0) {
        return (value/1000000) + 'میلیون';
    } else if (value/1000>0) {
        return (value/1000) + 'هزار';
    }
}

window.onload = function () {
    // if (document.getElementById('monthlychart') !== null) {
    //     var ctx = document.getElementById('monthlychart').getContext('2d');
    //     window.myLine = new Chart(ctx, config);
    // }
    //
    // if (document.getElementById('provincecharts') !== null) {
    //     var ctxx = document.getElementById('provincecharts').getContext('2d');
    //     window.myPie = new Chart(ctxx, config2);
    // }
};

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    Highcharts.chart('monthlychart', {
        credits: {
            enabled: false
        },
        chart: {
            type: 'spline'
        },
        title: {
            text: ''
        },

        subtitle: {
            text: ''
        },
        xAxis: {
            categories: MONTHS
        },
        tooltip: {
            useHTML:true,
            crosshairs: true,
            shared: true,
            formatter: function () {
                var point0Html = (typeof this.points[0] !== 'undefined') ?
                    '<span style="color:#7cb5ec">●</span> مجموع دونیت ها: ' +
                    '<b>'+this.points[0].y+'</b>' +
                    '<br>' : '',
                    point1Html = (typeof this.points[1] !== 'undefined') ?
                        '<span style="color:#434348">●</span> مجموع هزینه ها: ' +
                        '<b>'+getCurrencyUnit(this.points[1].y)+'</b>' +
                        '<br>' : '';
                return '<span>' +
                    '<span style="font-size: 10px">'+this.x+'</span>' +
                    '<br>' +
                    point0Html+
                    point1Html+
                    '</span>';
            }
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        yAxis: {
            title: {
                text: 'مبلغ (تومان)'
            },
            labels: {
                formatter: function () {
                    return getCurrencyUnit(this.value);
                }
            }
        },
        legend: {
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
        },

        series: configBackendDatasets,

    });

    $(document).on('click', '#btnDonationNow', function (e) {
        let amount = $('#amount').val();

        $.ajax({
            type: 'POST',
            url : '/api/v1/donate',
            data: {
                amount: amount
            },
            dataType: 'json',
            statusCode: {
                //The status for when action was successful
                200: function (data) {
                    if (data.url) {
                        window.location = data.url;
                    } else {
                        alert('مشکلی پیش آمده است. مجددا سعی کنید.');
                    }
                },
                //The status for when the user is not authorized for making the request
                403: function (response) {
                    alert('درخواست شما غیرمجاز می باشد');
                },
                404: function (response) {
                    //
                },
                //The status for when form data is not valid
                422: function (response) {
                    alert('اطلاعات وارد شده اشتباه می باشد');
                },
                //The status for when there is error php code
                500: function (response) {
                    alert('خطای کد');
                },
                //The status for when there is error php code
                503: function (response) {
                    alert('خطای غیر منتظره');
                }
            },
        });
    });
});
