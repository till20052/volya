$(document).ready(function(){
	
	var __uiBox = $("div[data-uiBox='news']", $("td[data-uiBox='content']", $("body>section")));
		
	var	__listUiBox = (function(element){
		var __fn = new Object(),
			__rowTemplate = kendo.template($(">script#row_template", element).text()),
			__emptyTemplate = kendo.template($(">script#empty", element).text());
		
		$(">script[type='text/x-kendo-template']", element).remove();
		
		$(element).click(function(event){
			var __action = $($(event.target).parents("a[data-uiAction]").eq(0)).attr("data-uiAction");

			if(typeof __action == "undefined")
				return;

			switch(__action)
			{
				case "remove":
					__fn[__action]($($(event.target).parents("div[data-id]").eq(0)).attr("data-id"));
					break;
			}

			event.stopPropagation();
		});
		
		__fn["prepend"] = (function(data){
			if($(">div[data-uiBox='empty']", element).length > 0)
				$(">div[data-uiBox='empty']", element).remove();
			
			$(element).prepend(__rowTemplate(data));
		});
		
		__fn["remove"] = (function(id){
			$.post("/cells/news/j_remove", {
				id: id
			}, function(response){
				if( ! response.success)
					return;
				
				$(">div[data-id='"+id+"']", element).remove();
				
				if( ! ($(">div[data-id]", element).length > 0))
						$(element).append(__emptyTemplate({}));
			}, "json");
		});
		
		return ({
			element: element,
			fn: __fn
		});
	}($("div[data-uiBox='list']", __uiBox)));
		
	var	__addNewUiWindow = (function(element){
		var DATA = eval($(">script#data", element).text());
		
		var __uiWindow = (new Window($(element))).afterOpen(function(){
			$("input#title", __uiWindow.element).val("");
			__textUiTextarea.value("");
		});
		
		var __textUiTextarea = $("textarea[data-ui='text']", element).kendoEditor({
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
		__textUiTextarea.body.style.font = $("body").css("font");
		
		$("input#add", __uiWindow.element).click(function(){
			$.post("/cells/news/j_add", {
				cell_id: DATA.cell.id,
				title: $("input#title", __uiWindow.element).val(),
				text: __textUiTextarea.value()
			}, function(response){
				if( ! response.success)
					return;
				
				__listUiBox.fn.prepend(response.item);
				
				__uiWindow.close();
			}, "json");
		});
		
		return __uiWindow;
		
	}($("div[ui-window='cells.index.item.add_new']")));
	
	$("input#add_new", __uiBox).click(function(){
		__addNewUiWindow.open();
	});
	
});