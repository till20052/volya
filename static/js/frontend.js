$(document).ready(function(){
	
	var __header = $("body>header");
	var __section = $("body>section");
	var __footer = $("body>footer");
	
	$(window).resize(function(){
		var __minHeight = $(window).height();
		__minHeight -= $(__header).height();
		__minHeight -= $(__footer).height();
		$(__section).css("minHeight", __minHeight+"px");
	});
	
	(function()
	{
		setInterval(function()
		{
			if($("div[ui='textbox']").attr("data-init") != 1)
			{
				$("div[ui='textbox']").click(function()
				{
					$("input", this).focus();
				}).attr("data-init", 1);
			}
			
			if($("div[ui='textbox'] input").attr("data-init") != 1)
			{
				$("div[ui='textbox'] input").focus(function()
				{
					$($(this).parents("div").eq(1)).css("border-color", "#F29200");
				}).blur(function()
				{
					$($(this).parents("div").eq(1)).css("border-color", "");
				}).attr("data-init", 1);
			}
		}, 500);
	})();
	
	(function(){
		
		var __mainUiMenu = $("ul[data-ui-menu='main']", __header);
		
		$(">li", __mainUiMenu).hover(function(){
			if($(">ul", this).length != 1)
				return;
			
			$(">ul", this).show();
		}, function(){
			$(">ul", this).hide();
		});
		
	})();
	
});