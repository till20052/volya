$(document).ready(function()
{
	var __section = $("body>section");
	
	var __avatarUploaderUiWindow = (function()
	{
		var __uiWindow = (new Window($("div[ui-window='profile.avatar_uploader']"))).beforeOpen(function()
		{
			$("li", __fileUiInput.wrapper).each(function()
			{
				$("span.k-delete", this).click();
			});
		});
		
		var __fileUiInput = $("input#file", __uiWindow.element).kendoUpload({
			multiple: false,
			async: {
				saveUrl: "/s/img/j_save",
				removeUrl: "/nan",
				autoUpload: true
			},
			success: (function(e)
			{
				if(e.operation == "remove")
					return;
				
				var __file = eval("("+e.XMLHttpRequest.response+")").files[0];
				
				if( ! __file ){
					alert("Помилка при завантаженні скана. Даний формат не підтримуеться.");
					return;
				}
				
				$("div#avatar", __section).css("backgroundImage", "url('/s/img/thumb/aa/"+__file+"')");
				
				$.post("/profile/j_set_avatar", {
					id: $("div.avatarLoad", __section).attr("data-id"),
					avatar: __file
				}, "json");
				
				__uiWindow.close();
			}),
			complete: (function(e){
				$(">ul>li span.k-delete", e.sender.wrapper).click();
			})
		}).data("kendoUpload");
		__uiWindow.ui("fileUiInput", __fileUiInput);
		
		return __uiWindow;
	})();
	
	$("div.avatarLoad", __section).show()
	.css("opacity", 0)
	.hover(function()
	{
		$(this).css("opacity", 0)
		.animate({
			opacity: 1
		}, 100);
	}, function()
	{
		$(this).animate({
			opacity: 0
		}, 100);
	}).click(function()
	{
		__avatarUploaderUiWindow.open();
	});
	
});