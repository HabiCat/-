// JavaScript Document

/*jobs*/
$(function(){
	/* nav */
	$(".nav-main li").hover(function(){
		$(this).addClass("hover")
			   .siblings().removeClass("hover");
	},function(){
		$(this).removeClass("hover");
	})
	
	/*job content*/
	$(".select-tab li").click(function(){
		var $index = $(this).index();
		$(this).addClass("selected").siblings().removeClass("selected");
		$(".job-content").eq($index).show().siblings(".job-content").hide();
	})
	
	/*similar jobs*/
	$(".similar-tab li").click(function(){
		var $index = $(this).index();
		$(this).addClass("selected").siblings().removeClass("selected");
		$(".recommend").eq($index).show().siblings(".recommend").hide();
	})
	
	/*focus*/
	$("#focus .shadow").css("opacity","0.5");
})
