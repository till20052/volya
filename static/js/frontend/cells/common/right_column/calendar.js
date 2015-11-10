var CALENDAR = new Object();

$(document).ready(function(){
	
	var __section = $("body>section"),
		__uiBox = $("div[data-uiBox='calendar']", __section);
	
	CALENDAR = eval($(">script#data", __uiBox).text());
	
	var __listUiBox = (function(element){
		var __rowTemplate = kendo.template($(">script#row_template", element).text()),
			__emptyTemplate = kendo.template($(">script#empty", element).text());
		
		var __fn = ({
			append: (function(data){
				if($(">div.empty", element).length > 0)
					$(">div.empty", element).remove();
				
				$(element).append(__rowTemplate(data));
			}),
			clear: (function(){
				$(element).empty();
				$(element).append(__emptyTemplate({}));
			})
		});
		
		return ({
			element: element,
			fn: __fn
		});
	}($(">section>div[data-uiBox='list']", __uiBox)));
	
	var __initCalendar = (function(element){
		var __headerTemplate = kendo.template($(">script#header", element).text()),
			__monthContentTemplate = $(">script#month-content", element).html();
		
		var __navigateDirection = 0;
		var __uiCalendar = $(element).kendoCalendar({
			month: ({
				content: __monthContentTemplate
			}),
			footer: false,
			change: (function(event){
				__listUiBox.fn.clear();
				$.post("/profile/j_get_events", {
					from: kendo.toString(event.sender.value(), "dd.MM.yyyy"),
					to: kendo.toString(event.sender.value(), "dd.MM.yyyy")
				}, function(response){
					if( ! response.success)
						return;
					
					for(var __i in response.events)
						__listUiBox.fn.append(response.events[__i]);
				}, "json");
			}),
			navigate: (function(event){
				if(__navigateDirection < 0)
					__navigateDirection = 0;
				
				var __wrapperTable = $($("table.k-content", event.wrapper).eq(__navigateDirection)),
					__dateRange = new Array();
				
				([
					">tbody>tr:first-child>td:first-child>a",
					">tbody>tr:last-child>td:last-child>a"
				]).forEach(function(element){
					var __dataValue = $(element, __wrapperTable).attr("data-value").split("/");
					__dataValue[1]++;
					__dateRange.push(kendo.parseDate(__dataValue.join("/")));
				});

				__listUiBox.fn.clear();
				
				$.post("/profile/j_get_events", {
					from: kendo.toString(__dateRange[0], "dd.MM.yyyy"),
					to: kendo.toString(__dateRange[1], "dd.MM.yyyy")
				}, function(response){
					if( ! response.success)
						return;
					
					for(var __i in response.events)
						__listUiBox.fn.append(response.events[__i]);
				}, "json");
			})
		}).data("kendoCalendar");
		
		$(__uiCalendar.wrapper).prepend(__headerTemplate({}));
		
		$(">div.k-header:nth-child(2)>a", __uiCalendar.wrapper).each(function(i){
			if(i == 1)
				return;
			
			$(this).data("events").click.forEach(function(event){
				$(">div.k-header:nth-child(1)>div:nth-child("+(i+1)+")>a", __uiCalendar.wrapper).click(event.handler)
						.click(function(){
							__navigateDirection = (i-1);
						});
			});
		});
		
		$(">div.k-header:nth-child(1)>div:nth-child(2)", __uiCalendar.wrapper).append(
			$(">div.k-header:nth-child(2)>a:nth-child(2)", __uiCalendar.wrapper)
		);

		$(">div.k-header:nth-child(1)>div:nth-child(2)>a", __uiCalendar.wrapper).attr({
			href: "javascript:void(0)"
		}).data("events").click = null;

		$(">div.k-header:nth-child(2)", __uiCalendar.wrapper).remove();
		
		return __uiCalendar;
	}($("div[data-uiCalendar='ical']", __uiBox)));
	
});