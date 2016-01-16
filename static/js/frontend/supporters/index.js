$(document).ready(function(){

	var __section = $("body>section>div>div");
	var __uiForm = (new Form($("form", __section))).beforeSend(function(){
		var __data = {
			phone: $("input[ui='phone']", __uiForm.element).val().match(/([0-9]+)/ig).join(""),
		};

		__uiForm.data(__data);
	}).afterSend(function(response){
		if( ! response.success){
			$(".msg_err").show();
			return;
		}

		$(".msg_ok").show();
		$(".form").hide();
	});

	var __data = (function()
	{
		var __day = [],
			__month = [],
			__year = [],
			__dateNow = new Date();

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

		return {
			day: __day,
			month: __month,
			year: __year,
			config: ({
				dataValueField: "id",
				dataTextField: "text",
				value: 1
			})
		};
	})();

	$("select#bday").kendoDropDownList($.extend({}, __data.config, {
		dataSource: ({
			data: __data.day
		})
	}));

	$("select#bmonth").kendoDropDownList($.extend({}, __data.config, {
		dataSource: ({
			data: __data.month
		})
	}));

	$("select#byear").kendoDropDownList($.extend({}, __data.config, {
		dataSource: ({
			data: __data.year
		})
	}));

	$("input[ui='phone']", __section).kendoMaskedTextBox({
		mask: "+380 ( 00 ) 000 00 00",
		promptChar: "_",
		value: "+380"
	});

	$("a[data-action='send']", __section).click(function(){
		__uiForm.send();
	});

	$("a[data-action='cancel']", __section).click(function(){

	});
});