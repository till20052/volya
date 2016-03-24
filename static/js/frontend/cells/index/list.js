$(document).ready(function(){
	
	var __section = $("body>section");
	var DATA = eval($(">script#data", __section).text());
	
	var __newCellUiWindow = (function(){
		var __uiWindow = new Window($("div[ui-window='cells.index.list.new_cell']"));
		
		var __regionUiSelect = $("select[data-ui='region']", __uiWindow.element).kendoDropDownList({
			dataValueField: "id",
			dataTextField: "title",
			dataSource: {
				data: ([{id: 0, title: "-"}]).concat(DATA.regions),
				scheme: {model: {id: "id"}}
			},
			value: 0,
			change: function(event){
				var __regionId = event.sender.value();
				
				__areaUiSelect.dataSource.data([{id: 0, title: "-"}]);
				__areaUiSelect.value(0);
				__areaUiSelect.options.change({sender: __areaUiSelect});
				
				if( ! (__regionId > 0))
				{
					$($(__areaUiSelect.wrapper).parents("tr").eq(0)).prev().hide();
					$($(__areaUiSelect.wrapper).parents("tr").eq(0)).hide();
					return;
				}
				
				$($(__areaUiSelect.wrapper).parents("tr").eq(0)).prev().show();
				$($(__areaUiSelect.wrapper).parents("tr").eq(0)).show();
				
				$(__areaUiSelect.wrapper).prev("div[data-uiCover='loading']").show();
				
				$.post("/api/o_geo/j_get_areas", {
					country_id: 2,
					region_id: __regionId
				}, function(response){
					if( ! response.success)
						return;
					$(__areaUiSelect.wrapper).prev("div[data-uiCover='loading']").hide();
					__areaUiSelect.dataSource.data(([{id: 0, title: "-"}]).concat(response.areas));
				}, "json");
			}
		}).data("kendoDropDownList");
		
		var __areaUiSelect = (function(){
			var __element = $("select[data-ui='area']", __uiWindow.element),
				__valueTemplate = kendo.template($(">script#valueTemplate", __element).text()),
				__template = kendo.template($(">script#template", __element).text());
			
			return $("select[data-ui='area']", __uiWindow.element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "title",
				dataSource: {
					data: [{id: 0, title: "-"}],
					scheme: {model: {id: "id"}}
				},
				value: 0,
				valueTemplate: __valueTemplate,
				template: __template,
				change: function(event){
					var __areaId = event.sender.value();
					
					__cityUiSelect.dataSource.data([{id: 0, title: "-"}]);
					__cityUiSelect.value(0);
					
					if( ! (__areaId > 0))
					{
						$($(__cityUiSelect.wrapper).parents("tr").eq(0)).prev().hide();
						$($(__cityUiSelect.wrapper).parents("tr").eq(0)).hide();
						__cityUiSelect.options.change({sender: __cityUiSelect});
						return;
					}
					
					$($(__cityUiSelect.wrapper).parents("tr").eq(0)).prev().show();
					$($(__cityUiSelect.wrapper).parents("tr").eq(0)).show();
					
					$(__cityUiSelect.wrapper).prev("div[data-uiCover='loading']").show();
					
					var __item = event.sender.dataSource.get(__areaId),
						__data = ({
						country_id: 2,
						region_id: __regionUiSelect.value()
					}),
						__url = "/api/o_geo/j_get_cities";
					
					if(typeof __item.area != "undefined")
						__data["area"] = __item.area;
					else
					{
						__url = "/api/o_geo/j_get_city";
						__data = ({
							city_id: __item.id
						});
					}
					
					$.post(__url, __data, function(response){
						if( ! response.success)
							return;
						
						$(__cityUiSelect.wrapper).prev("div[data-uiCover='loading']").hide();
						
						var __data = (typeof response.cities != "undefined")
							? ([{id: 0, title: "-"}]).concat(response.cities)
							: [response.city];
						
						__cityUiSelect.dataSource.data(__data);
						__cityUiSelect.options.change({sender: __cityUiSelect});
					}, "json");
				}
			}).data("kendoDropDownList");
		}());
		
		var __cityUiSelect = (function(){
			var __element = $("select[data-ui='city']", __uiWindow.element),
				__template = kendo.template($(">script#template", __element).text());
			
			return $(__element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "title",
				dataSource: {
					data: [{id: 0, title: "-"}],
					scheme: {model: {id: "id"}}
				},
				template: __template,
				change: function(event){
					$("input#area_in_city", __uiWindow.element).val("");
					$($("input#area_in_city", __uiWindow.element).parents("tr").eq(0)).prev().hide();
					$($("input#area_in_city", __uiWindow.element).parents("tr").eq(0)).hide();
					
					var __city = event.sender.dataSource.get(event.sender.value());
					
					if(__city.id > 0 && __city.important == 1)
					{
						$($("input#area_in_city", __uiWindow.element).parents("tr").eq(0)).prev().show();
						$($("input#area_in_city", __uiWindow.element).parents("tr").eq(0)).show();
						__uiWindow.checkPosition();
					}
				}
			}).data("kendoDropDownList");
		}());
		
		__regionUiSelect.options.change({sender: __regionUiSelect});
		
		$("input#select_roep", __uiWindow.element).click(function(){
			__roepSelectionUiWindow.open();
		});
		
		var __startedAtUiDatePicker = $("input[data-uiDatePicker='started_at']", __uiWindow.element).kendoDatePicker({
			format: "dd MMMM yyyy",
			value: (new Date())
		}).data("kendoDatePicker");
		
		$("input#select_users", __uiWindow.element).click(function(){
			__usersFinderUiWindow.open();
		});
		
		var __selectedUsersUiList = (function(){
			var __element = $("div[data-uiList='selected_users']", __uiWindow.element),
				__template = kendo.template($(">script[type='text/x-kendo-template']", __element).text());
			
			$(__element).click(function(event){
				var __a = $($(event.target).parents("a").eq(0));
				switch($(__a).attr("data-event")){
					case "remove":
						$($(__a).parents("div[data-item]").eq(0)).remove();
						break;
				}
			});
			
			var __add = (function(data){
				$(__template(data)).insertBefore($(">div.cboth", __element));
			});
			
			return ({
				element: __element,
				add: __add
			});
		}());
		__uiWindow.ui("selected_users", __selectedUsersUiList);
		
		var __scansUiList = (function(){
			var __element = $("div[data-uiList='scans']", __uiWindow.element),
				__template = kendo.template($(">script[type='text/x-kendo-template']", __element).text());
			
			var __add = (function(data){
				$(__template(data)).insertBefore($(">div.cboth", __element));
			});
			
			return ({
				element: __element,
				add: __add
			});
		}());
		__uiWindow.ui("scans", __scansUiList);
		
		$("input#upload_scan", __uiWindow.element).click(function(){
			__scanUploaderUiWindow.open();
		});
		
		$("a#save", __uiWindow.element).click(function(){
			
			var __users = $.map($(">div[data-item]", __selectedUsersUiList.element), function(item){
				return $(item).attr("data-item");
			});
			
			$("div[data-uiBox='error']", __uiWindow.element).hide();
			
			if(__users.length < 3)
			{
				$("div[data-uiBox='error']", __uiWindow.element).show();
				$("div[data-uiBox='error']>div", __uiWindow.element).hide();
				$("div[data-uiBox='error']>div#invalid_members_count", __uiWindow.element).show();
				return;
			}
			
			$.post("/cells/index/j_save", {
				region_id: __regionUiSelect.value(),
				region_name: __regionUiSelect.dataSource.get(__regionUiSelect.value()).title,
				city_id: __cityUiSelect.value(),
				city_name: __cityUiSelect.dataSource.get(__cityUiSelect.value()).title,
				area_in_city: $("input#area_in_city", __uiWindow.element).val(),
				address: $("input#address", __uiWindow.element).val(),
				plot_id: $("td[data-ui='plot_number']", __uiWindow.element).attr("data-plotId"),
				started_at: kendo.toString(__startedAtUiDatePicker.value(), "yyyy-MM-dd"),
				users: __users,
				images: $.map($(">div[data-item]", __scansUiList.element), function(item){
					return $(item).attr("data-item");
				})
			}, function(response){
				window.location.reload();
			}, "json");
		});
		
		return __uiWindow;
	}());
	
	var __roepSelectionUiWindow = (function(){
		var __uiWindow = new Window($("div[ui-window='cells.index.list.roep_selection']"));
		__uiWindow.beforeOpen(function(){
			__uiBoxes.forEach(function(uiBox, i){
				if(i > 0)
					$(uiBox.element).hide();
				else
					$(uiBox.element).show();
				__roepSelectionUiWindow.checkPosition();
			});
			__uiBoxes[0].regionUiSelect.value(0);
		});
		__uiWindow.afterClose(function(){
			__newCellUiWindow.open();
		});
		
		var __uiBoxes = new Array();
		
		__uiBoxes.push(function(){
			var __uiBox = $("div[data-uiBox='1']", __uiWindow.element),
				__regionUiSelect = $("select[data-ui='region']", __uiBox).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "name",
				dataSource: {
					data: ([{id: 0, name: "-"}]).concat(DATA.roep.regions),
					scheme: {model: {id: "id"}}
				},
				change: function(event)
				{
					var __regionId = event.sender.value();
					
					if( ! (__regionId > 0))
						return;
					
					$.post("/api/roep/j_get_districts", {
						region_id: __regionId
					}, function(response){
						$(__uiBoxes[0].element).hide();
						$(__uiBoxes[1].element).show();
						__uiBoxes[1].uiTable.dataSource.data(response.districts);
						__roepSelectionUiWindow.checkPosition();
					}, "json");
				}
			}).data("kendoDropDownList");
			
			return ({
				element: __uiBox,
				regionUiSelect: __regionUiSelect
			});
		}());
		
		__uiBoxes.push(function(){
			var __uiBox = $("div[data-uiBox='2']", __uiWindow.element),
				__uiTable = (function(){
					var __element = $("table[data-ui='districts']", __uiBox),
						__options = eval($(">script#options", __element).text()),
						__templates = $.map($(">script[type='text/x-kendo-template']", __element), function(template){
							return kendo.template($(template).text());
						});
						
					for(var __i in __options["columns"])
						__options["columns"][__i]["template"] = __templates[__i];
					
					return $(__element).kendoGrid($.extend({}, __options)).data("kendoGrid");
				}());
			
			$(__uiTable.wrapper).click(function(event){
				switch($(event.target).attr("data-event")){
					case "get_plots":
						$.post("/api/roep/j_get_plots", {
							region_id: __uiBoxes[0].regionUiSelect.value(),
							district_id: $(event.target).attr("data-id")
						}, function(response){
							$(__uiBoxes[1].element).hide();
							$(__uiBoxes[2].element).show();
							__uiBoxes[2].uiTable.dataSource.data(response.plots);
							__roepSelectionUiWindow.checkPosition();
						}, "json");
						break;
				}
			});
			
			$("a#back", __uiBox).click(function(){
				$(__uiBoxes[0].element).show();
				$(__uiBoxes[1].element).hide();
				__roepSelectionUiWindow.checkPosition();
			});
			
			return ({
				element: __uiBox,
				uiTable: __uiTable
			});
		}());
		
		__uiBoxes.push(function(){
			var __uiBox = $("div[data-uiBox='3']", __uiWindow.element),
				__uiTable = (function(){
					var __element = $("table[data-ui='plots']", __uiBox),
						__options = eval($(">script#options", __element).text()),
						__templates = $.map($(">script[type='text/x-kendo-template']", __element), function(template){
							return kendo.template($(template).text());
						});
						
					for(var __i in __options["columns"])
						__options["columns"][__i]["template"] = __templates[__i];
					
					return $(__element).kendoGrid($.extend({}, __options)).data("kendoGrid");
				}());
			
			$(__uiTable.wrapper).click(function(event){
				switch($(event.target).attr("data-event")){
					case "select_plot":
						__uiWindow.close();
						$("td[data-ui='plot_number']", __newCellUiWindow.element).show()
								.attr("data-plotId", $(event.target).attr("data-id"))
								.html($(event.target).html());
						$("input#select_roep", __newCellUiWindow.element).val("Обрати іншу")
						break;
				}
			});
			
			$("a#back", __uiBox).click(function(){
				$(__uiBoxes[1].element).show();
				$(__uiBoxes[2].element).hide();
				__roepSelectionUiWindow.checkPosition();
			});
			
			return ({
				element: __uiBox,
				uiTable: __uiTable
			});
		}());
		
		return __uiWindow;
	}());
	
	var __usersFinderUiWindow = (function(){
		var __uiWindow = new Window($("div[ui-window='cells.index.users_finder']"));
		__uiWindow.beforeOpen(function(){
			$("input#q", __uiWindow.element).val("");
			__listUiTable.dataSource.data([]);
			$(">div[data-item]", __selectedUsersUiList.element).remove();
			__uiWindow.checkPosition();
		});
		__uiWindow.afterClose(function(){
			__newCellUiWindow.open();
		});
		
		$("input#find", __uiWindow.element).click(function(){
			var __q = $("input#q", __uiWindow.element).val();
			
			if(__q == "")
				return;
			
			$.post("/api/users/j_find", {
				q: __q,
				type: [99, 100],
				is_member: 0,
				is_verified: 1
			}, function(response){
				__listUiTable.dataSource.data(response.users);
				__uiWindow.checkPosition();
			}, "json");
		});
		
		var __listUiTable = (function(){
			var __element = $("table[data-ui='list']", __uiWindow.element),
				__options = eval($(">script#options", __element).text()),
				__templates = $.map($(">script[type='text/x-kendo-template']", __element), function(template){
					return kendo.template($(template).text());
				});

			for(var __i in __options["columns"])
				__options["columns"][__i]["template"] = __templates[__i];

			var __uiGrid = $(__element).kendoGrid($.extend({}, __options, {
				dataSource: {
					data: [],
					scheme: {model: {id: "id"}}
				}
			})).data("kendoGrid");
			
			$(__uiGrid.wrapper).click(function(event){
				switch($(event.target).attr("data-event")){
					case "add_user":
						__selectedUsersUiList.add(__uiGrid.dataSource.get($(event.target).attr("data-id")));
						break;
				}
			});
			
			return __uiGrid;
		}());
		
		var __selectedUsersUiList = (function(){
			var __element = $("div[data-uiList='selected_users']", __uiWindow.element),
				__template = kendo.template($(">script[type='text/x-kendo-template']", __element).text());
			
			$(__element).click(function(event){
				var __a = $($(event.target).parents("a").eq(0));
				switch($(__a).attr("data-event")){
					case "remove_user":
						$($(__a).parents("div[data-item]").eq(0)).remove();
						break;
				}
			});
			
			var __add = (function(data){
				$(__template(data)).insertBefore($(">div.cboth", __element));
			});
			
			return ({
				element: __element,
				add: __add
			});
		}());
		
		$("a#add_users", __uiWindow.element).click(function(){
			__uiWindow.close();
			
			$(">div[data-item]", __newCellUiWindow.ui("selected_users").element).remove();
			
			$(">div[data-item]", __selectedUsersUiList.element).each(function(){
				$("td[data-uiBox='selected_users']", __newCellUiWindow.element).show();
				__newCellUiWindow.ui("selected_users").add({
					id: $(this).attr("data-item"),
					name: $(this).attr("data-name")
				});
			});
		});
		
		return __uiWindow;
	}());
	
	var __scanUploaderUiWindow = (function(){
		var __uiWindow = (new Window($("div[ui-window='cells.scan_uploader']"))).beforeOpen(function()
		{
			$("li", __fileUiInput.wrapper).each(function()
			{
				$("span.k-delete", this).click();
			});
		}).afterClose(function(){
			__newCellUiWindow.open();
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
				
				__newCellUiWindow.ui("scans").add({image: __file});
				
				__uiWindow.close();
			})
		}).data("kendoUpload");
		__uiWindow.ui("fileUiInput", __fileUiInput);
		
		return __uiWindow;
	})();
	
	$("a#add_users", __section).click(function(){
		__usersFinderUiWindow.open();
	});
	
	$("a#create_cell", __section).click(function(){
		__newCellUiWindow.open();
	});
	
});