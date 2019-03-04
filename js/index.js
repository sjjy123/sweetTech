
$(function(){
	$(".part3 .col-xs-1-5").mouseover(function(){
		$(this).parent("ul").css("padding-left","0");
		$(this).siblings("li").removeClass("current");
		$(this).addClass("current");
	});
	$(".part3 .row").mouseleave(function(){
		$(this).css("padding-left","12.5%");
		$(this).find(".col-xs-1-5").removeClass("current");
	});
});