$(document).ready(function()
{
	var __section = $("body>section");
	var __data = eval($("script#data", __section).text());
	
	var __formUiWindow = (function()
	{
		var __uiWindow = (new Window($("div[ui-window='admin.slideshow.form']"))).afterOpen(function()
		{
			$($("input[ui-lang]", __uiWindow.element)[0]).click();
		});
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function()
		{
			__uiForm.data({
				id: $(__uiWindow.element).attr("data-id"),
				title: __i18n.value("title"),
				description: __i18n.value("description"),
				image: $("div#preview", __formUiWindow.element).attr("data-image")
			});
		}).afterSend(function(response)
		{
			if( ! response.success)
				return;
			
			if( ! (__uiForm.data("id") > 0))
				__listUiTable.dataSource.insert(0, response.item);
			else
			{
				var __dataItem = __listUiTable.dataSource.get(response.item.id);
				console.log(response.item, __dataItem);
				for(var __field in response.item)
					__dataItem.set(__field, response.item[__field]);
			}
			
			__uiWindow.close();
		});
		
		var __i18n = new i18n({
			languages: $.map($("input[ui-lang]", __uiWindow.element), function(item)
			{
				return $(item).attr("ui-lang");
			}),
			fields: ["title", "description"]
		});
		__uiWindow.ui("i18n", __i18n);
		
		$("input[ui-lang]", __uiWindow.element).click(function()
		{
			var __lang = $(this).attr("ui-lang");
			$("input[ui='title']", __uiWindow.element).val(__i18n.value("title."+__lang));
			$("textarea[ui='description']", __uiWindow.element).val(__i18n.value("description."+__lang));
		});
		
		$("input[ui='title']", __uiWindow.element).change(function(){
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("title."+__lang, $(this).val());
		});
		
		$("textarea[ui='description']", __uiWindow.element).change(function(){
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("description."+__lang, $(this).val());
		});
		
		$("input#upload_image", __uiWindow.element).click(function()
		{
			__imageUploaderUiWindow.open(function()
			{
				$("li", __imageUploaderUiWindow.ui("fileUiInput").wrapper).each(function()
				{
					$("span.k-delete", this).click();
				});
			});
		});
		
		$("a#save", __uiWindow.element).click(function()
		{
			__uiForm.send();
		});
		
		$("a#cancel", __uiWindow.element).click(function()
		{
			__uiWindow.close();
		});
		
		return __uiWindow;
	})();
	
	var __confirmUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.slideshow.confirm']"));
		
		$("a#yes", __uiWindow.element).click(function()
		{
			$.post("/admin/slideshow/j_delete", {
				id: $(__uiWindow.element).attr("data-id")
			}, function(response)
			{
				if( ! response.success)
					return;
				
				__listUiTable.dataSource.remove(__listUiTable.dataSource.get($(__uiWindow.element).attr("data-id")));
				
				__uiWindow.close();
			}, "json");
		});
		
		$("a#no", __uiWindow.element).click(function()
		{
			__uiWindow.close();
		});
		
		return __uiWindow;
	})();
	
	var __imageUploaderUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.image_uploader']"));
		
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
				
				__formUiWindow.open(function()
				{
					var __file = eval("("+e.XMLHttpRequest.response+")").files[0];
					$("div#preview", __formUiWindow.element).css({
						backgroundImage: "url('/s/img/thumb/al/"+__file+"')"
					}).attr("data-image", __file);
				});
			})
		}).data("kendoUpload");
		__uiWindow.ui("fileUiInput", __fileUiInput);
		
		$("a.closeButton", __uiWindow.element).click(function()
		{
			__formUiWindow.open();
		});
		
		return __uiWindow;
	})();
	
	$("a#add", __section).click(function()
	{
		$(__formUiWindow.element).attr("data-id", 0);
		
		$("input#href", __formUiWindow.element).val("");
		$("div#preview", __formUiWindow.element).css({
			backgroundImage: "url('/img/no_image.jpg')"
		}).attr("data-image", "");
		__formUiWindow.ui("i18n").clearValues();
		
		__formUiWindow.open();
	});
	
	var __listUiTable = (function()
	{
		$("table#list>script", __section).each(function(i)
		{
			__data["table#list"].columns[i]["template"] = kendo.template($(this).html());
		}).remove();
		
		$("table#list", __section).kendoGrid($.extend({}, __data["table#list"], {
			dataBound: (function(e)
			{
				$("input[type='checkbox'][ui='publicate']", e.sender.tbody).click(function()
				{
					$.post("/admin/slideshow/j_publicate", {
						id: $(this).attr("data-id"),
						state: $(this).attr("checked") == "checked" ? 1 : 0
					});
				});
				
				$("a[data-ui='edit']", e.sender.tbody).click(function()
				{
					$.post("/admin/slideshow/j_get_item", {
						id: $(this).attr("data-id")
					}, function(response)
					{
						if( ! response.success)
							return;
						
						$(__formUiWindow.element).attr("data-id", response.item.id);
						
						$("input#href", __formUiWindow.element).val(response.item.href);
						__formUiWindow.ui("i18n").value("title", response.item.title);
						__formUiWindow.ui("i18n").value("description", response.item.description);
						$("div#preview", __formUiWindow.element).css({
							backgroundImage: "url('"+(response.item.image != "" ? "/s/img/thumb/ag/"+response.item.image : "/img/no_image.jpg")+"')"
						}).attr("data-image", response.item.image);
						
						__formUiWindow.open();
					}, "json");
				});
				
				$("a[data-ui='remove']", e.sender.tbody).click(function()
				{
					$(__confirmUiWindow.element).attr("data-id", $(this).attr("data-id"));
					__confirmUiWindow.open();
				});
			})
		}));
		
		return $("table#list", __section).data("kendoGrid");
	})();
	
});