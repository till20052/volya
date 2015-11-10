$(document).ready(function(){
	
	var __section = $("body>section>div.section"),
		__toolbarUiBox = $(">div>div[data-uiBox='toolbar']", __section);
	
	var __formUiWindow = (function(element){
		var __uiWindow = new Window(element);

		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function(){
			var __data = {
				id: $(__uiWindow.element).attr("data-id"),
				geo: __regionUiSelect.value(),
				members: __membersUiSelect.value()
			};

			__uiForm.data(__data);
		}).afterSend(function(response){
			if( ! response.success)
				return;

			if( ! (__uiForm.data("id") > 0))
				__listUiTable.dataSource.insert(0, response.item);
			else {
				var __item = __listUiTable.dataSource.get(__uiForm.data("id"));
				for(var __field in response.item)
					__item.set(__field, response.item[__field]);
			}

			__uiWindow.close();
		});

		$("a[data-action='save']", __uiWindow.element).click(function(){
			__uiForm.send();
		});

		$("a[data-action='cancel']", __uiWindow.element).click(function(){
			__uiWindow.close();
		});

		var __regionUiSelect = (function(element){
			return $(element).kendoDropDownList().data("kendoDropDownList");
		})($("select[data-ui='geo']", __uiWindow.element));

		var __membersUiSelect = (function(element){
			var __inputTemplate = kendo.template($(">script#input_template", $($(element).parents("td").eq(0))).html());

			return $(element).kendoMultiSelect({
				placeholder: "Почніть вводити email",
				dataValueField: "id",
				dataTextField: "name",
				filter: "contains",
				minLength: 3,
				autoBind: false,
				template: $(">script#input_template", $($(element).parents("td").eq(0))).html(),
				dataSource: {
					serverFiltering: true,
					transport: {
						read: (function(options){
							$.ajax({
								url: "/api/users/find?email="+options.data.filter.filters[0].value + "&geo=" + __regionUiSelect.value(),
								dataType: "jsonp",
								complete: (function(response){
									options.success($.map(eval("("+response.responseText+")").list, function(item){
										item.template = __inputTemplate(item);
										return item;
									}));
								})
							});
						})
					}
				}
			}).data("kendoMultiSelect");
		})($("select[data-uiAutoComplete='q']", __uiWindow.element));

		return $.extend(__uiWindow, {
			getItemAndOpenWindow: (function(id){
				if(id > 0)
					$.post("/register/admin/krk_manager/j_get_group", {
						id: id
					}, function(response){
						if( ! response.success)
							return;

						var __item = response.item;

						$(__uiWindow.element).attr("data-id", __item.id);
						__regionUiSelect.value(__item.geo);
						__regionUiSelect.enable(false);

						__membersUiSelect.dataSource.data(__item.members);

						var __membersIds = [];
						__item.members.forEach(function(member){
							__membersIds.push(member.id);
						});

						__membersUiSelect.value(__membersIds);

						__uiWindow.open();
					}, "json");

				$(__uiWindow.element).removeAttr("data-id");
				__regionUiSelect.value(0);
				__regionUiSelect.enable(true);

				__membersUiSelect.value([]);
			}),
		});

	}($("div[ui-window='register.admin.krk_manager.form']")));

	$("a[data-action='create']", __section).click(function(){
		__formUiWindow.getItemAndOpenWindow();
		__formUiWindow.open();
	});

	var __listUiTable = (function(element){
		var __data = eval($(">script#data", element).text()),
			__templates = $(">script[type='text/x-kendo-template']", element);
		
		__templates.each(function(i){
			if(typeof __data.columns[i] == "undefined")
				return;
			__data.columns[i]["template"] = kendo.template($(this).html());
		});
		
		var __uiTable = $(element).kendoGrid(__data).data("kendoGrid");
		
		$(__uiTable.tbody).click(function(event){
			var __a = $(event.srcElement);
			if($(__a).prop("tagName") != "A")
				__a = $($(__a).parents("a").eq(0));
			
			switch($(__a).attr("data-action")){
				case "edit":
					__formUiWindow.getItemAndOpenWindow($(__a).attr("data-id"));
					break;
			}
		});
		
		if( ! ($(">tr", __uiTable.tbody).length > 0))
			$(__uiTable.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));
		
		return __uiTable;
	}($("table[data-ui='list']", __section)));

});