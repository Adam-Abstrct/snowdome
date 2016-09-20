$(function(){

	var tip = $('.tips__container').children();
	var index = 0;
	tipFunction()


	function tipFunction(){
		tip.filter('.active').fadeOut(500).removeClass('active');
		tip.eq(index).fadeIn(500).addClass('active');
		index = (index + 1) % tip.length;
		setTimeout(tipFunction, 8000);
	}



});