$(document).ready(function(){
	
	var __section = $("body>section"),
		__tabbar = $("div.tabbar", __section);
	
	var DATA = eval($(">script#data", __section).text());
	
	$("a", __tabbar).click(function(){
		$(">li", $($(this).parents("ul").eq(0))).removeClass("selected");
		$($(this).parents("li").eq(0)).addClass("selected");
		$("div[data-uiBox]", __uiForm.element).hide();
		$("div[data-uiBox='"+$(this).attr("data-uiBox")+"']", __uiForm.element).show();
	});
	
	var __uiForm = new Form($("form#profile", __section));
	__uiForm.beforeSend(function(){
		__uiForm.data({
			id: $(__uiForm.element).attr("data-uid"),
			locality: __geoKoatuuCodeUiAutoComplete.value(),
			birthday_day: __birthdayDayUiSelect.value(),
			birthday_month: __birthdayMonthUiSelect.value(),
			birthday_year: __birthdayYearUiSelect.value(),
			street: $("input#street", __uiForm.element).val(),
			house_number: $("input#house_number", __uiForm.element).val(),
			apartment_number: $("input#apartment_number", __uiForm.element).val(),
			education_level: __educationLevelYearUiSelect.value(),
			professional_status: __professionalStatusYearUiSelect.value(),
			employment_scope: __employmentScopeYearUiSelect.value(),
			contacts: {
				email: $.map($("input[type='text']", $("table[data-ui='email']", __contactsUiBox)), function(input){
					if($(input).val() == "")
						return;
					return $(input).val();
				}),
				phone: $.map($("input[type='text']", $("table[data-ui='phone']", __contactsUiBox)), function(input){
					if($(input).val() == "")
						return;
					return $(input).val();
				})
			}
		});
	});
	__uiForm.afterSend(function(response){
		if(response.success)
		{
			$("div[data-uiBox='success']", __uiForm.element).show()
					.css("opacity", 0)
					.animate({opacity: 1}, 200);
			setTimeout(function(){
				$("div[data-uiBox='success']", __uiForm.element).animate({opacity: 0}, 200, function(){
					$(this).hide();
				});
			}, 2000);
			return;
		}
		
		for(var __i in response.error)
		{
			var __uiBox = $($(response.error[__i], __section).parents("div[data-uiBox]").eq(0));
			$("a[data-uiBox='"+$(__uiBox).attr("data-uiBox")+"']", __tabbar).click();
			$($(response.error[__i], __section)).css("borderColor", "red");
			setTimeout(function(){
				$($(response.error[__i], __section)).css("borderColor", "");
			}, 2000);
			break;
		}
	});
	
	(function(element){
		return $(element).kendoDropDownList({
			enable: false,
			value: $(element).attr("data-value")
		}).data("kendoDropDownList");
	}($("select[data-ui='sex']", __uiForm.element)));
	
	var __birthdayDayUiSelect = $("select[data-ui='birthday_day']", __uiForm.element).kendoDropDownList({
		dataValueField: "id",
		dataTextField: "text",
		value: DATA.birthday.day,
		dataSource: {
			data: (function(){
				var __data = [];
				for(var __i = 0; __i < 31; __i++)
					__data.push({
						id: (__i+1),
						text: (__i+1)
					});
				return __data;
			}())
		}
	}).data("kendoDropDownList");
	
	var __birthdayMonthUiSelect = $("select[data-ui='birthday_month']", __uiForm.element).kendoDropDownList({
		dataValueField: "id",
		dataTextField: "text",
		value: DATA.birthday.month,
		dataSource: {
			data: (function(){
				var __data = [];
				for(var __i = 0; __i < 12; __i++)
					__data.push({
						id: (__i+1),
						text: kendo.toString(new Date(1, __i, 1), "MMMM")
					});
				return __data;
			}())
		}
	}).data("kendoDropDownList");
	
	var __birthdayYearUiSelect = $("select[data-ui='birthday_year']", __uiForm.element).kendoDropDownList({
		dataValueField: "id",
		dataTextField: "text",
		value: DATA.birthday.year,
		dataSource: {
			data: (function(){
				var __data = [],
					__dateNow = new Date();
				for(var __i = 0; __i < 100; __i++)
					__data.push({
						id: __dateNow.getFullYear() - (__i + 15),
						text: __dateNow.getFullYear() - (__i + 15)
					});
				return __data;
			}())
		}
	}).data("kendoDropDownList");
	
	var __educationLevelYearUiSelect = $("select[data-ui='education_level']", __uiForm.element).kendoDropDownList({
		dataValueField: "id",
		dataTextField: "text",
		value: DATA.education_level
	}).data("kendoDropDownList");
	
	var __professionalStatusYearUiSelect = $("select[data-ui='professional_status']", __uiForm.element).kendoDropDownList({
		dataValueField: "id",
		dataTextField: "text",
		value: DATA.professional_status
	}).data("kendoDropDownList");
	
	var __employmentScopeYearUiSelect = $("select[data-ui='employment_scope']", __uiForm.element).kendoDropDownList({
		dataValueField: "id",
		dataTextField: "name",
		value: DATA.employment_scope,
		dataSource: {
					data: DATA.employment_scopes,
					scheme: {model: {id: "id"}}
				},
	}).data("kendoDropDownList");

	var __geoKoatuuCodeUiAutoComplete = (function(element){
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
							url: "/api/geo/j_find_cities?q="+options.data.filter.filters[0].value,
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
				__value = $(">div", e.item).attr("data-id");
			})
		}).data("kendoAutoComplete");

		var __compiledUiAutoComplete = $.extend(__uiAutoComplete, {
			value: function(id, title){
				if(typeof id != "undefined"){
					__value = id;

					$(">input", __uiAutoComplete.wrapper).val("");
					if(typeof title != "undefined")
						$(">input", __uiAutoComplete.wrapper).val(title);
				}

				return __value;
			}
		});

		__compiledUiAutoComplete.value($(element).attr("data-id"), $(element).attr("data-title"));

		return __compiledUiAutoComplete;
	})($("input[data-uiAutoComplete='locality']", __uiForm.element));

	var __contactsUiBox = $("div[data-uiBox='contacts']", __uiForm.element);
	(function(){
		var __uiTable = $("table[data-ui='email'], table[data-ui='phone']", __contactsUiBox);
		
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
	
	var __scansUploaderUiWindow = (function()
	{
		var __uiWindow = (new Window($("div[ui-window='profile.scans_uploader']"))).beforeOpen(function()
		{
			$("li").each(function()
			{
				$("span.k-delete", this).click();
			});
		});
		
		var __fileUiInput = $("input#scan", __uiWindow.element).kendoUpload({
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
				
				var __type = $("input#scan").attr("data-type");
				var __file = eval("("+e.XMLHttpRequest.response+")").files[0];

				if( ! __file ){
					alert("Помилка при завантаженні скана. Даний формат не підтримуеться.");
					return;
				}
				
				$("div.delete", $("div#upload"+__type)).show();
				$("div#upload"+__type, __section).css("backgroundImage", "url('/s/img/thumb/ag/"+__file+"')");

				$.post("/profile/edit/j_add_doc", {
					id: $(__uiForm.element).attr("data-uid"),
					scan: __file,
					type: __type
				}, "json");
				
				__uiWindow.close();
			}),
			complete: (function(e){
				$(">ul>li span.k-delete", e.sender.wrapper).click();
			})
		}).data("kendoUpload");
		__uiWindow.ui("fileUiInput", __fileUiInput);
	
		return __uiWindow;
	})();
	
	$("input#allowToUsePd", __section).change(function(){
		if( $(this).prop("checked") )
			$("tr[ui='previews']", __section).show();
		else
			$("tr[ui='previews']", __section).hide();
	});
	
	var scansTypes = new Array(
			"PassportPage1",
			"PassportPage2",
			"PassportPage11",
			"Tin",
			"ApplicationForMembership",
			"LustrationDeclaration"
		);
	
	scansTypes.forEach(function( scanType ){
		
		var __uploadScanForm = $("div#upload"+scanType, __section);
		
		if( DATA.docs[scanType] )
			$(__uploadScanForm).css("backgroundImage", "url('/s/img/thumb/ag/"+DATA.docs[scanType]+"')");
		else
			$("div.delete", $(__uploadScanForm)).hide();
		
		$(__uploadScanForm).hover(function(){
			$(".scanMenu", $(this) ).slideDown();
		}, function(){
			$(".scanMenu", $(this) ).stop().slideUp();
		});
		
		$("a", $(__uploadScanForm)).click(function(){
			$.post("/profile/edit/j_delete_doc_by_type", {
				id: $(__uiForm.element).attr("data-uid"),
				type: scanType
			}, function(response)
			{
				if( !response.success )
					return;
				
				$("div.delete", $(__uploadScanForm)).hide();
				$(__uploadScanForm).css("backgroundImage", "url('/img/no_image.jpg')");
			}, "json");
				
			return false;
		});
			
		$(__uploadScanForm).click(function()
		{	
			__scansUploaderUiWindow.open();
			$("input#scan").attr("data-type", scanType);
		});
	});
});