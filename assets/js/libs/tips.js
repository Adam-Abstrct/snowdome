$(function(){

	var tip = $('.tips__container').children();
	var index = 0;
	tipFunction()


	function tipFunction(){
		tip.filter('.active').removeClass('active');
		tip.eq(index).addClass('active');
		index = (index + 1) % tip.length;
		setTimeout(tipFunction, 8000);
	}



});