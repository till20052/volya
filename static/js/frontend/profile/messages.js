$(document).ready(function()
{
	var __step = 1,
		__section = $("body>section"),
		__convUiFrame = $("div[ui-frame='conversations']", __section),
		__convTable = $("table", __convUiFrame),
		__messUiFrame = $("div[ui-frame='messages']", __section),
		__messTable = $("table#list", __messUiFrame);
	
	var __messageCreatorUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='profile.messages.message_creator']"));
		var __data = eval($("script#data", __uiWindow.element).text());
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function()
		{
			var __userId = __receivers.value();
			
			if( ! (__userId.length > 0))
				return false;
			
			__uiForm.data({
				user_id: __receivers.value()
			});
		}).afterSend(function()
		{
			__uiWindow.close();
		});
		
		var __receivers = $("select[ui='receivers']", __uiForm.element).kendoMultiSelect(__data["select[ui='receivers']"]).data("kendoMultiSelect");
		
		$("a#send_message", __uiForm.element).click(function()
		{
			__uiForm.send();
		});
		
		return __uiWindow;
	})();
	
	$("a#create_message", __section).click(function()
	{
		__messageCreatorUiWindow.open();
	});
	
	var __dataBound = (function()
	{
		$("tr:not([data-init='1'])", __convTable).click(function()
		{
			$(__convUiFrame).hide();
			$(__messUiFrame).show()
			.attr("data-uid", $(this).attr("data-uid"));
			
			$("h3#subject", __messUiFrame).html($(this).attr("data-subject"));
			
			$(">tbody", __messTable).empty();
			
			$.get("/profile/messages/get_conversation", {
				id: $(this).attr("data-id")
			}, function(html){
				$(">tbody", __messTable).append(html);
				$(">div.content", __messUiFrame)
				.scrollTop(
					$(">div.content", __messUiFrame).prop("scrollHeight")
				);
			});
		}).attr("data-init", 1);
	});
	
	$("a#show_more", __convUiFrame).click(function()
	{
		$.get("/profile/messages", {
			step: __step
		}, function(html)
		{
			$(">tbody", __convTable).append(html);
			
			if($(">tbody>tr", __convTable).length == $(__table).attr("data-count"))
				$("a#show_more", __section).remove();
			
			__dataBound();
			
			__step++;
		});
	});
	
	$("a#back", __messUiFrame).click(function()
	{
		$(__messUiFrame).hide();
		$(__convUiFrame).show();
	});
	
	var __shiftKey = false;
	$("textarea#message", __messUiFrame).keydown(function(e){
		__shiftKey = e.shiftKey;
	}).keyup(function(e)
	{
		if(e.which != 13 || __shiftKey != false)
			return;
		
		$("input#send_message", __messUiFrame).click();
	});
	
	$("input#send_message", __messUiFrame).click(function()
	{
		var __message = $("textarea#message", __messUiFrame).val().replace(/\n/g, "<br />");
		$.post("/profile/messages/j_add_message", {
			user_id: $(__messUiFrame).attr("data-uid").split(","),
			message: __message
		}, function(response)
		{
			if( ! response.success)
				return;
			
			$("textarea#message", __messUiFrame).val("");
			
			$.get("/profile/messages/get_message", {
				id: response.message_id
			}, function(row)
			{
				$(">tbody", __messTable).append(row);
				$(">div.content", __messUiFrame)
				.scrollTop(
					$(">div.content", __messUiFrame).prop("scrollHeight")
				);
			});
		}, "json");
	});
	
	__dataBound();
	
});