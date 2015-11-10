$(document).ready(function()
{
	var __section = $("body>section");
	var __data = eval($(">script#data", __section).text());
	
	var __formUiWindow = (function()
	{
		var __uiWindow = (new Window($("div[ui-window='admin.team.form']"))).afterOpen(function()
		{
			$($("input[ui-lang]", __uiWindow.element)[0]).click();
		});
		var __uiWindowData = eval($("script#data", __uiWindow.element).text());
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function()
		{
			__uiForm.data({
				id: $(__uiWindow.element).attr("data-id"),
				name: __i18n.value("name"),
				job: __i18n.value("job"),
				slogan: __i18n.value("slogan"),
				links: $("textarea[ui='links']").val(),
				bio: __i18n.value("bio"),
				age: kendo.toString(__ageUiInput.value(), "yyyy-MM-dd"),
				photo: $("div#preview", __formUiWindow.element).attr("data-image")
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
			fields: ["name", "job", "slogan", "bio"]
		});
		__uiWindow.ui("i18n", __i18n);
		
		$("input[ui-lang]", __uiWindow.element).click(function()
		{
			var __lang = $(this).attr("ui-lang");
			$("input[ui='name']", __uiWindow.element).val(__i18n.value("name."+__lang));
			$("input[ui='job']", __uiWindow.element).val(__i18n.value("job."+__lang));
			$("input[ui='slogan']", __uiWindow.element).val(__i18n.value("slogan."+__lang));
			__bioUiTextarea.setData(__i18n.value("bio."+__lang));
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
		
		$("input[ui='name']", __uiWindow.element).change(function(){
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("name."+__lang, $(this).val());
		});
		
		$("input[ui='job']", __uiWindow.element).change(function(){
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("job."+__lang, $(this).val());
		});
		
		var __ageUiInput = $("input[ui='age']", __uiWindow.element).kendoDatePicker({
			format: "dd MMMM yyyy"
		}).data("kendoDatePicker");
		__uiWindow.ui("ageUiInput", __ageUiInput);
		
		$("input[ui='slogan']", __uiWindow.element).change(function(){
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("slogan."+__lang, $(this).val());
		});
		
		var __bioUiTextarea = $("textarea[ui='bio']", __uiWindow.element).ckeditor({
			height: "300px",
			filebrowserBrowseUrl : "/ckfinder/ckfinder.html"
		}).editor;
		__bioUiTextarea.on("change", function(e)
		{
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("bio."+__lang, e.editor.getData());
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
		var __uiWindow = new Window($("div[ui-window='admin.team.confirm']"));
		
		$("a#yes", __uiWindow.element).click(function()
		{
			$.post("/admin/team/j_delete", {
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
						backgroundImage: "url('/s/img/thumb/ag/"+__file+"')"
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
		
		$("div#preview", __formUiWindow.element).css({
			backgroundImage: "url('/img/no_image.jpg')"
		}).attr("data-image", "");
		
		__formUiWindow.ui("i18n").clearValues();
		$("textarea[ui='links']").val("");
		__formUiWindow.ui("ageUiInput").value(new Date());
		
		__formUiWindow.open();
	});
	
	var __listUiTable = (function()
	{
		$("table#list>script", __section).each(function(i)
		{
			__data["table#list"].columns[i]["template"] = kendo.template($(this).html());
		}).remove();
		
		$("table#list", __section).kendoGrid($.extend(__data["table#list"], {
			dataBound: (function(e)
			{
				$(e.sender.tbody).sortable({
					axis: "y",
					start: function(event, ui){
						$(">tr[data-uid!='"+$(ui.item).attr("data-uid")+"']", e.sender.tbody).animate({
							opacity: .5
						}, 50);
						
						$(ui.item).css({
							display: "table",
							width: "958px",
							backgroundColor: "white"
						});
						
						$(ui.placeholder).height($(ui.item).height());
						
						for(var __i in e.sender.columns)
						{
							if(typeof e.sender.columns[__i].width == "undefined")
								continue;
							
							$(">td:nth("+__i+")", ui.helper).css("width", e.sender.columns[__i].width);
						}
					},
					stop: function(event, ui){
						$(ui.item).css({
							display: "table-row",
							width: ""
						});
						
						var __priority = [];
						$(">tr", e.sender.tbody).each(function(){
							__priority.push($("a[ui='edit']", this).attr("data-id"));
						});
						
						$.post("/admin/team/j_set_priority", {
							priority: __priority
						}, function(response){
							if( ! response.success)
								return;
							
							$(">tr", e.sender.tbody).animate({
								opacity: 1
							}, 50, function(){
								e.sender.dataSource.data(response.data);
							});
						}, "json");
					}
				});
				
				$("input[type='checkbox'][ui='publicate']", e.sender.tbody).click(function()
				{
					$.post("/admin/team/j_publicate", {
						id: $(this).attr("data-id"),
						state: $(this).attr("checked") == "checked" ? 1 : 0
					});
				});
				
				$("a[ui='edit']", e.sender.tbody).click(function()
				{
					$.post("/admin/team/j_get_item", {
						id: $(this).attr("data-id")
					}, function(response)
					{
						if( ! response.success)
							return;
						
						$(__formUiWindow.element).attr("data-id", response.item.id);
						
						$("div#preview", __formUiWindow.element).css({
							backgroundImage: "url('"+(response.item.photo != "" ? "/s/img/thumb/ag/"+response.item.photo : "/img/no_image.jpg")+"')"
						}).attr("data-image", response.item.photo);
						
						__formUiWindow.ui("i18n").value("name", response.item.name);
						__formUiWindow.ui("i18n").value("job", response.item.job);
						__formUiWindow.ui("i18n").value("slogan", response.item.slogan);
						$("textarea[ui='links']").val(response.item.links);
						__formUiWindow.ui("i18n").value("bio", response.item.bio);
						__formUiWindow.ui("ageUiInput").value(kendo.parseDate(response.item.age));
						
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