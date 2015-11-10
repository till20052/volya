$(document).ready(function(){
	
	var __section = $("body>section"),
		__uiBox = $("div[data-uiBox='calendar']", __section);
	
	var __addEventUiWindow = (function(element){
		var __DATA = eval($(">script#data", element).text()),
			__uiWindow = (new Window(element)).beforeOpen(function(){
			$("input#title", __uiWindow.element).val("");
			__descriptionUiTextarea.value("");
		});
		
		var __descriptionUiTextarea = $("textarea[data-ui='description']", __uiWindow.element).kendoEditor({
			tools: [
				"bold",
				"italic",
				"underline",
				"justifyLeft",
				"justifyCenter",
				"justifyRight",
				"justifyFull"
			]
		}).data("kendoEditor");
		__descriptionUiTextarea.body.style.font = $("body").css("font");
		
		var __happenAtUiDateTimePicker = $("input[data-uiDateTimePicker='happen_at']", __uiWindow.element).kendoDateTimePicker({
			format: "dd MMMM yyyy",
			vaalue: (new Date())
		}).data("kendoDateTimePicker");
		
		$("input#add", __uiWindow.element).click(function(){
			$(this).css({
				opacity: .3
			}).attr("disabled", true);
			
			$.post("/cells/events/j_add_event", {
				cell_id: __DATA.cell.id,
				title: $("input#title", __uiWindow.element).val(),
				description: __descriptionUiTextarea.value()
			}, function(response){
				if( ! response.success)
					return;
				
				if($.inArray(response.event_date, CALENDAR.data.events_dates) == -1)
					CALENDAR.data.events_dates.push(response.event_date);
				
				var __tokens = response.event_date.split(".");
				console.log(new Date(__tokens[2], __tokens[1], __tokens[0]));
				CALENDAR.uiCalendar.navigate(new Date(__tokens[2], (__tokens[1]-1), __tokens[0]), "day");
				
				__uiWindow.close();
			}, "json");
		});
		
		return __uiWindow;
	}($("div[ui-window='cells.index.common.right_column.add_event']")));
	
	$("input#add_event", CALENDAR.uiBox).click(function(){
		__addEventUiWindow.open(function(){
			$("input#add", __addEventUiWindow.element).css({
				opacity: 1
			}).attr("disabled", false);
		});
	});
	
});