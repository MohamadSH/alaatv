// Create the chart
Highcharts.mapChart('mapContainer', {

    chart: {
        backgroundColor: '#eff0f5',
        height: '100%'
    },

    title: {
        text: 'گزارش فروش محصولات'
    },

    credits: {
        enabled: true,
        href: '{{ asset('/') }}',
        text: 'آموزش مجازی آلاء'
    },

    subtitle: {
        text: 'تعداد فروش در استان های ایران'
    },

    tooltip: {
        useHTML: true,
        formatter: function() {
            let province = this.key;
            let value = this.point.value;
            return '<div>استان: '+province+'</div>'+'<div>'+value+'</div>';
        }
    },

    mapNavigation: {
        enabled: true,
        buttonOptions: {
            verticalAlign: 'bottom'
        }
    },

    colorAxis: {
        min: 1,
        minColor: '#f2f3f8',
        maxColor: '#ff9a17',
        // startOnTick: false,
        // endOnTick: false
    },

    series: [{

        mapData: mapGeoJSON,
        color: '#E0E0E0',
        nullColor: 'white',
        // enableMouseTracking: false,

        data: data,
        name: 'Random data',
        states: {
            hover: {
                color: '#BADA55'
            }
        },
        dataLabels: {
            enabled: true,
            format: '{point.name}'
        }
    }]
});

// Highcharts.chart('chartcontainer1', {
//
//     title: {
//         text: undefined
//     },
//
//     credits: {
//         enabled: true,
//         href: '{{ asset('/') }}',
//         text: 'آموزش مجازی آلاء'
//     },
//
//     chart: {
//         zoomType: 'x'
//     },
//
//     tooltip: {
//         useHTML: true,
//         formatter: function() {
//             let unixTimestamp = this.x;
//             let persianDateValue = persianDate.unix(unixTimestamp).format("YY/M/D H:m:s");
//             let value = this.y;
//             return '<div>تعداد فروش: '+value+'</div>'+'<div>'+persianDateValue+'</div>';
//         }
//     },
//
//     xAxis: {
//         type: 'datetime',
//         labels: {
//             formatter: function() {
//                 let unixTimestamp = this.value;
//                 // return persianDate.unix(unixTimestamp).format("YYY/M/D");
//                 return persianDate.unix(unixTimestamp).format("YY/M/D H:m:s");
//             }
//         }
//     },
//
//     yAxis: {
//         title: {
//             text: 'تعداد فروش'
//         }
//     },
//     legend: {
//         layout: 'vertical',
//         align: 'right',
//         verticalAlign: 'middle'
//     },
//
//     lang: {
//         months: ['فروردين', 'ارديبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
//         shortMonths: ['فروردين', 'ارديبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
//         weekdays: ["یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج‌شنبه", "جمعه", "شنبه"]
//     },
//
//     plotOptions: {
//         series: {
//             label: {
//                 connectorAllowed: false
//             },
//         }
//     },
//
//     series: [
//         {
//             name: 'محصول شماره یک',
//             data: [{
//                 x: Math.round((new Date('2013/09/04 15:34:00')).getTime()/1000),
//                 y: 3
//             },
//                 {
//                     x: Math.round((new Date('2013/09/05 15:34:00')).getTime()/1000),
//                     y: 5
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/06 15:34:00')).getTime()/1000),
//                     y: 2
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/07 15:34:00')).getTime()/1000),
//                     y: 6
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/08 15:34:00')).getTime()/1000),
//                     y: 2
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/09 15:34:00')).getTime()/1000),
//                     y: 8
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/10 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/11 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/12 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/13 15:34:00')).getTime()/1000),
//                     y: 3
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/14 15:34:00')).getTime()/1000),
//                     y: 8
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/15 15:34:00')).getTime()/1000),
//                     y: 15
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/16 15:34:00')).getTime()/1000),
//                     y: 13
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/17 15:34:00')).getTime()/1000),
//                     y: 11
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/18 15:34:00')).getTime()/1000),
//                     y: 14
//                 }]
//         },
//         {
//             name: 'محصول شماره دو',
//             data: [{
//                 x: Math.round((new Date('2013/09/01 15:34:00')).getTime()/1000),
//                 y: 4
//             },
//                 {
//                     x: Math.round((new Date('2013/09/03 15:34:00')).getTime()/1000),
//                     y: 2
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/07 15:34:00')).getTime()/1000),
//                     y: 7
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/09 15:34:00')).getTime()/1000),
//                     y: 1
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/10 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/04 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/05 15:34:00')).getTime()/1000),
//                     y: 5
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/06 15:34:00')).getTime()/1000),
//                     y: 2
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/07 15:34:00')).getTime()/1000),
//                     y: 6
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/08 15:34:00')).getTime()/1000),
//                     y: 2
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/09 15:34:00')).getTime()/1000),
//                     y: 8
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/10 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/11 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/12 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/13 15:34:00')).getTime()/1000),
//                     y: 3
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/14 15:34:00')).getTime()/1000),
//                     y: 8
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/15 15:34:00')).getTime()/1000),
//                     y: 15
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/16 15:34:00')).getTime()/1000),
//                     y: 13
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/17 15:34:00')).getTime()/1000),
//                     y: 11
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/18 15:34:00')).getTime()/1000),
//                     y: 14
//                 }
//             ]
//         }
//     ],
//
//     responsive: {
//         rules: [{
//             condition: {
//                 maxWidth: 500
//             },
//             chartOptions: {
//                 legend: {
//                     layout: 'horizontal',
//                     align: 'center',
//                     verticalAlign: 'bottom'
//                 }
//             }
//         }]
//     }
//
// });
//
// Highcharts.chart('chartcontainer2', {
//
//     title: {
//         text: undefined
//     },
//
//     credits: {
//         enabled: true,
//         href: '{{ asset('/') }}',
//         text: 'آموزش مجازی آلاء'
//     },
//
//     chart: {
//         zoomType: 'x'
//     },
//
//     tooltip: {
//         useHTML: true,
//         formatter: function() {
//             let unixTimestamp = this.x;
//             let persianDateValue = persianDate.unix(unixTimestamp).format("YY/M/D H:m:s");
//             let value = this.y;
//             return '<div>تعداد فروش: '+value+'</div>'+'<div>'+persianDateValue+'</div>';
//         }
//     },
//
//     xAxis: {
//         type: 'datetime',
//         labels: {
//             formatter: function() {
//                 let unixTimestamp = this.value;
//                 // return persianDate.unix(unixTimestamp).format("YYY/M/D");
//                 return persianDate.unix(unixTimestamp).format("YY/M/D H:m:s");
//             }
//         }
//     },
//
//     yAxis: {
//         title: {
//             text: 'مبلغ فروش'
//         }
//     },
//     legend: {
//         layout: 'vertical',
//         align: 'right',
//         verticalAlign: 'middle'
//     },
//
//     lang: {
//         months: ['فروردين', 'ارديبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
//         shortMonths: ['فروردين', 'ارديبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
//         weekdays: ["یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج‌شنبه", "جمعه", "شنبه"]
//     },
//
//     plotOptions: {
//         series: {
//             label: {
//                 connectorAllowed: false
//             },
//         }
//     },
//
//     series: [
//         {
//             name: 'محصول شماره یک',
//             data: [{
//                 x: Math.round((new Date('2013/09/04 15:34:00')).getTime()/1000),
//                 y: 3000
//             },
//                 {
//                     x: Math.round((new Date('2013/09/05 15:34:00')).getTime()/1000),
//                     y: 5000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/06 15:34:00')).getTime()/1000),
//                     y: 2000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/07 15:34:00')).getTime()/1000),
//                     y: 6000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/08 15:34:00')).getTime()/1000),
//                     y: 2000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/09 15:34:00')).getTime()/1000),
//                     y: 8000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/10 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/11 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/12 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/13 15:34:00')).getTime()/1000),
//                     y: 3000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/14 15:34:00')).getTime()/1000),
//                     y: 8000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/15 15:34:00')).getTime()/1000),
//                     y: 15000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/16 15:34:00')).getTime()/1000),
//                     y: 13000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/17 15:34:00')).getTime()/1000),
//                     y: 11000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/18 15:34:00')).getTime()/1000),
//                     y: 14000
//                 }]
//         },
//         {
//             name: 'محصول شماره دو',
//             data: [{
//                 x: Math.round((new Date('2013/09/01 15:34:00')).getTime()/1000),
//                 y: 40000
//             },
//                 {
//                     x: Math.round((new Date('2013/09/03 15:34:00')).getTime()/1000),
//                     y: 20000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/07 15:34:00')).getTime()/1000),
//                     y: 70000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/09 15:34:00')).getTime()/1000),
//                     y: 10000
//                 },
//                 {
//                     x: Math.round((new Date('2013/09/10 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/04 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/05 15:34:00')).getTime()/1000),
//                     y: 50000
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/06 15:34:00')).getTime()/1000),
//                     y: 20000
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/07 15:34:00')).getTime()/1000),
//                     y: 60000
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/08 15:34:00')).getTime()/1000),
//                     y: 20000
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/09 15:34:00')).getTime()/1000),
//                     y: 80000
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/10 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/11 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/12 15:34:00')).getTime()/1000),
//                     y: null
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/13 15:34:00')).getTime()/1000),
//                     y: 30000
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/14 15:34:00')).getTime()/1000),
//                     y: 80000
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/15 15:34:00')).getTime()/1000),
//                     y: 150000
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/16 15:34:00')).getTime()/1000),
//                     y: 130000
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/17 15:34:00')).getTime()/1000),
//                     y: 110000
//                 },
//                 {
//                     x: Math.round((new Date('2013/10/18 15:34:00')).getTime()/1000),
//                     y: 140000
//                 }
//             ]
//         }
//     ],
//
//     responsive: {
//         rules: [{
//             condition: {
//                 maxWidth: 500
//             },
//             chartOptions: {
//                 legend: {
//                     layout: 'horizontal',
//                     align: 'center',
//                     verticalAlign: 'bottom'
//                 }
//             }
//         }]
//     }
//
// });
//
// Highcharts.chart('chartcontainer3', {
//
//     title: {
//         text: undefined
//     },
//
//     credits: {
//         enabled: true,
//         href: '{{ asset('/') }}',
//         text: 'آموزش مجازی آلاء'
//     },
//
//     chart: {
//         type: 'column',
//         zoomType: 'x'
//     },
//
//     xAxis: {
//         type: 'category'
//     },
//     yAxis: {
//         title: {
//             text: 'تعداد استفاده'
//         }
//
//     },
//     legend: {
//         enabled: false
//     },
//     plotOptions: {
//         series: {
//             borderWidth: 0,
//             dataLabels: {
//                 enabled: true,
//                 format: '{point.y:.1f}'
//             }
//         }
//     },
//
//     tooltip: {
//         useHTML: true,
//         formatter: function() {
//             return '<span style="font-size:11px">'+this.series.name+'</span><br><span style="color:'+this.point.color+'">'+this.point.name+'</span>: <b>'+this.point.y+'</b>';
//         }
//     },
//
//     series: [
//         {
//             name: "کد تخفیف",
//             colorByPoint: true,
//             data: [
//                 {
//                     name: "کد شماره یک",
//                     y: 62.74,
//                     drilldown: "p1"
//                 },
//                 {
//                     name: "کد شماره دو",
//                     y: 10.57,
//                     drilldown: "p2"
//                 },
//                 {
//                     name: "کد شماره سه",
//                     y: 7.23,
//                     drilldown: "کد شماره سه"
//                 },
//                 {
//                     name: "کد شماره چهار",
//                     y: 5.58,
//                     drilldown: "کد شماره چهار"
//                 },
//                 {
//                     name: "کد شماره پنج",
//                     y: 4.02,
//                     drilldown: "کد شماره پنج"
//                 },
//                 {
//                     name: "کد شماره شش",
//                     y: 1.92,
//                     drilldown: "کد شماره شش"
//                 },
//                 {
//                     name: "Other",
//                     y: 7.62,
//                     drilldown: null
//                 }
//             ]
//         }
//     ],
//     drilldown: {
//         series: [
//             {
//                 name: "کد شماره یک",
//                 id: "p1",
//                 data: [
//                     [
//                         "محصول شماره 1",
//                         0.1
//                     ],
//                     [
//                         "محصول شماره 2",
//                         1.3
//                     ],
//                     [
//                         "محصول شماره 3",
//                         53.02
//                     ],
//                     [
//                         "محصول شماره 4",
//                         1.4
//                     ],
//                     [
//                         "محصول شماره 5",
//                         0.88
//                     ],
//                     [
//                         "محصول شماره 6",
//                         0.56
//                     ],
//                     [
//                         "محصول شماره 7",
//                         0.45
//                     ],
//                     [
//                         "محصول شماره 8",
//                         0.49
//                     ],
//                     [
//                         "محصول شماره 9",
//                         0.32
//                     ],
//                     [
//                         "محصول شماره 10",
//                         0.29
//                     ],
//                     [
//                         "محصول شماره 11",
//                         0.79
//                     ],
//                     [
//                         "محصول شماره 12",
//                         0.18
//                     ],
//                     [
//                         "محصول شماره 13",
//                         0.13
//                     ],
//                     [
//                         "محصول شماره 14",
//                         2.16
//                     ],
//                     [
//                         "محصول شماره 15",
//                         0.13
//                     ],
//                     [
//                         "محصول شماره 16",
//                         0.11
//                     ],
//                     [
//                         "محصول شماره 17",
//                         0.17
//                     ],
//                     [
//                         "محصول شماره 18",
//                         0.26
//                     ]
//                 ]
//             },
//             {
//                 name: "کد شماره دو",
//                 id: "p2",
//                 data: [
//                     [
//                         "محصول شماره یک",
//                         1.02
//                     ],
//                     [
//                         "محصول شماره دو",
//                         7.36
//                     ],
//                     [
//                         "محصول شماره سه",
//                         0.35
//                     ],
//                     [
//                         "محصول شماره چهار",
//                         0.11
//                     ],
//                     [
//                         "محصول شماره پنج",
//                         0.1
//                     ],
//                     [
//                         "محصول شماره شش",
//                         0.95
//                     ],
//                     [
//                         "محصول شماره هفت",
//                         0.15
//                     ],
//                     [
//                         "محصول شماره هشت",
//                         0.1
//                     ],
//                     [
//                         "محصول شماره نه",
//                         0.31
//                     ],
//                     [
//                         "محصول شماره ده",
//                         0.12
//                     ]
//                 ]
//             },
//             {
//                 name: "کد شماره سه",
//                 id: "کد شماره سه",
//                 data: [
//                     [
//                         "محصول شماره یک",
//                         6.2
//                     ],
//                     [
//                         "محصول شماره دو",
//                         0.29
//                     ],
//                     [
//                         "محصول شماره سه",
//                         0.27
//                     ],
//                     [
//                         "محصول شماره چهار",
//                         0.47
//                     ]
//                 ]
//             },
//             {
//                 name: "کد شماره چهار",
//                 id: "کد شماره چهار",
//                 data: [
//                     [
//                         "محصول شماره یک",
//                         3.39
//                     ],
//                     [
//                         "محصول شماره دو",
//                         0.96
//                     ],
//                     [
//                         "محصول شماره سه",
//                         0.36
//                     ],
//                     [
//                         "محصول شماره چهار",
//                         0.54
//                     ],
//                     [
//                         "محصول شماره پنج",
//                         0.13
//                     ],
//                     [
//                         "محصول شماره شش",
//                         0.2
//                     ]
//                 ]
//             },
//             {
//                 name: "کد شماره پنج",
//                 id: "کد شماره پنج",
//                 data: [
//                     [
//                         "محصول شماره یک",
//                         2.6
//                     ],
//                     [
//                         "محصول شماره دو",
//                         0.92
//                     ],
//                     [
//                         "محصول شماره سه",
//                         0.4
//                     ],
//                     [
//                         "محصول شماره چهار",
//                         0.1
//                     ]
//                 ]
//             },
//             {
//                 name: "کد شماره شش",
//                 id: "کد شماره شش",
//                 data: [
//                     [
//                         "محصول شماره یک",
//                         0.96
//                     ],
//                     [
//                         "محصول شماره دو",
//                         0.82
//                     ],
//                     [
//                         "محصول شماره سه",
//                         0.14
//                     ]
//                 ]
//             }
//         ]
//     }
// });
//





//
// Highcharts.chart('container', {
//     chart: {
//         type: 'networkgraph',
//         height: '900px'
//     },
//     title: {
//         text: 'لیست محصولات شما'
//     },
//     subtitle: {
//         text: 'لیست درختی محصولات شما'
//     },
//     plotOptions: {
//         networkgraph: {
//             keys: ['from', 'to'],
//             layoutAlgorithm: {
//                 enableSimulation: true,
//                 friction: -0.9
//             }
//         }
//     },
//     series: [{
//         dataLabels: {
//             enabled: true,
//             linkFormat: ''
//         },
//         data: [
//
//             ['محصول مادر', 'محصول شماره دو'],
//             ['محصول مادر', 'محصول شماره سه'],
//             ['محصول مادر', 'محصول شماره چهار'],
//             ['محصول شماره یک', 'محصول شماره پنج'],
//             ['محصول شماره یک', 'محصول شماره پنج'],
//             ['محصول شماره پنج', 'محصول شماره شش'],
//             ['محصول شماره پنج', 'محصول شماره هفت'],
//             ['محصول شماره یک', 'محصول شماره هشت'],
//             ['محصول شماره یک', 'محصول شماره نه'],
//             ['محصول شماره یک', 'محصول شماره ده'],
//             ['محصول شماره یک', 'محصول شماره یازده'],
//             ['محصول شماره یک', 'محصول شماره دوازده'],
//             ['محصول شماره یک', 'محصول شماره سیزده'],
//             ['محصول شماره دو', 'محصول شماره چهارده'],
//             ['محصول شماره دو', 'محصول شماره پانزده'],
//             ['محصول شماره دو', 'محصول شماره شانزده'],
//             ['محصول شماره دو', 'محصول شماره هفده'],
//             ['محصول شماره سه', 'محصول شماره هجده'],
//             ['محصول شماره چهار', 'محصول شماره نوزده'],
//             ['محصول شماره چهار', 'محصول شماره بیست'],
//             ['محصول شماره چهار', 'محصول شماره بیست و یک'],
//             ['محصول شماره چهار', 'محصول شماره بیست و دو']
//         ]
//     }]
// });
//

$(document).ready(function () {
    let highchartsCredits = $('.highcharts-credits').html();
    $('.highcharts-credits').html(highchartsCredits.replace('©', '').trim());
});














// /**
//  * Start up jquery
//  */
// jQuery(document).ready(function () {
//     /*
//      validUntil
//      */
//     CustomInit.persianDatepicker('#couponValidUntil', '#couponValidUntilAlt', true);
// });
//
// $('#couponValidSinceEnable').change(function () {
//     if ($(this).prop('checked') === true) {
//         $('#couponValidSince').attr('disabled', false);
//         $('#couponValidSinceTime').attr('disabled', false);
//     } else {
//         $('#couponValidSince').attr('disabled', true);
//         $('#couponValidSinceTime').attr('disabled', true);
//     }
// });
//
// $('#couponValidUntilEnable').change(function () {
//     if ($(this).prop('checked') === true) {
//         $('#couponValidUntil').attr('disabled', false);
//         $('#couponValidUntilTime').attr('disabled', false);
//     } else {
//         $('#couponValidUntil').attr('disabled', true);
//         $('#couponValidUntilTime').attr('disabled', true);
//     }
// });