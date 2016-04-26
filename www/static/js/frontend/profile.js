var AppProfile = new Object();

$(document).ready(function()
{
	
	var __profileUiMenu = $("body>header ul[data-ui-menu='profile']");
	
	$(">li", __profileUiMenu).hover(function()
	{
		if($(">div[data-ui-popup]", this).length > 0)
			$(">div[data-ui-popup]", this).show();
	}, function()
	{
		if($(">div[data-ui-popup]", this).length > 0)
			$(">div[data-ui-popup]", this).hide();
	});
	
	$("a#sign_out", __profileUiMenu).click(function()
	{
		$.post("http://volya.ua/profile/sign/j_out", function()
		{
			window.location.href = "/";
		}, "json");
	});
	
});