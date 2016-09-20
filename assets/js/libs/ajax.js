$(function(){

	var jsonResponse;
    var df;
    var dt;

	$.ajax({
		url: "../../app/Src/AjaxResponse.php",
		type: "POST",
		success: function(data) {

			jsonResponse = JSON.parse(data)

            df = jsonResponse.df;
            dt = jsonResponse.dt;
			
			outputChartData(jsonResponse.chart);
			outputC02Data(jsonResponse.C02);
			outputTreeData(jsonResponse.trees);
			outputHousesData(jsonResponse.houses);
			outputGreenData(jsonResponse.green);

		},
		error: function(data) {

		},
		complete: function() {
 		
		} 
	});


	function outputChartData(data)
	{
		$('.chart__main').highcharts({
		chart: {
			backgroundColor: '#f9f9f9'
		},	
        title: {
            text: 'Energy Output - 28.06.16 > 05.07.16',
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
                format: '{value} KWh',
                style: {
                    color: '#00afeb'
                }
            },
            title: {
                text: 'Generation',
                align: 'high',
        		offset: 0,
        		rotation: 0,
        		y: -10,
                style: {
                    color: '#00afeb'

                }
            }
        }, { // Secondary yAxis
            title: {
                text: 'Consumption',
                align: 'high',
        		offset: 0,
        		rotation: 0,
        		y: -10,
                style: {
                    color: '#004a8d'

                }
            },
            labels: {
                format: '{value} KWh',
                style: {
                    color: '#004a8d'
                }
            },
            opposite: true
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
                valueSuffix: ' KWh'
            }

        }, {
            name: 'Consumption',
            type: 'spline',
            data: [45.1, 65.9, 45.5, 51.5, 47.2, 144.5, 75.2, 122.5, 100.3, 80.3, 44.9, 44.6],
            yAxis: 1,
            tooltip: {
                valueSuffix: ' KWh'
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
    
        for (var i = 0; i < consumption.length ; i++) { //loops 6 times
            temp2.push(consumption[i]);
        }

        chart.series[0].setData(temp);
        chart.series[1].setData(temp2);
        chart.xAxis[0].update({categories: data.legend });
        chart.setTitle({text: 'Energy Output- '+ df + ' > '+ dt})


	}
	

	function outputC02Data(data)
	{
	
		var $c02 = $('#cO2 p');
		$c02.html(data+' C\'s');

	}

	function outputTreeData(data)
	{
		var $tree = $('#trees p');
		$tree.html(data);
	}

	function outputHousesData(data)
	{
		var $houses = $('#houses p');
		$houses.html(data);
	}

	function outputGreenData(data)
	{
		var $green = $('#green');
		$green.html(data+' MWh');
	}

})