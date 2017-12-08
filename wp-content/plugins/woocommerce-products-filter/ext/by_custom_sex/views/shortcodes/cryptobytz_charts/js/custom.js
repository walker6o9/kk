(function ($){
 // $(document).ready(function (){
    //alert('yea');

   // alert(unixtime);

    $.getJSON('https://api.coindesk.com/v1/bpi/historical/close.json?start=2010-09-01&end=2017-11-01&bpi',function (data){

      var bpi = data.bpi;
      var bitdata = [];
      var timedata = [];

      $.each(bpi, function(key,value){
        bitdata.push(value);
        timedata.push(key);
      });

     // var start = timedata[0];
     // var start_time = Date.UTC(start);
     //  dot =  Date.UTC(2010, 09, 01)
      // alert(dot);

      Highcharts.stockChart('container', {

        rangeSelector: {
            selected: 1
        },

        title: {
            text: 'Bitcoin Stock Price'
        },

        series: [{
            name: 'Price (USD)',
            data: bitdata,
            pointStart: Date.UTC(2010, 08, 01),
          //  pointEnd: Date.UTC(2017, 08, 01),
            pointInterval: 24 * 3600 * 1000, // one day
            tooltip: {
                valueDecimals: 2
            },
            fillColor: {
                linearGradient: {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                stops: [
                    [0, Highcharts.getOptions().colors[0]],
                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                ]
            },
            threshold: null
        }]

    });


  //    console.log(start);
    });

//     $.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=aapl-c.json&callback=?', function (data) {
//     // Create the chart
//     Highcharts.stockChart('container', {
//
//         rangeSelector: {
//             selected: 1
//         },
//
//         title: {
//             text: 'AAPL Stock Price'
//         },
//
//         series: [{
//             name: 'AAPL',
//             data: data,
//             tooltip: {
//                 valueDecimals: 2
//             }
//         }]
//     });
//});
//  });
})(jQuery);
