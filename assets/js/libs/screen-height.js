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
	var footer = $('footer').height()+parseInt($('footer').css("marginBottom"))+parseInt($('footer').css("marginTop"));
	var header = $('.logo__snowdome').height();
	var moduleHeight = $('.module__wrap').height()+parseInt($('.module__wrap').css('marginTop'));
	var totalElements = header + footer + moduleHeight;
	var chartHeight = documentHeight - totalElements

	return chartHeight

}