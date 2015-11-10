$(document).ready(function()
{
	var __section = $("body>section");
	var DATA = eval($("script#data", __section).text());
	
	var __formUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.mailer.form']"));
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function()
		{
			var __contacts = new Array();
			
			$("input[type=checkbox]:checked", __uiWindow.element).each(function(i, e){
				__contacts.push($(e).val());
			});
			
			__uiForm.data({
				id: $(__uiWindow.element).attr("data-id"),
				email_template_id: __emailTemplatesUiSelect.value(),
				sending_date: kendo.toString(__sendingDateUiInput.value(), "yyyy-MM-dd HH:mm:ss"),
				send_to_all: $("input[ui='send_to_all']", __uiWindow.element).val(),
				contacts: __contacts
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
		
		var __sendingDateUiInput = $("input[ui='sending_date']", __uiWindow.element).kendoDateTimePicker({
			format: "dd MMMM yyyy hh:mm"
		}).data("kendoDateTimePicker");
		__uiWindow.ui("sendingDateUiInput", __sendingDateUiInput);
		
		var __emailTemplatesUiSelect = $("select[data-ui='email_templates']", __uiWindow.element).kendoDropDownList({
			dataValueField: "id",
			dataTextField: "subject.ua",
			valueTemplate: "#=data.id#. #=data.subject.ua#",
			template: "#=data.id#. #=data.subject.ua#",
			dataSource: {
				data: []
			}
		})
		.data("kendoDropDownList");
		__uiWindow.ui("emailTemplatesUiSelect", __emailTemplatesUiSelect);
		
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
	
	var __contactsFormUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.mailer.add_contacts']"));
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function()
		{
			__uiForm.data({
				contacts: $("textarea[ui='contscts']").val()
			});
		}).afterSend(function(response)
		{
			if( ! response.success)
				return;
			
			$("div#contactsAddBox", __uiWindow.element).hide();
			$("div#messageBox", __uiWindow.element).show();
			$("div[data-uiBox='success']", __uiWindow.element).show();
			
			if( response.errors.length > 0 ){
				response.errors.forEach(function(item){
					var li = $("<li />").text(item);
					
					$("ul", $("div#messageBox", __uiWindow.element)).append(li);
				});
				$("div[data-uiBox='error']", __uiWindow.element).show();
			}
			
			if( response.list.length > 0 )
				response.list.forEach(function(item){
					__contactsListUiTable.dataSource.insert(0, item);
				});
		});
		
		$("a#save", __uiWindow.element).click(function()
		{
			__uiForm.send();
		});
		
		$("a#close", __uiWindow.element).click(function()
		{
			__uiWindow.close();
		});
		
		$("a#cancel", __uiWindow.element).click(function()
		{
			__uiWindow.close();
		});
		
		return __uiWindow;
	})();

	var __recipientsFormUiWindow = (function()
	{
		var __uiWindow = (new Window($("div[ui-window='admin.mailer.recipients']")));
		
		return __uiWindow;
	})();
	
	var __confirmUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.mailer.confirm']"));
		
		$("a#yes", __uiWindow.element).click(function()
		{
			$.post("/admin/mailer/j_delete_contact", {
				id: $(__uiWindow.element).attr("data-id")
			}, function(response)
			{
				if( ! response.success)
					return;
				
				__contactsListUiTable.dataSource.remove(__contactsListUiTable.dataSource.get($(__uiWindow.element).attr("data-id")));
				
				__uiWindow.close();
			}, "json");
		});
		
		$("a#no", __uiWindow.element).click(function()
		{
			__uiWindow.close();
		});
		
		return __uiWindow;
	})();
	
	$("input[ui='send_to_selected']", __formUiWindow.element).click(function(){
		$.post("/admin/mailer/j_get_mailer_contacts", {}, function(response){
			if( ! response.success)
				return;
			
			__contactsSelectorTableUiTable.dataSource.data([]);
			
			if( response.contacts.length > 0 )
				response.contacts.forEach(function(item){
					__contactsSelectorTableUiTable.dataSource.insert(0, item);
				});
		}, "json");
		
		$("tr#contacts_table", __formUiWindow.element).show();
		$("tr#contacts_table", __formUiWindow.element).prev("tr").show();
	});
	
	$("input[ui='send_to_all']", __formUiWindow.element).click(function(){
		$("tr#contacts_table", __formUiWindow.element).hide();
		$("tr#contacts_table", __formUiWindow.element).prev("tr").hide();
	});
	
	$("a#add", __section).click(function()
	{
		$(__formUiWindow.element).attr("data-id", 0);
		
		$.post("/admin/mailer/j_get_email_templates", {}, function(response){
			if( ! response.success)
				return;

			__formUiWindow.ui("emailTemplatesUiSelect").dataSource.data(response.email_templates);
		}, "json");
		
		$("input[ui='send_to_all']", __formUiWindow.element).click();
		
		__formUiWindow.ui("emailTemplatesUiSelect").value(0);
		__formUiWindow.ui("sendingDateUiInput").value(new Date());
		$("input[type=checkbox]:checked", __formUiWindow.element).removeAttr("checked");
		
		__formUiWindow.open();
	});
	
	$("a#save", __section).click(function()
	{
		$(__formUiWindow.element).attr("data-id", 0);
		
		$.post("/admin/mailer/j_add_mailer", {
			
		}, function(response){
			if( ! response.success)
				return;

			__formUiWindow.ui("emailTemplatesUiSelect").dataSource.data(response.email_templates);
		}, "json");
		
		__formUiWindow.open();
	});
	
	$("a#add_contacts", __section).click(function()
	{
		$(__contactsFormUiWindow.element).attr("data-id", 0);
		
		$("div#contactsAddBox", __contactsFormUiWindow.element).show();
		$("div#messageBox", __contactsFormUiWindow.element).hide();
		$("div[data-uiBox='success']", __contactsFormUiWindow.element).hide();
		$("div[data-uiBox='error']", __contactsFormUiWindow.element).hide();
		$("ul", $("div#messageBox", __contactsFormUiWindow.element)).html();
		$("textarea[ui='contscts']").val("");
		
		__contactsFormUiWindow.open();
	});
	
	var __listUiTable = (function()
	{
		$("table#list>script", __section).each(function(i)
		{
			DATA["table#list"].columns[i]["template"] = kendo.template($(this).html());
		}).remove();
		
		$("table#list", __section).kendoGrid($.extend(DATA["table#list"], {
			dataBound: (function(e)
			{
				$("input[type='checkbox'][ui='is_public']", e.sender.tbody).click(function()
				{
					$.post("/admin/events/j_publicate", {
						id: $(this).attr("data-id"),
						state: $(this).attr("checked") == "checked" ? 1 : 0
					});
				});
				
				$("a[ui='edit']", e.sender.tbody).click(function()
				{
					$.post("/admin/events/j_get_item", {
						id: $(this).attr("data-id")
					}, function(response)
					{
						if( ! response.success)
							return;
						
						var __item = response.item
						
						$(__formUiWindow.element).attr("data-id", __item.id);
						
						__formUiWindow.ui("i18n").value("title", response.item.title);
						__formUiWindow.ui("i18n").value("description", response.item.description);
						__formUiWindow.ui("happenAtUiInput").value(kendo.parseDate(response.item.happen_at));
						__formUiWindow.ui("regionUiSelect").value(response.item.region_id);
						$(__formUiWindow.ui("areaUiSelect").element).attr("data-value", response.item.area_id);
						$(__formUiWindow.ui("cityUiSelect").element).attr("data-value", response.item.city_id);
						
						__formUiWindow.ui("regionUiSelect").options.change({sender: __formUiWindow.ui("regionUiSelect")});
						
						__formUiWindow.open();
					}, "json");
				});
				
				$("a[ui='send_error_recipients']", e.sender.tbody).click(function(){
					$.post("/admin/mailer/j_get_error_recipients", {
						mailer_id: $(this).attr("ui-mailer-id")
					}, function(response){
						if( ! response.success)
							return;
						
						__recipientsTableUiTable.dataSource.data([]);
						
						if( response.recipients.length > 0 )
							response.recipients.forEach(function(item){
								if(item)
									__recipientsTableUiTable.dataSource.insert(0, item);
							});
					}, "json");
					
					__recipientsFormUiWindow.open();
				});
			}),
			height:"500px"
		}));
		
		return $("table#list", __section).data("kendoGrid");
	})();
	
	var __contactsSelectorTableUiTable = (function()
	{
		$("table#contacts_selector_table>script", __formUiWindow.element).each(function(i)
		{
			DATA["table#contacts_selector_table"].columns[i]["template"] = kendo.template($(this).html());
		}).remove();
		
		$("table#contacts_selector_table", __formUiWindow.element).kendoGrid($.extend(DATA["table#contacts_selector_table"], {
			height:"300px",
			dataSource:{
				scheme:{
					model:{
						id: "id"
					}
				}
			}
		}));
		
		return $("table#contacts_selector_table", __formUiWindow.element).data("kendoGrid");
	})();
	
	var __recipientsTableUiTable = (function()
	{
		$("table#recipients>script", __recipientsFormUiWindow.element).each(function(i)
		{
			DATA["table#recipients"].columns[i]["template"] = kendo.template($(this).html());
		}).remove();
		
		$("table#recipients", __recipientsFormUiWindow.element).kendoGrid($.extend(DATA["table#recipients"], {
			height:"300px",
			dataSource:{
				scheme:{
					model:{
						id: "id"
					}
				}
			}
		}));
		
		return $("table#recipients", __recipientsFormUiWindow.element).data("kendoGrid");
	})();
	
	var __contactsListUiTable = (function()
	{
		$("table#contacts>script", __section).each(function(i)
		{
			DATA["table#contacts"].columns[i]["template"] = kendo.template($(this).html());
		}).remove();
		
		$("table#contacts", __section).kendoGrid($.extend(DATA["table#contacts"], {
			dataBound: (function(e)
			{
				$("a[ui='remove']", e.sender.tbody).click(function()
				{
					$(__confirmUiWindow.element).attr("data-id", $(this).attr("data-id"));
					__confirmUiWindow.open();
				});
			}),
			height:"500px"
		}));
		
		return $("table#contacts", __section).data("kendoGrid");
	})();
});
