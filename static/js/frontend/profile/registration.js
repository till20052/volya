$(document).ready(function()
{
	var __section = $("body>section"),
		__timeout;
	
	var __data = (function()
	{
		var __day = [],
			__month = [],
			__year = [],
			__dateNow = new Date(),
			__buffer = eval($(">script#data", __section).text());
		
		for(var __i = 0; __i < 100; __i++)
		{
			if(__i < 31)
				__day.push({
					id: (__i + 1),
					text: (__i + 1)
				});

			if(__i < 12)
				__month.push({
					id: (__i + 1),
					text: kendo.toString(new Date(1, __i, 1), "MMMM")
				});
			
			__year.push({
				id: __dateNow.getFullYear() - (__i + 15),
				text: __dateNow.getFullYear() - (__i + 15)
			});
		}
		
		return $.extend({
			day: __day,
			month: __month,
			year: __year,
			config: ({
				dataValueField: "id",
				dataTextField: "text",
				value: 1
			})
		}, __buffer);
	})();
	
	var __requirementsUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='profile.registration.requirements']"));
		
		$("a#yes", __uiWindow.element).click(function()
		{
			__uiWindow.close();
		});
		
		$("a#no", __uiWindow.element).click(function()
		{
			$("input[type='radio'][value='1']", __uiForm.element).attr("checked", 1);
			__uiWindow.close();
		});
		
		return __uiWindow;
	})();
	
	var __uiForm = (new Form($("form", __section))).beforeSend(function()
	{
		$("div.alert", __uiForm.element).hide();
		
		__uiForm.data({
			region_id: __regionUiSelect.value(),
			region_name: __regionUiSelect.text(),
			area_id: __areaUiSelect.value(),
			area_name: __areaUiSelect.text(),
			city_id: __cityUiSelect.value(),
			city_name: __cityUiSelect.text(),
			phone: $("input[ui='phone']", __uiForm.element).val().match(/([0-9]+)/ig).join(""),
			volunteer_groups: $.map($("input[ui='volunteer_group']:checked", __uiForm.element), function(item)
			{
				return $(item).val();
			}),
			type: $("input[name='type']:checked", __uiForm.element).val()
		});
	}).afterSend(function(response)
	{
		if( ! response.success)
		{
			$(window).scrollTop(0);
			
			var __error = response.error[0].split(":");
			
			switch(__error[0])
			{
				case "incorrect":
				case "value_cannot_be_empty":
					$("div#required_fields", __uiForm.element).show();
					$("input#"+__error[1], __uiForm.element).css("borderColor", "red");
					if(__error[1] == "password")
						$("input#confirm_password", __uiForm.element).css("borderColor", "red");
					
					if(__error[1] == "education" || __error[1] == "jobs" || __error[1] == "social_activity" || __error[1] == "political_activity")
						$("textarea#"+__error[1], __uiForm.element).css("border", "1px solid red");
					break;
				
				case "user_already_exists":
					$("div#user_already_exists", __uiForm.element).show();
					$("input#email", __uiForm.element).css("borderColor", "red");
					break;
					
				case "value_must_be_greater_than_zero":
					$("div#required_fields", __uiForm.element).show();
					$("input#"+__error[1], __uiForm.element).css("borderColor", "red");
					if(__error[1] == "region_id" || __error[1] == "area_id" || __error[1] == "city_id" || __error[1] == "professional_status" || __error[1] == "education_level")
						$("select#"+__error[1], __uiForm.element).prev("span").css("border", "1px solid red");
					
					if(__error[1] == "was_allowed_to_use_pd")
						$("input#"+__error[1], __uiForm.element).parent("label").css("color", "red");
					break;
					
				case "scan_cannot_be_empty":
					$("div#upload"+__error[1], __uiForm.element).css("border", "1px solid red");
					break
			}
			
			setTimeout(function()
			{
				$("input", __uiForm.element).css("borderColor", "").parent("label").css("color", "");
				$("select", __uiForm.element).prev("span").css("borderColor", "");
				$("textarea", __uiForm.element).css("borderColor", "");
				$("div.scanPreview", __uiForm.element).css("border", "");
			}, 2500);
			
			return;
		}
		
		$("div[ui-frame='first']", __section).hide();
		$("div[ui-frame='second']", __section).show();
	});
	
	$("select#birthday_day", __uiForm.element).kendoDropDownList($.extend({}, __data.config, {
		dataSource: ({
			data: __data.day
		})
	}));
	
	$("select#birthday_month", __uiForm.element).kendoDropDownList($.extend({}, __data.config, {
		dataSource: ({
			data: __data.month
		})
	}));
	
	$("select#birthday_year", __uiForm.element).kendoDropDownList($.extend({}, __data.config, {
		dataSource: ({
			data: __data.year
		})
	}));
	
	$("select#education_level", __uiForm.element).kendoDropDownList({
		value: 0
	});
	
	$("select#professional_status", __uiForm.element).kendoDropDownList({
		value: 0
	});
	
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
				$("div#upload"+__type, __uiForm.element).css("backgroundImage", "url('/s/img/thumb/ag/"+__file+"')");
				$("input[name='scan["+__type+"]']", __uiForm.element).val(__file);
				
				__uiWindow.close();
			}),
			complete: (function(e){
				$(">ul>li span.k-delete", e.sender.wrapper).click();
			})
		}).data("kendoUpload");
		__uiWindow.ui("fileUiInput", __fileUiInput);
	
		return __uiWindow;
	})();
	
	var scansTypes = new Array(
			"ApplicationForMembership",
			"LustrationDeclaration"
		);
	
	scansTypes.forEach(function( scanType ){
		
		var __uploadScanForm = $("div#upload"+scanType, __uiForm.element);
		
		$(__uploadScanForm).hover(function(){
			$(".scanMenu", $(this) ).slideDown();
		}, function(){
			$(".scanMenu", $(this) ).stop().slideUp();
		});
		
		$("a", $(__uploadScanForm)).click(function(){
			$("div.delete", $(__uploadScanForm)).hide();
			$(__uploadScanForm).css("backgroundImage", "url('/img/no_image.jpg')");
			$("input", __uploadScanForm).val("");
			return false;
		});
			
		$(__uploadScanForm).click(function()
		{
			__scansUploaderUiWindow.open();
			$("input#scan").attr("data-type", scanType);
		});
	});
	
	var __regionUiSelect = $("select[data-ui='rid']", __uiForm.element).kendoDropDownList({
		value: 0,
		change: function(event){
			var __regionId = event.sender.value();

			__areaUiSelect.dataSource.data([{id: 0, title: "&mdash;"}]);
			__areaUiSelect.value(0);

			if( ! (__regionId > 0))
			{
				$("tr[data-ui='area']").hide();
				$("tr[data-ui='area']").prev("tr").hide();
				__areaUiSelect.options.change({sender: __areaUiSelect});
				return;
			}

			$("tr[data-ui='area']").prev("tr").show();
			$("tr[data-ui='area']").show();
			$("div[data-uiCover='area']").show();

			$.post("/api/geo/j_get_areas", {
				country_id: 2,
				region_id: __regionId
			}, function(response){
				if( ! response.success)
					return;

				$("div[data-uiCover='area']").hide();

				__areaUiSelect.dataSource.data(([{id: 0, title: "&mdash;"}]).concat(response.areas));
			}, "json");
		}
	}).data("kendoDropDownList");

	var __areaUiSelect = (function(){
		var __element = $("select[data-ui='area']", __uiForm.element),
			__valueTemplate = kendo.template($(">script#valueTemplate", __element).text()),
			__template = kendo.template($(">script#template", __element).text());

		return $(__element).kendoDropDownList({
			dataValueField: "id",
			dataTextField: "title",
			dataSource: {
				scheme: {model: {id: "id"}}
			},
			valueTemplate: __valueTemplate,
			template: __template,
			change: function(event){
				var __areaId = event.sender.value();

				__cityUiSelect.dataSource.data([{id: 0, title: "-"}]);
				__cityUiSelect.value(0);

				if( ! (__areaId > 0))
				{
					$("tr[data-ui='city']").hide();
					$("tr[data-ui='city']").prev("tr").hide();
					return;
				}

				$("tr[data-ui='city']").show();
				$("tr[data-ui='city']").prev("tr").show();
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
				}, "json");
			}
		}).data("kendoDropDownList");
	}());

	var __cityUiSelect = (function(){
		var __element = $("select[data-ui='city']", __uiForm.element),
			__template = kendo.template($(">script#template", __element).text());

		return $(__element).kendoDropDownList({
			dataValueField: "id",
			dataTextField: "title",
			dataSource: {
				scheme: {model: {id: "id"}}
			},
			template: __template
		}).data("kendoDropDownList");
	}());
	
	__regionUiSelect.options.change({sender: __regionUiSelect});
	
	$("tr[ui-group='volonteer']", __uiForm.element).show();
	$("tr[ui-group='candidate']", __uiForm.element).hide();
	$("input#volonteer", __uiForm.element).click(function(){
		$("tr[ui-group='volonteer']", __uiForm.element).show();
		$("tr[ui-group='candidate']", __uiForm.element).hide();
	});
	
	$("input#candidate", __uiForm.element).click(function(){
		$("tr[ui-group='candidate']", __uiForm.element).show();
		$("tr[ui-group='volonteer']", __uiForm.element).hide();
	});
	
	$("input[ui='phone']", __uiForm.element).kendoMaskedTextBox({
		mask: "+380 ( 00 ) 000 00 00",
		promptChar: "_",
		value: "+380"
	});
	
	$("input[type='radio'][value='3']", __uiForm.element).change(function()
	{
		__requirementsUiWindow.open();
	});
	
	$("select#employment_scope", __uiForm.element).kendoDropDownList($.extend({}, __data.config, {
		dataTextField: "name",
		value: 1,
		dataSource: ({
			data: __data.employment_scopes
		})
	}));
	
	$("a#submit", __uiForm.element).click(function()
	{
		__uiForm.send();
	});
});