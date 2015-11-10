$(document).ready(function()
{
	var __step = 1;
	var __section = $("body>section");
	var __table = $("table.list", __section);
	
	var DATA = eval($(">script#data", __section).text());
	
	(function(){
		var __regionUiSelect = $("select[data-ui='region']", __section).kendoDropDownList({
			dataValueField: "id",
			dataTextField: "title",
			dataSource: {
				data: ([{id: 0, title: "-"}]).concat(DATA.regions),
				scheme: {model: {id: "id"}}
			},
			value: DATA.region_id,
			change: function(event){
				var __regionId = event.sender.value();
				
				__areaUiSelect.dataSource.data([{id: 0, title: "-"}]);
				__areaUiSelect.value(0);
				__areaUiSelect.options.change({sender: __areaUiSelect});
				
				if( ! (__regionId > 0))
				{
					$("div[data-uiBox='area']").hide();
					return;
				}
				
				$("div[data-uiBox='area']").show();
				$("div[data-uiCover='area']").show();
				
				$.post("/api/geo/j_get_areas", {
					country_id: 2,
					region_id: __regionId
				}, function(response){
					if( ! response.success)
						return;
					
					$("div[data-uiCover='area']").hide();
					__areaUiSelect.dataSource.data(([{id: 0, title: "-"}]).concat(response.areas));
					
					if(DATA.area_id > 0)
					{
						__areaUiSelect.value(DATA.area_id);
						__areaUiSelect.options.change({sender: __areaUiSelect});
						DATA.area_id = 0;
					}
				}, "json");
			}
		}).data("kendoDropDownList");
		
		var __areaUiSelect = (function(){
			var __element = $("select[data-ui='area']", __section),
				__valueTemplate = kendo.template($(">script#valueTemplate", __element).text()),
				__template = kendo.template($(">script#template", __element).text());
			
			return $(__element).kendoDropDownList({
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
						$("div[data-uiBox='city']").hide();
//						__cityUiSelect.options.change({sender: __cityUiSelect});
						return;
					}
					
					$("div[data-uiBox='city']").show();
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
						
						if(DATA.city_id > 0)
						{
							__cityUiSelect.value(DATA.city_id);
							DATA.city_id = 0;
						}
//						__cityUiSelect.options.change({sender: __cityUiSelect});
					}, "json");
				}
			}).data("kendoDropDownList");
		}());
		
		var __cityUiSelect = (function(){
			var __element = $("select[data-ui='city']", __section),
				__template = kendo.template($(">script#template", __element).text());
			
			return $(__element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "title",
				dataSource: {
					data: [{id: 0, title: "-"}],
					scheme: {model: {id: "id"}}
				},
				template: __template
			}).data("kendoDropDownList");
		}());
		
		__regionUiSelect.options.change({sender: __regionUiSelect});
		
		$("a#search", __section).click(function(){
			var __href = "/people?rid="+__regionUiSelect.value();
			
			if(__areaUiSelect.value() > 0) // && __areaUiSelect.value() != __cityUiSelect.value()
				__href += "&aid="+__areaUiSelect.value();
			
			if(__cityUiSelect.value() > 0)
				__href += "&cid="+__cityUiSelect.value();
			
			window.location.href = __href;
		});
	}());
	
	var __dataBound = (function()
	{
		$("td[ui='subscribe'] a#send:not([data-init='1'])", __table).click(function()
		{
			var __td = $($(this).parents("td").eq(0));

			$(this).hide();
			$("div#loading", __td).show();

			$.post("/people/j_subscribe", {
				friend_id: $(this).attr("data-id")
			}, function(response)
			{
				if( ! response.success)
					window.location.href = "/";

				$("div#loading", __td).hide();
				$("div#done", __td).show();
			}, "json");
		}).attr("data-init", 1);
	});
	
	$("a#show_more", __section).click(function()
	{
		var __data = ({
			step: __step
		});
		
		var __urlParam = (function(name){
			var __results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
			if (__results == null)
			   return null;
			else
			   return __results[1] || 0;
		});
		
		if(__urlParam("rid") != null)
			__data["rid"] = __urlParam("rid");
		
		if(__urlParam("cid") != null)
			__data["cid"] = __urlParam("cid");
		
		$.get("/people", __data, function(html)
		{
			$(">tbody", __table).append(html);
			
//			console.log($(">tbody>tr", __table).length, $(__table).attr("data-count"));
			
			if($(">tbody>tr", __table).length >= $(__table).attr("data-count"))
				$("a#show_more", __section).remove();
			
			__dataBound();
			
			__step++;
		});
	});
	
	__dataBound();
	
});