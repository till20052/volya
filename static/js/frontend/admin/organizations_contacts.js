$(document).ready(function()
{
	var __section = $("body>section");
	var __data = eval($("script#data", __section).text());
	
	var __formUiWindow = (function()
	{
		var __uiWindow = (new Window($("div[ui-window='admin.organizations_contacts.form']"))).afterOpen(function()
		{
			$($("input[ui-lang]", __uiWindow.element)[0]).click();
		});
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function()
		{
			__uiForm.data({
				id: $(__uiWindow.element).attr("data-id"),
				title: $("input#title", __formUiWindow.element).val(),
				name: $("input#name", __formUiWindow.element).val(),
				address: $("input#address", __formUiWindow.element).val(),
				region: __uiWindow.ui("regionUiSelect").value(),
				contacts: {
					email: $.map($("input[type='text']", $("table[data-ui='email']", __uiWindow.element)), function(input){
						if($(input).val() == "")
							return;
						return $(input).val();
					}),
					phone: $.map($("input[type='text']", $("table[data-ui='phone']", __uiWindow.element)), function(input){
						if($(input).val() == "")
							return;
						return $(input).val();
					})
				}
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

		var regionUiSelect = $("select[data-ui='region']", __uiWindow.element).kendoDropDownList().data("kendoDropDownList");
		__uiWindow.ui("regionUiSelect", regionUiSelect);

		(function(){
			var __uiTable = $("table[data-ui='email'], table[data-ui='phone']", __uiForm.element);

			$(__uiTable).click(function(e){
				var __a = $(e.srcElement.parentElement);
				switch($(__a).attr("data-ui"))
				{
					case "remove":
						$($(__a).parents("tr").eq(0)).next().remove();
						$($(__a).parents("tr").eq(0)).remove();
						break;
				}
			});

			$("input[data-ui='add']", __uiTable).click(function(e){
				$($(">script", $($(this).parents("table").eq(0))).text())
					.insertBefore($(">tbody>tr:last", $($(this).parents("table").eq(0))));
				e.stopPropagation();
			});
		}());

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
	
	var __confirmUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.organizations_contacts.confirm']"));
		
		$("a#yes", __uiWindow.element).click(function()
		{
			$.post("/admin/organizations_contacts/j_delete", {
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
	
	$("a#add", __section).click(function()
	{
		$(__formUiWindow.element).attr("data-id", 0);
		
		$("input#title", __formUiWindow.element).val("");
		$("input#name", __formUiWindow.element).val("");
		$("input#address", __formUiWindow.element).val("");

		$("tr[data-ui='value']", $("table[data-ui='email'], table[data-ui='phone']", __formUiWindow.element)).remove();

		$($(">script", $("table[data-ui='email']", __formUiWindow.element)).text())
				.insertBefore($(">tbody>tr:last", $($("table[data-ui='email']", __formUiWindow.element).eq(0))));

		$($(">script", $("table[data-ui='phone']", __formUiWindow.element)).text())
				.insertBefore($(">tbody>tr:last", $($("table[data-ui='phone']", __formUiWindow.element).eq(0))));

		__formUiWindow.ui("regionUiSelect").value(0);

		__formUiWindow.open();
	});
	
	var __listUiTable = (function()
	{
		$("table#list>script", __section).each(function(i)
		{
			__data["table#list"].columns[i]["template"] = kendo.template($(this).html());
		}).remove();
		
		$("table#list", __section).kendoGrid($.extend({}, __data["table#list"], {
			dataBound: (function(e)
			{
				$("a[ui='edit']", e.sender.tbody).click(function()
				{
					$.post("/admin/organizations_contacts/j_get_item", {
						id: $(this).attr("data-id")
					}, function(response)
					{
						if( ! response.success)
							return;
						
						$(__formUiWindow.element).attr("data-id", response.item.id);
						
						$("input#title", __formUiWindow.element).val(response.item.title);
						$("input#name", __formUiWindow.element).val(response.item.fname + " " + response.item.lname);
						$("input#address", __formUiWindow.element).val(response.item.address);

						__formUiWindow.ui("regionUiSelect").value(response.item.region);

						$("tr[data-ui='value']", $("table[data-ui='email'], table[data-ui='phone']", __formUiWindow.element)).remove();

						if(response.item.contacts.length > 1){
							response.item.contacts.forEach(function(contact){

								$("input", $($(">script", $("table[data-ui='" + contact.type + "']", __formUiWindow.element)).text())
									.insertBefore($(">tbody>tr:last", $($("table[data-ui='" + contact.type + "']", __formUiWindow.element).eq(0))))
								).val(contact.value);
							});
						}

						__formUiWindow.open();
					}, "json");
				});
				
				$("a[ui='remove']", e.sender.tbody).click(function()
				{
					$(__confirmUiWindow.element).attr("data-id", $(this).attr("data-id"));
					__confirmUiWindow.open();
				});
			})
		}));
		
		return $("table#list", __section).data("kendoGrid");
	})();
	
});