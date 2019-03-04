
$(function(){
	var currentTab = $(".col-xs-12 .description");
	if(currentTab.siblings("p").height()>0) {
    	setHeight();
	}else{
		setTimeout(setHeight,1000);
	}

    $(window).resize(function(){
    	setHeight();
    });

	$(".section-pageNav .info-list-list li").click(function(){
		var currentContent = $(this).text();
		var currentType = $(this).attr("data-type");
		if(currentType=='3'){
			$(this).closest(".info-list-list").siblings(".currentName").text("闂ㄧ鑰冨嫟锛堝吋瀹圭増锛�");
		}else{
			$(this).closest(".info-list-list").siblings(".currentName").text(currentContent);
		}
		$(this).closest(".info-list-list").closest(".info-list").attr("data-type",currentType);
	});

    $(".section-content .part5 li").click(function(){
        var currentType = $(this).attr("data-type");
        $(".section-pageNav li[data-type="+currentType+"]").click();
        $(window).scrollTop(0);
    });
});
function setHeight(){
	$(".col-xs-12 .description").height($(".col-xs-12 .description").siblings("p").height()-40);
}