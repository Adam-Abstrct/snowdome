$(function(){

	sizeGraph();


	$( window , document ).resize(function(){
		console.log('resized');
		sizeGraph();

	});


	function sizeGraph()
	{
		var documentHeight = $('body').height();
		var chart = $('.chart__main');
		var footer = $('footer').height();
		var header = $('header').height();
		var moduleHeight = $('.module__co2').height();
		var totalElements = header + footer + moduleHeight;
		var chartHeight = documentHeight - totalElements

		chart.css('min-height' , chartHeight+'px');
	}

	

});