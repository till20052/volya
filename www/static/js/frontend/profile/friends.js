$(document).ready(function()
{
	var __step = 1;
	var __section = $("body>section");
	var __table = $("table.list", __section);
	
	var __messageSenderUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='profile.friends.message_sender']"));
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function()
		{
			__uiForm.data({
				user_id: $("input#receiver", __uiForm.element).attr("data-id")
			});
		}).afterSend(function()
		{
			__uiWindow.close();
		});
		
		$("a#send_message", __uiForm.element).click(function()
		{
			__uiForm.send();
		});
		
		return __uiWindow;
	})();
	
	var __dataBound = (function()
	{
		$("tr:not([data-init='1'])", __table).click(function()
		{
			$("input[type='checkbox']", this).attr("checked", $("input[type='checkbox']", this).attr("checked") == "checked" ? false : true);
		}).attr("data-init", 1);
		
		$("input[type='checkbox']:not([data-init='1'])", __table).click(function(e)
		{
			e.stopPropagation();
		}).attr("data-init", 1);
		
		$("a[ui='send_message']:not([data-init='1'])", __table).click(function(e){
			$("input#receiver", __messageSenderUiWindow.element).attr({
				"data-id": $(this).attr("data-id")
			}).val($(this).attr("data-name"));
			
			$("input#subject", __messageSenderUiWindow.element).val("");
			
			$("textarea#message", __messageSenderUiWindow.element).val("");
			
			__messageSenderUiWindow.open();
			
			e.stopPropagation();
		}).attr("data-init", 1);
		
		$("a[ui='remove']:not([data-init='1'])", __table).click(function(e)
		{
			if(confirm("Ви дійсно бажаєте видалити зі свого кола?"))
			{
				var __a = $(this);
				$.post("/profile/friends/j_unsubscribe", {
					id: $(__a).attr("data-id")
				}, function(response)
				{
					if( ! response.success)
						return;

					$($(__a).parents("tr").eq(0)).remove();
				}, "json");
			}

			e.stopPropagation();
		}).attr("data-init", 1);
	});
	__dataBound();
	
	$("a#show_more", __section).click(function()
	{
		$.get("/profile/friends", {
			step: __step
		}, function(html)
		{
			$(">tbody", __table).append(html);
			
			if($(">tbody>tr", __table).length == $(__table).attr("data-count"))
				$("a#show_more", __section).remove();
			
			__dataBound();
			
			__step++;
		});
	});
	
});