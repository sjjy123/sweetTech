
$(function(){
    $(".section-content .part5 li").click(function(){
        var currentType = $(this).attr("data-type");
        $(".section-pageNav li[data-type="+currentType+"]").click();
        $(window).scrollTop(0);
    });
});