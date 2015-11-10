$(document).ready(function()
{
	
	var __section = $("body>section");
	var __data = eval($("script#data", __section).text());
	
	var __formUiWindow = (function()
	{
		var __uiWindow = (new Window($("div[ui-window='admin.email_templates.form']"))).afterOpen(function()
		{
			$($("input[ui-lang]", __uiWindow.element)[0]).click();
		});
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function()
		{
			__uiForm.data({
				id: $(__uiWindow.element).attr("data-id"),
				from: __i18n.value("from"),
				subject: __i18n.value("subject"),
				message: __i18n.value("message")
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
			fields: ["from", "subject", "message"]
		});
		__uiWindow.ui("i18n", __i18n);
		
		$("input[ui-lang]", __uiWindow.element).click(function()
		{
			var __lang = $(this).attr("ui-lang");
			$("input[ui='from']", __uiWindow.element).val(__i18n.value("from."+__lang));
			$("input[ui='subject']", __uiWindow.element).val(__i18n.value("subject."+__lang));
			__textUiTextarea.setData(__i18n.value("message."+__lang));
		});
		
		$("input[ui='from']", __uiWindow.element).change(function(){
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("from."+__lang, $(this).val());
		});
		
		$("input[ui='subject']", __uiWindow.element).change(function(){
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("subject."+__lang, $(this).val());
		});
		
		var __textUiTextarea = $("textarea[ui='message']", __uiWindow.element).ckeditor({
			height: "400px",
			filebrowserBrowseUrl : "/ckfinder/ckfinder.html"
		}).editor;
		__textUiTextarea.on("change", function(e)
		{
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("message."+__lang, e.editor.getData());
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
	
	$("a#add", __section).click(function()
	{
		$(__formUiWindow.element).attr("data-id", 0);
		
		$("input#symlink", __formUiWindow.element).val("");
		__formUiWindow.ui("i18n").clearValues();
		
		__formUiWindow.open();
	});
	
	var __confirmUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.pages.confirm']"));
		
		$("a#yes", __uiWindow.element).click(function()
		{
			$.post("/admin/email_templates/j_delete", {
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
	
	var __listUiTable = (function()
	{
		$("table#list>script", __section).each(function(i)
		{
			__data["table#list"].columns[i]["template"] = kendo.template($(this).html());
		}).remove();
		
		$("table#list", __section).kendoGrid($.extend({}, __data["table#list"], {
			dataBound: (function(e)
			{
				$("a[ui='edit']", e.sender.tbody).click(function()
				{
					$.post("/admin/email_templates/j_get_item", {
						id: $(this).attr("data-id")
					}, function(response)
					{
						if( ! response.success)
							return;
						
						$(__formUiWindow.element).attr("data-id", response.item.id);
						
						$("input#symlink", __formUiWindow.element).val(response.item.symlink);
						__formUiWindow.ui("i18n").value("from", response.item.from);
						__formUiWindow.ui("i18n").value("subject", response.item.subject);
						__formUiWindow.ui("i18n").value("message", response.item.message);
						
						__formUiWindow.open();
					}, "json");
				});
				
				$("a[ui='remove']", e.sender.tbody).click(function()
				{
					$(__confirmUiWindow.element).attr("data-id", $(this).attr("data-id"));
					__confirmUiWindow.open();
				});
			})
		}));
		
		return $("table#list", __section).data("kendoGrid");
	})();
	
});