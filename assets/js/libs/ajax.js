

$(function(){

	var jsonResponse;
    var df;
    var dt;

	$.ajax({
		url: "app/Src/AjaxResponse.php",
		type: "POST",
		success: function(data) {

			jsonResponse = JSON.parse(data)

            df = jsonResponse.df;
            dt = jsonResponse.dt;	

            console.log(jsonResponse);		

		},
		error: function(data) {

		},
		complete: function() {
 		    outputChartData(jsonResponse.chart);
            outputC02Data(jsonResponse.C02);
            outputCarData(jsonResponse.cars);
            outputHousesData(jsonResponse.houses);
            outputGreenData(jsonResponse.green);
		} 
	});


	function outputChartData(data)
	{
       var cH = sizeGraph();
       var test = $('.chart__main');
       test.css('min-height' , cH+'px')

		$('.chart__main').highcharts({
		chart: {
			backgroundColor: '#f9f9f9',
            style:{
             'height' :  cH+'px'   
            }
		},	
        title: {
            text: 'Weekly Solar Generation',
            useHTML: true,
            style: {
            	'background-color': '#00afeb',
            	color: '#F0F0F0',
            	'font-size': '11px',
            	'padding': '5px',
            	'border-radius': '2px'
            },
            x: -20 //center
        },
        xAxis: {
            categories: []
        },
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value} kWh',
                style: {
                    color: '#00afeb'
                }
            },
            title: {
                text: null,
                align: 'high',
        		offset: 0,
        		rotation: 0,
        		y: -10,
                style: {
                    color: '#00afeb'

                }
            }
        }],
        tooltip: {
            valueSuffix: 'KWh'
        },
        legend: {
          	enabled: false
        },
       series: [{
            name: 'Generation',
            type: 'spline',
            yAxis: 0,
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
            tooltip: {
                valueSuffix: ' kWh'
            }
        }]
        });

        var generated = data.generated;
        var chart = $('.chart__main').highcharts();
        var temp = new Array();
        var consumption = data.consumption;
        var temp2 = new Array();

        for (var i = 0; i < generated.length ; i++) { //loops 6 times
            temp.push(generated[i]);
        }
    

        chart.series[0].setData(temp);        
        chart.xAxis[0].update({categories: data.legend });
    

	}
	

	function outputC02Data(data)
	{
		var $c02 = $('#cO2 p');
		$c02.html(data+' <span style="font-size:14px;" class="weight--normal"> tonnes</span>');

	}

	function outputCarData(data)
	{
		var $cars = $('#cars p');
		$cars.html(data+' <span style="font-size:14px;" class="weight--normal"></span>');
	}

	function outputHousesData(data)
	{
		var $houses = $('#houses p');
		$houses.html(data+' <span style="font-size:14px;" class="weight--normal"></span>');
	}

	function outputGreenData(data)
	{
		var $green = $('#green');
		$green.html(data+' MWh');
	}

})