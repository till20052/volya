$(document).ready(function(){
	
	var __section = $("body>section>div.section");
	
	(function(element){
		$("td:nth-child(odd)", element).css({
			cursor: "pointer"
		}).click(function(){
			if( ! ($("a[data-uiFrame]", this).length > 0))
				return;
			
			$(">tbody>tr>td>div", element).removeClass("selected");
			$(">div", this).addClass("selected");
			$("div[data-uiFrame]", __section).hide();
			$("div[data-uiFrame='"+$("a", this).attr("data-uiFrame")+"']", __section).show();
		});
		
		var __frame = window.location.hash.substring(1);
		if(__frame != "" && $("a[data-uiFrame='"+__frame+"']", element).length > 0)
			$("a[data-uiFrame='"+__frame+"']", element).click();
		else
			$($("a", element).eq(0)).click();
	})($("table[data-ui='switch']", __section));
	
	([
		$("div[data-uiFrame='volunteers']", __section),
		$("div[data-uiFrame='members']", __section),
		$("div[data-uiFrame='observers']", __section)
	]).forEach(function(elements){
		
		(function(elements){
			var __uiForm = (new Form($("form", elements))).beforeSend(function(){
				var __phoneArr = __phoneUiTextBox.value().match(/([0-9])/g);
				if(__phoneArr == null)
					__phoneArr = new Array();

				__uiForm.data({
					level: 1,
					helper_type: $(__uiForm.element).attr("data-helperType"),
					phone: "+38"+__phoneArr.join(""),
					geo_koatuu_code: __localityUiAutoComplete.value(),
					county_number: __countyNumbersUiSelect.value(),
					polling_place_number: __pollingPlacesUiSelect.value(),
					i_want_to_be_a_helper: 1
				});
			}).afterSend(function(response){
				if(response.success){
					$(">div[data-uiBox='form']", __uiForm.element).hide();
					$(">div[data-uiBox='success']", __uiForm.element).show();
					return;
				}

				if(typeof response.errors == "undefined" || ! (response.errors.length > 0))
					return;

				var __err = response.errors,
					__elements = new Array();

				if($.inArray("name_should_not_be_empty", __err) != -1)
					__elements.push($("input#name", __uiForm.element));

				if($.inArray("email_has_not_correct_value", __err) != -1)
					__elements.push($("input#email", __uiForm.element));

				if($.inArray("set_locality", __err) != -1)
					__elements.push($(__localityUiAutoComplete.element));

				if(__elements.length > 0){
					__elements.forEach(function(element){
						$(element).css("borderColor", "red");
					});
					setTimeout(function(){
						__elements.forEach(function(element){
							$(element).css("borderColor", "");
						});
					}, 2048);
				}
			});

			var __phoneUiTextBox = $("input[data-ui='phone']", __uiForm.element).kendoMaskedTextBox({
				mask: "000 000 00 00",
				promptChar: " ",
				value: ""
			}).data("kendoMaskedTextBox");

			var __localityUiAutoComplete = (function(element){
				return $.extend($(element).attr({
					"data-value": 0
				}).kendoAutoComplete({
					dataValueField: "id",
					dataTextField: "title",
					filter: "contains",
					minLength: 3,
					template: $(">script#template", $($(element).parents("div").eq(0))).html(),
					dataSource: ({
						serverFiltering: true,
						transport: ({
							read: (function(options){
								$.ajax({
									url: "/api/geo/j_find_cities?q="+options.data.filter.filters[0].value,
									dataType: "jsonp",
									complete: (function(response){
										options.success(eval("("+response.responseText+")").list);
									})
								});
							})
						})
					}),
					select: (function(e){
						$(element).attr({
							"data-value": $(">div", e.item).attr("data-id")
						});
					}),
					change: (function(){
						var __v = $(element).attr("data-value");

						__countyNumbersUiSelect.enable(false);
						$(__countyNumbersUiSelect.wrapper).css("opacity", .3);

						if( ! (__v > 0)){
							__countyNumbersUiSelect.dataSource.data([{id: 0, text: "\u2014"}]);
							__countyNumbersUiSelect.options.change({
								sender: __countyNumbersUiSelect
							});
							return;
						}

						$.post("/api/election/j_get_county_numbers_by_region", {
							geo_koatuu_code: __v
						}, function(response){
							if( ! response.success)
								return;

							__countyNumbersUiSelect.enable(true);
							$(__countyNumbersUiSelect.wrapper).css("opacity", 1);
							__countyNumbersUiSelect.dataSource.data(([{id: 0, text: "\u2014"}]).concat(response.list));
							__countyNumbersUiSelect.options.change({
								sender: __countyNumbersUiSelect
							});
						}, "json");
					})
				}).data("kendoAutoComplete"), {
					value: (function(){
						return $(element).attr("data-value");
					})
				});
			}($("input[data-ui='locality']", __uiForm.element)));

			var __countyNumbersUiSelect = $("select[data-ui='county_numbers']", __uiForm.element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "text",
				change: (function(e){
					__pollingPlacesUiSelect.enable(false);
					$(__pollingPlacesUiSelect.wrapper).css("opacity", .3);

					if( ! (e.sender.value() > 0)){
						__pollingPlacesUiSelect.dataSource.data([{id: 0, text: "\u2014"}]);
						return;
					}

					$.post("/api/election/j_get_polling_places_by_county_number", {
						county_number: e.sender.value()
					}, function(response){
						if( ! response.success)
							return;

						__pollingPlacesUiSelect.enable(true);
						$(__pollingPlacesUiSelect.wrapper).css("opacity", 1);
						__pollingPlacesUiSelect.dataSource.data(([{id: 0, text: "\u2014"}]).concat(response.list));
					}, "json");
				})
			}).data("kendoDropDownList");

			var __pollingPlacesUiSelect = (function(element){
				return $(element).kendoDropDownList({
					dataValueField: "id",
					dataTextField: "text",
					template: $(">script#template", element).html(),
					valueTemplate: $(">script#valueTemplate", element).html()
				}).data("kendoDropDownList");
			})($("select[data-ui='polling_places']", __uiForm.element));

			__localityUiAutoComplete.options.change();

			$("a[data-action='submit']", __uiForm.element).click(function(){
				__uiForm.send();
			});

		})(elements);
		
	});
	
});