$(document).ready(function(){
	
	var __section = $("body>section>div.section");
	
	$("a[data-action='expand']", __section).click(function(){
		
		var __super = $($(this).parents("div[data-uiBox='row']").eq(0));
		var __candidateUiBox = $(">div[data-uiBox='candidate']", __super);
		
		if($(this).attr("data-state") != 1)
			$(__candidateUiBox).show();
		else
			$(__candidateUiBox).hide();
		
		$(this).attr("data-state", $(this).attr("data-state") != 1 ? 1 : 0);
	});
	
});