$(document).ready(function(){
	
	var __uiBox = $("div[data-uiBox='documents']", $("td[data-uiBox='content']", $("body>section"))),
		__listUiTable = (function(element){
			var __fn = new Object(),
				__rowTemplate = kendo.template($(">script#row_template", element).text()),
				__emptyTemplate = kendo.template($(">script#empty", element).text());
			
			$(element).click(function(event){
				var __action = $($(event.target).parents("a[data-uiAction]").eq(0)).attr("data-uiAction");
				
				if(typeof __action == "undefined")
					return;
				
				switch(__action)
				{
					case "remove":
						__fn[__action]($($(event.target).parents("tr[data-id]").eq(0)).attr("data-id"));
						break;
				}
				
				event.stopPropagation();
			});
			
			__fn["prepend"] = (function(data){
				if($(">tbody>tr[data-id='0']", element).length > 0)
					$(">tbody>tr[data-id='0']", element).remove();
				
				$(">tbody", element).prepend(__rowTemplate(data));
			});
			
			__fn["remove"] = (function(id){
				$.post("/cells/documents/j_remove", {
					id: id
				}, function(response){
					if( ! response.success)
						return;
					
					$("tr[data-id='"+id+"']", element).remove();
					
					if( ! ($(">tbody>tr", element).length > 0))
						$(">tbody", element).append(__emptyTemplate({}));
				}, "json");
			});
			
			return ({
				element: element,
				fn: __fn
			});
		}($("table[data-ui='list']", __uiBox)));
	
	var __addDocumentUiWindow = (function(element){
		var DATA = eval($(">script#data", element).text());
		
		var __uiWindow = (new Window($(element))).afterOpen(function(){
			$("input#name", __uiWindow.element).val("");
			__typeUiSelect.value(1);
			$(__documentUiFileUpload.element).attr("data-hash", "");
			$(">div:first", __documentUiFileUpload.element).show();
			$(__documentUiFileUpload.fileupload).css({
				width: $(">div:first", __documentUiFileUpload.element).width()+"px",
				height: $(">div:first", __documentUiFileUpload.element).height()+"px"
			});
			$(">div:last", __documentUiFileUpload.element).hide();
		});
		
		var __typeUiSelect = $("select[data-ui='type']", __uiWindow.element).kendoDropDownList({
			dataValueField: "id",
			dataTextField: "text",
			dataSource: {
				data: DATA.document_types
			}
		}).data("kendoDropDownList");
		
		var __documentUiFileUpload = (function(element){
			var __fileupload = $("input[type='file']", element);
			
			$(__fileupload).fileupload({
				dataType: "json",
				url: "/s/storage/j_save",
				sequentialUploads: true,
				done: (function(event, data){
					$(element).attr("data-hash", data.result.files[0]);
					$(">div:first", __documentUiFileUpload.element).hide();
					$(">div:last", __documentUiFileUpload.element).show();
					$("span[data-uiLabel='name']").html(data.files[0].name);
				})
			});
			
			$("a[data-uiAction='remove']").click(function(){
				$(element).attr("data-hash", "");
				$(">div:first", __documentUiFileUpload.element).show();
				$(">div:last", __documentUiFileUpload.element).hide();
			});
			
			return ({
				element: element,
				fileupload: __fileupload
			});
		}($("div[data-uiFileUpload='document']", __uiWindow.element)));
		
		$("input#add", __uiWindow.element).click(function(){
			$.post("/cells/documents/j_add", {
				cell_id: DATA.cell.id,
				name: $("input#name", __uiWindow.element).val(),
				type: __typeUiSelect.value(),
				hash: $(__documentUiFileUpload.element).attr("data-hash")
			}, function(response){
				if( ! response.success)
					return;
				
				__listUiTable.fn.prepend(response.item);
				
				__uiWindow.close();
			}, "json");
		});
		
		return __uiWindow;
		
	}($("div[ui-window='cells.index.item.add_document']")));
	
	$("input#add_document", __uiBox).click(function(){
		__addDocumentUiWindow.open();
	});
	
});