var AppLogin = new Object();

$(document).ready(function()
{
	var __loadedContent = false;
	var __loginUiPopup = $("body>header div[data-ui-popup='login']");
	
	$("body").click(function()
	{
		$(__loginUiPopup).hide();
	});
	
	$(__loginUiPopup).click(function(e)
	{
		e.stopPropagation();
	});
	
	AppLogin["open"] = (function()
	{
		$(__loginUiPopup).show();
		
		if( ! __loadedContent)
		{
			$.get("http://" + window.location.host + "/profile/sign/get_html/login", function(html)
			{
				$(">div", __loginUiPopup).html(html);
				
				$("input[type='text'],input[type='password']", __loginUiPopup).keyup(function(e)
				{
					if(e.which != 13)
						return;
					$("a#sign_in", __loginUiPopup).click();
				});
				
				$("input#login", __loginUiPopup).focus();
				
				$("a#sign_in", __loginUiPopup).click(function()
				{
					$.post("http://" + window.location.host + "/profile/sign/j_in", {
						login: $("input#login", __loginUiPopup).val(),
						password: $("input#password", __loginUiPopup).val(),
					}, function(response)
					{
						if(response.success)
						{
							window.location.reload();
							return;
						}

						$("div[data-ui='textbox']", __loginUiPopup).css("borderColor", "red");
						setTimeout(function()
						{
							$("div[data-ui='textbox']", __loginUiPopup).css("borderColor", "");
						}, 1000);
					}, "json");
				});
				
				__loadedContent = true;
			});
		}
	});
	
});
