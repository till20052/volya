$(document).ready(function(){
	
	var __section = $("body>section>div.section"),
		__toolbarUiBox = $(">div>div[data-uiBox='toolbar']", __section);
	
	var __formUiWindow = (function(element){
		var __uiWindow = new Window(element),
			__uiFrames = (function(elements){
				var __o = new Object();
				$(elements).each(function(){
					__o[$(this).attr("data-uiFrame")] = $(this);
				});
				return __o;
			})($(">div>div>div[data-uiFrame]", __uiWindow.element));
		
		var __hideFrames = function(){
			for(var __key in __uiFrames){
				$(__uiFrames[__key]).hide();
			}
		};
		
		var __showFrame = function(key){
			__hideFrames();
			if(typeof __uiFrames[key] == "undefined")
				return;
			$(__uiFrames[key]).show();
			$("h2[data-id='title']", __uiWindow.element).html($(__uiFrames[key]).attr("data-title"));
			__uiWindow.checkPosition();
		};
		
		var __qUiAutoComplete = (function(element){
			var __inputTemplate = kendo.template($(">script#input_template", $($(element).parents("td").eq(0))).html()),
				__value;
			
			var __uiAutoComplete = $(element).kendoAutoComplete({
				dataTextField: "template",
				filter: "contains",
				minLength: 3,
				template: $(">script#template", $($(element).parents("td").eq(0))).html(),
				dataSource: ({
					serverFiltering: true,
					transport: ({
						read: (function(options){
							$.ajax({
								url: "/api/users/find?email="+options.data.filter.filters[0].value,
								dataType: "jsonp",
								complete: (function(response){
									options.success($.map(eval("("+response.responseText+")").list, function(item){
										item.template = __inputTemplate(item);
										return item;
									}));
								})
							});
						})
					})
				}),
				select: (function(e){
					__value = new Object({
						id: $(">table", e.item).attr("data-id"),
						avatar: $(">table", e.item).attr("data-avatar"),
						name: $(">table", e.item).attr("data-name")
					}); //
				})
			}).data("kendoAutoComplete");
			
			return {
				value: function(value){
					if(typeof value != "undefined"){
						__value = value;
						$(">input", __uiAutoComplete.wrapper).val("");
					}

					return __value;
				}
			};
		})($("input[data-uiAutoComplete='q']", __uiFrames.finder));
		
		$("a[data-action='next']", __uiFrames.finder).click(function(){
			__showFrame("access_level_editor");
			$(__uiWindow.element).attr("data-id", 0);
			$("div[data-uiBox='profile']", __uiFrames.access_level_editor).html(__profileTemplate(__qUiAutoComplete.value()));
			if(typeof __credentialLevelsUiSelect != "undefined")
				__credentialLevelsUiSelect.value(0);
			__regionsUiSelect.value(0);
		});

		var __profileTemplate = (function(element){
			return kendo.template($(element).html());
		})($(">script#profile_template", __uiFrames.access_level_editor));

		if($("select[data-ui='credential_levels']", __uiFrames.access_level_editor).length > 0){
			var __credentialLevelsUiSelect = $("select[data-ui='credential_levels']", __uiFrames.access_level_editor).kendoDropDownList({
				value: 0
			}).data("kendoDropDownList");
		}

		var __regionsUiSelect = $("select[data-ui='regions']", __uiFrames.access_level_editor).kendoMultiSelect({
			value: []
		}).data("kendoMultiSelect");

		//var __regionsUiSelect = $("select[data-ui='regions']", __uiFrames.access_level_editor).kendoDropDownList({
		//	value: 0
		//}).data("kendoDropDownList");

		$("a[data-action='save']", __uiFrames.access_level_editor).click(function(){
			var __data = {
				id: $(__uiWindow.element).attr("data-id"),
				user_id: $("div[data-uiBox='profile']>table", __uiFrames.access_level_editor).attr("data-id"),
				geo_koatuu_code: __regionsUiSelect.value()
			};

			if(typeof __credentialLevelsUiSelect != "undefined")
				__data["credential_level"] = __credentialLevelsUiSelect.value();

			$.post("/admin/register/j_settings_save_register_user_item", __data, function(response){
				if($(__uiWindow.element).attr("data-id") > 0){
					var __data = __listUiTable.dataSource.get($(__uiWindow.element).attr("data-id"));
					for(var __field in response.item)
						__data.set(__field, response.item[__field]);
				} else
					__listUiTable.dataSource.insert(0, response.item);
				__uiWindow.close();
			}, "json");
		});

		$("a[data-action='cancel']", __uiFrames.access_level_editor).click(function(){
			__uiWindow.close();
		});

		return $.extend(__uiWindow, {
			openFinder: function(){
				__uiWindow.open();
				__showFrame("finder");
				__qUiAutoComplete.value({});
			},
			openAccessLevelEditor: function(id){
				$.post("/admin/register/j_settings_get_register_user_item", {
					id: id
				}, function(response){
					if( ! response.success)
						return;
					__uiWindow.open();
					__showFrame("access_level_editor");
					$(__uiWindow.element).attr("data-id", response.item.id);
					response.item.user["name"] = response.item.user.first_name + " " + response.item.user.last_name;
					$("div[data-uiBox='profile']", __uiFrames.access_level_editor).html(__profileTemplate(response.item.user));
					if(typeof __credentialLevelsUiSelect != "undefined")
						__credentialLevelsUiSelect.value(response.item.credential_level_id);
					__regionsUiSelect.value(response.item.geo_koatuu_code);
				}, "json");
			}
		});
	})($("div[ui-window='admin.register.settings.form']"));

	var __confirmFormUiWindow = (function(element){
		var __uiWindow = new Window(element);

		$("a[data-action='submit']", __uiWindow.element).click(function(){
			$.post("/admin/register/j_settings_remove_register_user_item", {
				id: $(__uiWindow.element).attr("data-id")
			}, function(response){
				if( ! response.success)
					return;
				__listUiTable.dataSource.remove(__listUiTable.dataSource.get($(__uiWindow.element).attr("data-id")));
				__uiWindow.close();
			}, "json");
		});

		$("a[data-action='cancel']", __uiWindow.element).click(function(){
			__uiWindow.close();
		});

		return $.extend(__uiWindow, {
			confirm: function(id){
				$(__uiWindow.element).attr("data-id", id);
				__uiWindow.open();
			}
		});
	})($("div[ui-window='admin.register.settings.confirm_form']"));

	var __filter = (function(){
		return ({
			prepare: (function(){
				var __params = "?";

				if(__credentialLevelsUiSelect.value() != 0)
					__params += "cl="+__credentialLevelsUiSelect.value()+"&";

				if(__regionsUiSelect.value() != 0)
					__params += "r="+__regionsUiSelect.value()+"&";

				return __params.substr(0, __params.length - 1);
			}),
			apply: (function(){
				window.location.href = "/admin/register/settings"+this.prepare();
			})
		});
	}());

	var __value = $("select[data-ui='credential_levels']", __toolbarUiBox).attr("data-value");
	var __credentialLevelsUiSelect = $("select[data-ui='credential_levels']", __toolbarUiBox).kendoDropDownList({
		value: typeof __value != "undefined" ? __value : 0,
		change: (function(e){__filter.apply();})
	}).data("kendoDropDownList");

	__value = $("select[data-ui='regions']", __toolbarUiBox).attr("data-value");
	var __regionsUiSelect = $("select[data-ui='regions']", __toolbarUiBox).kendoDropDownList({
		value: typeof __value != "undefined" ? __value : 0,
		change: (function(e){__filter.apply();})
	}).data("kendoDropDownList");

	$("a[data-action='add']", __toolbarUiBox).click(function(){
		__formUiWindow.openFinder();
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
					__formUiWindow.openAccessLevelEditor($(__a).attr("data-id"));
					break;
					
				case "remove":
					__confirmFormUiWindow.confirm($(__a).attr("data-id"));
					break;
			}
		});
		
		if( ! ($(">tr", __uiTable.tbody).length > 0))
			$(__uiTable.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));
		
		return __uiTable;
	}($("table[data-ui='list']", __section)));
	
});