// JavaScript
$(".lnb ol").hide();
$(".lnb_inner > li > a").click(function(){
	if($(this).next("ol").is(":visible")){
		$(this).next("ol").hide();
	} else {
		if($(".lnb ol").is(":visible")){
			$(".lnb ol").hide();
		}
		$(this).next("ol").show();
	}
})