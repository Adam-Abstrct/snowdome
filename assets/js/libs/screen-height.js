$(function(){

	$(window).on('load', function() { 
		setTimeout(function(){
			sizeGraph();
		} , 4000);
	});

	$( window , document ).resize(function(){
		sizeGraph();
	});

	

	

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

	return chartHeight

}