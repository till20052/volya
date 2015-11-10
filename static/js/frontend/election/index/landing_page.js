$(document).ready(function(){
	
	var __section = $("body>section>div.section");
	
	(function(element){
		var __data = eval($(">script", element).text());
		
		var __charts = [];
		$("div[data-uiChart]", element).each(function(){
			var __this = this;
			__charts.push($(__this).kendoChart({
				legend: {visible: false},
				seriesDefaults: {
					type: "column",
					labels: {
                        visible: true,
                        background: "transparent",
						color: $(__this).attr("data-cacolor"),
						font: "18px sans-serif"
                    }
				},
				seriesColors: ["red"],
				series: [{
					field: "value"
				}],
				dataSource: {
					data: []
				},
				valueAxis: {
					max: 30,
					visible: false,
					line: {visible: false},
					minorGridLines: {visible: false}
				},
				categoryAxis: {
					categories: $.map(__data.parties, function(item){
						if(item.is_special != $(__this).attr("data-isSpecial"))
							return null;
						return item.name.replace(/\s/g, "\n");
					}),
					color: $(__this).attr("data-cacolor"),
					majorGridLines: {visible: false},
					majorTicks: {visible: false}
				},
				chartArea: {
					background: "transparent"
				},
				tooltip: {
					visible: true,
					template: "<div class=\"fs20\">#=value#</div>"
				}
			}).data("kendoChart"));
		});
		
		(function(element){
			$("a", element).click(function(){
				var __a = this;
				$(">li", $($(__a).parents("ul").eq(0))).removeClass("selected");
				$($(__a).parents("li").eq(0)).addClass("selected");
				__charts.forEach(function(chart){
					chart.dataSource.data($.map(__data.parties, function(item){
						if(item.is_special != $(chart.element).attr("data-isSpecial"))
							return null;
						return ({
							value: item.results[$(__a).attr("data-eid")]
						});
					}));
				});
			});
			
			$("li:first-child>a", element).click();
		})($("div.tabbar", element));
	})($("div[data-uiBox='charts']", __section));
	
	(function(element){
		$("td:nth-child(odd)", element).css({
			cursor: "pointer"
		}).click(function(){
			if( ! ($("a", this).length > 0))
				return;
			window.location.href = $("a", this).attr("href");
		});
	})($("table[data-ui='images']", __section));
	
	(function(element){
		$("td", element).click(function(){
			if( ! ($("a", this).length > 0))
				return;
			window.location.href = $("a", this).attr("href");
		});
	})($("div[data-uiGrid='candidates']", __section));
	
});