$(document).ready(function(){
	
	$("button.member-detail.expand").live("click", function(){
		
		$(this).parent("div").children(".bio").children(".full_bio").slideDown(500);
		$("span#ellipsis", $(this).parent("div")).hide();
		
		$(this).addClass("collaps").removeClass("expand");
		$(this).children("img").css("transform", "rotate(180deg)");
	});
	
	$("button.member-detail.collaps").live("click", function(){
		
		$(this).parent("div").children(".bio").children(".full_bio").slideUp("slow");
		$("span#ellipsis", $(this).parent("div")).show();
		
		$(this).addClass("expand").removeClass("collaps");
		$(this).children("img").css("transform", "rotate(0deg)");
	});
});