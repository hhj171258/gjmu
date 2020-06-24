// JavaScript Document
/* nav */
function nav(){
	$(".depth1 li").mouseover(function(){
		$(this).find(".depth2").stop().slideDown(180);
	})
	$(".depth1 li").mouseleave(function(){
		$(this).find(".depth2").stop().slideUp(180);
	})
}
nav();

/* history */
function history(n){
	$(".history li:not(.btn)").removeClass("on");
	$(".history li:not(.btn)").eq(n).addClass("on");
	$(".history li.btn").removeClass("on");
	$(".history li.btn").eq(n).addClass("on");
}


/* quick */
function quick(){

	var scrollTop = $(window).scrollTop();
	var visualHeight = $(".mainvisual").outerHeight() - 10;
	var historyHeight = visualHeight + $(".history").outerHeight() - 10;
	var beautyHeight = historyHeight + $(".beauty").outerHeight() - 390;
	var newsHeight = beautyHeight + $(".news").outerHeight() + 400;
	
	if(scrollTop <= visualHeight){
		$(".quick li").removeClass("on");
		$(".quick li").eq(0).addClass("on");
	} else if(scrollTop <= historyHeight){
		$(".quick li").removeClass("on");
		$(".quick li").eq(1).addClass("on");
	} else if(scrollTop <= beautyHeight){
		$(".quick li").removeClass("on");
		$(".quick li").eq(2).addClass("on");
	} else if(scrollTop <= newsHeight){
		$(".quick li").removeClass("on");
		$(".quick li").eq(3).addClass("on");
	}
}

$(window).scroll(function(){quick();});

function quickAnimate(e){
	var offset = $(e).offset();
    $('html, body').animate({scrollTop : offset.top}, 700);
}