$(function(){
	// alert('分辨率'+window.screen.width+'x'+window.screen.height+'浏览器宽高'+$(window).width()+'x'+$(window).height()+'窗口宽高'+window.innerWidth+'x'+window.innerHeight)
	AjaxPostForGetData("./public.html",null,function(response){
		$("#public").html(response);
		checkScrolltop();
	});
	var mousewheel = document.all?"mousewheel":"DOMMouseScroll"; 
	$(window).scroll(function(event){
		checkScrolltop();
	});

	var href = window.location.href,currentTab;
	if(href.indexOf("#")>1){
		currentTab = window.location.href.split("#")[1];
		setCurrentTab(currentTab);
	}
	$("body").on("click",".child-nav a",function(){
		setCurrentTab($(this).attr("href").split("#")[1]);
	});
	$(".section-pageNav li").click(function(){
		setCurrentTab($(this).attr("data-content"));
	});

	var currentPage = $("body").attr("class");
	$(".m-header li").each(function(){
		if($(this).attr("id")==currentPage){
			$(this).addClass("current");
		}
	});

	$(".footer-wechat").hover(function(){
		$("img.wechatCode").removeClass("hidden");
	},function(){
		$("img.wechatCode").addClass("hidden");
	});

	$("body").on("click",".toTop",function(){
		$("body").animate({scrollTop:0},800);
	});
	$("body").on("mouseover",".footer-wechat",function(){
		$(".wechatCode").removeClass("hidden");
	});
	$("body").on("mouseout",".footer-wechat",function(){
		$(".wechatCode").addClass("hidden");
	});
	$("body").on("mouseover",".head-nav>li",function(){
		if($(this).find(".child-nav").length){
			$(this).find(".child-nav").height($(this).find(".child-nav").find("li").size()*44+30);
		}
	})
	$("body").on("mouseout",".head-nav>li",function(){
		$(this).find(".child-nav").height("0");
	});
});


function checkScrolltop(){
	var scrollTop = $(window).scrollTop();
	if($("body").hasClass("white")||scrollTop>150){
		$(".m-header").addClass("white");
	}else{
		$(".m-header").removeClass("white");
	}
}

function setCurrentTab(currentTab){
	if(currentTab){
		$(".section-pageNav li").removeClass("current");
		$(".section-pageNav li."+currentTab).addClass("current")
		var currentIndex = $(".section-pageNav li."+currentTab).attr("data-type");
		$(".section-content .info-content").addClass("hidden");
		$(".section-content .info-content[data-type="+currentIndex+"]").removeClass("hidden");
		$(window).scrollTop(0);
	}
}
function AjaxPostForGetData(postAction,beforeFunction,updateFunction) {
    $.ajax({
        type: "GET",
        url: postAction,
        dataType: "html",
        beforeSend: function() {
        	if(beforeFunction != null)
        		beforeFunction();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        	if(XMLHttpRequest.status=='504'){
            	alert("网关超时，请重试！");
        	}else{
            	alert('系统异常['+textStatus+'—'+XMLHttpRequest.status+']');
            	console.log(XMLHttpRequest);
            	console.log(errorThrown);
        	}
        },
        success: function(response) {
        		updateFunction(response);
        }
    });
}