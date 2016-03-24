$(document).ready(function()
{
	var __section = $("body>section");
	var DATA = eval($(">script#data", __section).text());
	
	var __formUiWindow = (function()
	{
		var __uiWindow = (new Window($("div[ui-window='admin.trainings.form']"))).afterOpen(function()
		{
			$($("input[ui-lang]", __uiWindow.element)[0]).click();
		});
		var __uiWindowData = eval($("script#data", __uiWindow.element).text());
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function()
		{
			__uiForm.data({
				id: $(__uiWindow.element).attr("data-id"),
				rid: __regionUiSelect.value(),
				aid: __areaUiSelect.value(),
				cid: __cityUiSelect.value(),
				title: __i18n.value("title"),
				address: $("input[ui='address']").val(),
				meta_title: __i18n.value("meta_title"),
				meta_description: __i18n.value("meta_description"),
				meta_keywords: __i18n.value("meta_keywords"),
				happen_at: kendo.toString(__happenAtUiInput.value(), "yyyy-MM-dd HH:mm:ss"),
				text: __i18n.value("text"),
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
			fields: ["title", "meta_title", "meta_description", "meta_keywords", "text"]
		});
		__uiWindow.ui("i18n", __i18n);
		
		$("input[ui-lang]", __uiWindow.element).click(function()
		{
			var __lang = $(this).attr("ui-lang");
			$("input[ui='title']", __uiWindow.element).val(__i18n.value("title."+__lang));
			$("textarea[ui='meta_title']", __uiWindow.element).val(__i18n.value("meta_title."+__lang));
			$("textarea[ui='meta_description']", __uiWindow.element).val(__i18n.value("meta_description."+__lang));
			$("textarea[ui='meta_keywords']", __uiWindow.element).val(__i18n.value("meta_keywords."+__lang));
			__textUiTextarea.setData(__i18n.value("text."+__lang));
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
		
		$("input[ui='title']", __uiWindow.element).change(function(){
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("title."+__lang, $(this).val());
		});
		
		$("textarea[ui='meta_title']", __uiWindow.element).change(function(){
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("meta_title."+__lang, $(this).val());
		});
		
		$("textarea[ui='meta_description']", __uiWindow.element).change(function(){
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("meta_description."+__lang, $(this).val());
		});
		
		$("textarea[ui='meta_keywords']", __uiWindow.element).change(function(){
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("meta_keywords."+__lang, $(this).val());
		});
		
		var __happenAtUiInput = $("input[ui='happen_at']", __uiWindow.element).kendoDateTimePicker({
			format: "dd MMMM yyyy hh:mm"
		}).data("kendoDateTimePicker");
		__uiWindow.ui("happenAtUiInput", __happenAtUiInput);
		
		var __textUiTextarea = $("textarea[ui='text']", __uiWindow.element).ckeditor({
			height: "400px",
			filebrowserBrowseUrl : "/ckfinder/ckfinder.html"
		}).editor;
		__textUiTextarea.on("change", function(e)
		{
			var __lang = $("input[ui-lang]:checked", __uiWindow.element).attr("ui-lang");
			__i18n.value("text."+__lang, e.editor.getData());
		});
		
		var __regionUiSelect = $("select[data-ui='rid']", __uiWindow.element).kendoDropDownList({
			change: function(event){
				var __regionId = event.sender.value();
				
				__areaUiSelect.dataSource.data([{id: 0, title: "&mdash;"}]);
				__areaUiSelect.value(0);
				
				if( ! (__regionId > 0))
				{
					$("tr[data-ui='area']").hide();
					$("tr[data-ui='area']").prev("tr").hide();
					__areaUiSelect.options.change({sender: __areaUiSelect});
					return;
				}
				
				$("tr[data-ui='area']").prev("tr").show();
				$("tr[data-ui='area']").show();
				$("div[data-uiCover='area']").show();
				
				$.post("/api/geo/j_get_areas", {
					country_id: 2,
					region_id: __regionId
				}, function(response){
					if( ! response.success)
						return;
					
					$("div[data-uiCover='area']").hide();
					
					__areaUiSelect.dataSource.data(([{id: 0, title: "&mdash;"}]).concat(response.areas));
					
					if($(__areaUiSelect.element).attr("data-value") > 0)
					{
						__areaUiSelect.value($(__areaUiSelect.element).attr("data-value"));
						__areaUiSelect.options.change({sender: __areaUiSelect});
						$(__areaUiSelect.element).attr("data-value", 0);
					}
				}, "json");
			}
		}).data("kendoDropDownList");
		__uiWindow.ui("regionUiSelect", __regionUiSelect);
		
		var __areaUiSelect = (function(){
			var __element = $("select[data-ui='area']", __formUiWindow),
				__valueTemplate = kendo.template($(">script#valueTemplate", __element).text()),
				__template = kendo.template($(">script#template", __element).text());
			
			return $(__element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "title",
				dataSource: {
					data: [{id: 0, title: "&mdash;"}],
					scheme: {model: {id: "id"}}
				},
				valueTemplate: __valueTemplate,
				template: __template,
				change: function(event){
					var __areaId = event.sender.value();
					
					__cityUiSelect.dataSource.data([{id: 0, title: "&mdash;"}]);
					__cityUiSelect.value(0);
					
					if( ! (__areaId > 0))
					{
						$("tr[data-ui='city']").hide();
						$("tr[data-ui='city']").prev("tr").hide();
						return;
					}
					
					$("tr[data-ui='city']").show();
					$("tr[data-ui='city']").prev("tr").show();
					$("div[data-uiCover='city']").show();
					
					var __item = event.sender.dataSource.get(__areaId),
						__data = ({
							country_id: 2,
							region_id: __regionUiSelect.value()
						}),
						__url = "/api/geo/j_get_cities";
					
					if(typeof __item.area != "undefined")
						__data["area"] = __item.area;
					else
					{
						__url = "/api/geo/j_get_city";
						__data = ({
							city_id: __item.id
						});
					}
					
					$.post(__url, __data, function(response){
						if( ! response.success)
							return;
						
						$("div[data-uiCover='city']").hide();
						
						var __data = (typeof response.cities != "undefined")
							? ([{id: 0, title: "-"}]).concat(response.cities)
							: [response.city];
						
						__cityUiSelect.dataSource.data(__data);
						
						if($(__cityUiSelect.element).attr("data-value") > 0)
						{
							__cityUiSelect.value($(__cityUiSelect.element).attr("data-value"));
							$(__cityUiSelect.element).attr("data-value", 0);
						}
					}, "json");
				}
			}).data("kendoDropDownList");
		}());
		__uiWindow.ui("areaUiSelect", __areaUiSelect);
		
		var __cityUiSelect = (function(){
			var __element = $("select[data-ui='city']", __formUiWindow),
				__template = kendo.template($(">script#template", __element).text());
			
			return $(__element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "title",
				dataSource: {
					data: [{id: 0, title: "&mdash;"}],
					scheme: {model: {id: "id"}}
				},
				template: __template
			}).data("kendoDropDownList");
		}());
		__uiWindow.ui("cityUiSelect", __cityUiSelect);
		
		__regionUiSelect.options.change({sender: __regionUiSelect});
		
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
	
	var __membersFormUiWindow = (function()
	{
		var __uiWindow = (new Window($("div[ui-window='admin.trainings.members']")));
		
		return __uiWindow;
	})();
	
	var __confirmUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.trainings.confirm']"));
		
		$("a#yes", __uiWindow.element).click(function()
		{
			$.post("/admin/trainings/j_delete", {
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
	
	var __memberConfirmUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.trainings.member_confirm']"));
		
		$("a#yes", __uiWindow.element).click(function()
		{
			$.post("/admin/trainings/j_validate", {
				member_id: $(__uiWindow.element).attr("data-id"),
				member_status: -1
			}, function(response)
			{
				if( ! response.success)
					return;
				
				var __dataItem = __listUiTable.dataSource.get(response.item.id);

				for(var __field in response.item)
					__dataItem.set(__field, response.item[__field]);
			}, "json");
			
			__membersListUiTable.dataSource.remove(__membersListUiTable.dataSource.get($(__uiWindow.element).attr("data-id")));
			__uiWindow.close();
			__membersFormUiWindow.open();
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
		
		__formUiWindow.ui("regionUiSelect").value(0);
		__formUiWindow.ui("areaUiSelect").value(0);
		__formUiWindow.ui("cityUiSelect").value(0);
		
		__formUiWindow.ui("regionUiSelect").options.change({sender: __formUiWindow.ui("regionUiSelect")});
		
		$("input[ui='address']", __formUiWindow.element).val("");
		
		$("div#preview", __formUiWindow.element).css({
			backgroundImage: "url('/img/no_image.jpg')"
		}).attr("data-image", "");
		
		__formUiWindow.ui("i18n").clearValues();
		__formUiWindow.ui("happenAtUiInput").value(new Date());
		
		__formUiWindow.open();
	});
	
	var __listUiTable = (function()
	{
		$("table#list>script", __section).each(function(i)
		{
			DATA["table#list"].columns[i]["template"] = kendo.template($(this).html());
		}).remove();
		
		$("table#list", __section).kendoGrid($.extend(DATA["table#list"], {
			dataBound: (function(e)
			{
				$("input[type='checkbox'][ui='publicate']", e.sender.tbody).click(function()
				{
					$.post("/admin/trainings/j_publicate", {
						id: $(this).attr("data-id"),
						state: $(this).attr("checked") == "checked" ? 1 : 0
					});
				});
				
				$("a[ui='edit']", e.sender.tbody).click(function()
				{
					$.post("/admin/trainings/j_get_item", {
						id: $(this).attr("data-id")
					}, function(response)
					{
						if( ! response.success)
							return;
						
						$(__formUiWindow.element).attr("data-id", response.item.id);
						
						$("div#preview", __formUiWindow.element).css({
							backgroundImage: "url('"+(response.item.image != "" ? "/s/img/thumb/ag/"+response.item.image : "/img/no_image.jpg")+"')"
						}).attr("data-image", response.item.image);
						
						__formUiWindow.ui("regionUiSelect").value(response.item.region_id);
						$(__formUiWindow.ui("areaUiSelect").element).attr("data-value", response.item.area_id);
						$(__formUiWindow.ui("cityUiSelect").element).attr("data-value", response.item.city_id);
						
						__formUiWindow.ui("regionUiSelect").options.change({sender: __formUiWindow.ui("regionUiSelect")});
						
						$("input[ui='address']", __formUiWindow.element).val(response.item.address);
						
						__formUiWindow.ui("i18n").value("title", response.item.title);
						__formUiWindow.ui("i18n").value("meta_title", response.item.meta_title);
						__formUiWindow.ui("i18n").value("meta_description", response.item.meta_description);
						__formUiWindow.ui("i18n").value("meta_keywords", response.item.meta_keywords);
						__formUiWindow.ui("i18n").value("text", response.item.text);
						__formUiWindow.ui("happenAtUiInput").value(kendo.parseDate(response.item.happen_at));
						
						__formUiWindow.open();
					}, "json");
				});
				
				$("a[ui='remove']", e.sender.tbody).click(function()
				{
					$(__confirmUiWindow.element).attr("data-id", $(this).attr("data-id"));
					__confirmUiWindow.open();
				});
				
				$("a[ui='members']", e.sender.tbody).click(function()
				{
					$.post("/admin/trainings/j_get_members",{
						training_id: $(this).attr("data-id"),
						status: $(this).attr("data-status")
					}, function(response){
						if( ! response.success)
							return;
						
						$(__membersListUiTable.element).attr("data-status", response.status);
						
						__membersListUiTable.dataSource.data(response.list);
						__membersFormUiWindow.open();
					}, "json");
				});
			})
		}));
		
		return $("table#list", __section).data("kendoGrid");
	})();
	
	var __membersListUiTable = (function()
	{
		$("table#members_list>script", __membersFormUiWindow.element).each(function(i)
		{
			DATA["table#members_list"].columns[i]["template"] = kendo.template($(this).html());
		}).remove();
		
		$("table#members_list", __membersFormUiWindow.element).kendoGrid($.extend(DATA["table#members_list"], {
			dataBound: (function(e)
			{
				$("a[ui='remove']", e.sender.tbody).click(function()
				{
					$(__memberConfirmUiWindow.element).attr("data-id", $(this).attr("data-id"));
					__memberConfirmUiWindow.open();
				});
				
				$("a[ui='connect']", e.sender.tbody).click(function()
				{
					$(__memberConfirmUiWindow.element).attr("data-id", $(this).attr("data-id"));
					
					$.post("/admin/trainings/j_validate", {
						member_id: $(this).attr("data-id"),
						member_status: 1
					}, function(response)
					{
						if( ! response.success)
							return;
						
						console.log(__membersListUiTable.dataSource.get($(__memberConfirmUiWindow.element).attr("data-id")), $(__memberConfirmUiWindow.element).attr("data-id"));
						
						if($(__membersListUiTable.element).attr("data-status") == 0)
							__membersListUiTable.dataSource.remove(__membersListUiTable.dataSource.get($(__memberConfirmUiWindow.element).attr("data-id")));
						
						var __dataItem = __listUiTable.dataSource.get(response.item.id);
						for(var __field in response.item)
							__dataItem.set(__field, response.item[__field]);
					}, "json");
				});
			})
		}));
		
		return $("table#members_list", __membersFormUiWindow.element).data("kendoGrid");
	})();
});