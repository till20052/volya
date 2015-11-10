$(document).ready(function(){
	
	var __section = $("body>section");
	
	// selectionUiFrame
	var __selectionUiFrame = (function(element){
		var __this = new Object(),
			__headerUiBox,
			__sectionUiBox;
		
		$(element).each(function(){
			if($(this).hasClass("header"))
				__headerUiBox = $(this);
			else if($(this).hasClass("section"))
				__sectionUiBox = $(this);
		});
		
		$($("input[name='type']", __sectionUiBox).click(function(){
			var __tbody = $($(this).parents("tbody").eq(0)),
				__td = $($(this).parents("td").eq(0));
			
			$(">tr>td>div:first-child", __tbody).removeClass("selected");
			$("a", $(">tr>td>div:first-child", __tbody)).hide();
			$(">tr>td>div:last-child", __tbody).css("opacity", .5);
			
			$(">div:first-child", __td).addClass("selected");
			$("a", $(">div:first-child", __td)).show();
			$(">div:last-child", __td).css("opacity", 1);
		}).eq(0)).click();
		
		$("a", __sectionUiBox).click(function(){
			__this.hide();
			
			switch($(this).attr("data-uiFrameId")){
				case "subscriber":
					__subscriberUiFrame.show();
					break;
					
				case "supporter":
					__supporterUiFrame.show();
					break;
					
				case "candidate":
					__candidateUiFrame.show();
					break;
			}
		});
		
		__this["show"] = (function(){
			([__headerUiBox, __sectionUiBox]).forEach(function(element){
				$(element).show();
			});
		});
		
		__this["hide"] = (function(){
			([__headerUiBox, __sectionUiBox]).forEach(function(element){
				$(element).hide();
			});
		});
		
		return __this;
	}($(">div[data-uiFrame='selection']", __section)));
	
	// subscriberUiFrame
	var __subscriberUiFrame = (function(element){
		var __this = new Object(),
			__headerUiBox,
			__sectionUiBox;
		
		$(element).each(function(){
			if($(this).hasClass("header"))
				__headerUiBox = $(this);
			else if($(this).hasClass("section"))
				__sectionUiBox = $(this);
		});
		
		__this["show"] = (function(){
			([__headerUiBox, __sectionUiBox]).forEach(function(element){
				$(element).show();
			});
		});
		
		__this["hide"] = (function(){
			([__headerUiBox, __sectionUiBox]).forEach(function(element){
				$(element).hide();
			});
		});
		
		$("div[data-uiError]", __sectionUiBox).hide();
		
		$("a#back", __headerUiBox).click(function(){
			__this.hide();
			__selectionUiFrame.show();
		});
		
		$("a#submit", __sectionUiBox).click(function(){
			var __data = ({
				type: 1,
				name: $("input#name", __sectionUiBox).val(),
				email: $("input#email", __sectionUiBox).val()
			});
			
			$("div[data-uiError]", __sectionUiBox).hide();
			
			for(var __field in __data){
				if(__data[__field] != "")
					continue;
				
				$("div[data-uiError='not_all_fields_are_filled']", __sectionUiBox).show();
				return;
			}
			
			$.post("/profile/registration/j_submit", __data, function(response){
				if(response.success){
					([__headerUiBox, __sectionUiBox]).forEach(function(element){
						$(">div", element).hide();
						$(">div[data-uiBox='success']", element).show();
					});
					$("span[data-uiText='email']", __headerUiBox).html(__data.email);
					return;
				}
				
				var __textErr;
				if(typeof response.errors != "undefined"){
					for(var __i in response.errors){
						var __error = response.errors[__i];
						switch(__error){
							case "email_has_not_correct_value":
								$("input#email", __sectionUiBox).css("borderColor", "red");
								break;
								
							case "name_should_not_be_empty":
								$("input#name", __sectionUiBox).css("borderColor", "red");
								break;
								
							case "user_already_exists":
								$("input#email", __sectionUiBox).css("borderColor", "red");
								__textErr = $("div[data-uiError='user_already_exists']", __sectionUiBox);
								break;
						}
						setTimeout(function(){
							$("input[type='text']", __sectionUiBox).css("borderColor", "");
						}, 4096);
					}
				}
				
				if(typeof __textErr == "object")
					$(__textErr).show();
				else
					$("div[data-uiError='not_correct_values_in_fields']", __sectionUiBox).show();
			}, "json");
		});
		
		return __this;
	}($(">div[data-uiFrame='subscriber']", __section)));
	
	// supporterUiFrame
	var __supporterUiFrame = (function(element){
		var __this = new Object(),
			__headerUiBox,
			__sectionUiBox;
		
		$(element).each(function(){
			if($(this).hasClass("header"))
				__headerUiBox = $(this);
			else if($(this).hasClass("section"))
				__sectionUiBox = $(this);
		});
		
		$("div[data-uiError]", __sectionUiBox).hide();
		
		$("a#back", __headerUiBox).click(function(){
			__this.hide();
			__selectionUiFrame.show();
		});
		
		var __uiForm = (new Form($("form", __sectionUiBox))).beforeSend(function(){
			$("div[data-uiError]", __sectionUiBox).hide();
			
			var __phoneArr = __phoneUiTextBox.value().match(/([0-9])/g);
			if(__phoneArr == null)
				__phoneArr = new Array();
			
			__uiForm.data({
				type: 50,
				name: ([$("input#first_name", __uiForm.element).val(),
					$("input#last_name", __uiForm.element).val(),
					$("input#middle_name", __uiForm.element).val()]).join(" "),
				birthday_year: __birthdayYearUiSelect.value(),
				sex: __sexUiSelect.value(),
				geo_koatuu_code: __geoKoatuuCodeUiAutoComplete.value(),
				education: __educationUiSelect.value(),
				work_scope: __workScopeUiSelect.value(),
				professional_status: __professionalStatusUiSelect.value(),
				phone: "+38"+__phoneArr.join(""),
				volunteer_groups: __volunteerGroups.value()
			});
		}).afterSend(function(response){
			if(response.success){
				__this.hide();
				__confirmationUiFrame.show({
					email: $("input#email", __uiForm.element).val()
				});
				return;
			}
			
			if(typeof response.errors != "object")
				return;
			
			var __showError = "",
				__markedElement = new Array();
			
			if($.inArray("email_has_not_correct_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($("input#email", __uiForm.element));
			}
			
			if($.inArray("invalid_password", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($("input#password, input#confirm_password", __uiForm.element));
			}
			
			if($.inArray("name_should_not_be_empty", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				$("input#first_name, input#last_name, input#middle_name", __uiForm.element).each(function(){
					if($(this).val() != "")
						return;
					
					__markedElement.push($(this));
				});
			}
			
			if($.inArray("phone_has_not_correct_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($("div.tx-phone", __uiForm.element));
			}
			
			if($.inArray("incorrect_birthday_year_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($(">span", __birthdayYearUiSelect.wrapper));
			}
			
			if($.inArray("incorrect_education_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($(">span", __educationUiSelect.wrapper));
			}
			
			if($.inArray("incorrect_work_scope_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($(">span", __workScopeUiSelect.wrapper));
			}
			
			if($.inArray("incorrect_professional_status_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($(">span", __professionalStatusUiSelect.wrapper));
			}
			
			if($.inArray("incorrect_geo_code_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($(__geoKoatuuCodeUiAutoComplete.sender.wrapper));
			}
			
			if($.inArray("user_already_exists", response.errors) != -1){
				__showError = "user_already_exists";
				__markedElement = [$("input#email", __uiForm.element)];
			}
			
			$("div[data-uiError='"+__showError+"']", __sectionUiBox).show();
			
			if(__markedElement != null)
				__markedElement.forEach(function(element){
					$(element).css("borderColor", "red");
				});
				setTimeout(function(){
					__markedElement.forEach(function(element){
						$(element).css("borderColor", "");
					});
				}, 5000);
		});
		
		var __sexUiSelect = $("select[data-ui='sex']", __uiForm.element).kendoDropDownList({
			value: 0
		}).data("kendoDropDownList");
		
		var __birthdayYearUiSelect = $("select[data-ui='birthday_year']", __uiForm.element).kendoDropDownList({
			value: 0
		}).data("kendoDropDownList");
		
		var __phoneUiTextBox = $("input[data-ui='phone']", __uiForm.element).kendoMaskedTextBox({
			mask: "000 000 00 00",
			promptChar: " ",
			value: ""
		}).data("kendoMaskedTextBox");
		
		var __geoKoatuuCodeUiAutoComplete = (function(element){
			var __value = "",
				__sender = $(element).kendoAutoComplete({
				dataTextField: "title",
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
									options.success(eval("("+response.responseText+")").list);
								})
							});
						})
					})
				}),
				select: (function(e){
					__value = $(">div", e.item).attr("data-id");
				})
			}).data("kendoAutoComplete");
			
			return ({
				sender: __sender,
				value: (function(){
					return __value;
				})
			});
		}($("input[data-ui='geo_koatuu_code']", __uiForm.element)));
		
		var __educationUiSelect = $("select[data-ui='education']", __uiForm.element).kendoDropDownList({
			value: 0
		}).data("kendoDropDownList");
		
		var __workScopeUiSelect = $("select[data-ui='work_scope']", __uiForm.element).kendoDropDownList({
			value: 0
		}).data("kendoDropDownList");
		
		var __professionalStatusUiSelect = $("select[data-ui='professional_status']", __uiForm.element).kendoDropDownList({
			value: 0
		}).data("kendoDropDownList");
		
		var __volunteerGroups = (function(element){
			var __firstDiv = $(">div:first", element),
				__secondDiv = $(">div:last", element);
			
			$("input[data-ui='i_want_to_be_a_volunteer']", __firstDiv).change(function(){
				var __state = $(this).attr("checked");
				
				$("input[type='checkbox']:checked", __secondDiv).attr("checked", false);
				
				if(__state)
					$(__secondDiv).show();
				else
					$(__secondDiv).hide();
			}).change();
			
			return ({
				element: element,
				value: (function(){
					return $.map($("input[type='checkbox']:checked", __secondDiv), function(checkbox){
						return $(checkbox).val();
					});
				})
			});
		}($("div[data-uiBox='volunteer_groups']", __uiForm.element)));
		
		$("a#submit", __uiForm.element).click(function(){
			__uiForm.send();
		});
		
		__this["show"] = (function(){
			([__headerUiBox, __sectionUiBox]).forEach(function(element){
				$(element).show();
			});
		});
		
		__this["hide"] = (function(){
			([__headerUiBox, __sectionUiBox]).forEach(function(element){
				$(element).hide();
			});
		});
		
		return __this;
	}($(">div[data-uiFrame='supporter']", __section)));
	
	// candidateUiFrame
	var __candidateUiFrame = (function(element){
		var __this = new Object(),
			__headerUiBox,
			__sectionUiBox;
		
		$(element).each(function(){
			if($(this).hasClass("header"))
				__headerUiBox = $(this);
			else if($(this).hasClass("section"))
				__sectionUiBox = $(this);
		});
		
		$("div[data-uiError]", __sectionUiBox).hide();
		
		$("a#back", __headerUiBox).click(function(){
			__this.hide();
			__selectionUiFrame.show();
		});
		
		var __uiForm = (new Form($("form", __sectionUiBox))).beforeSend(function(){
			$("div[data-uiError]", __sectionUiBox).hide();
			
			var __phoneArr = __phoneUiTextBox.value().match(/([0-9])/g);
			if(__phoneArr == null)
				__phoneArr = new Array();
			
			__uiForm.data({
				type: 99,
				name: ([$("input#first_name", __uiForm.element).val(),
					$("input#last_name", __uiForm.element).val(),
					$("input#middle_name", __uiForm.element).val()]).join(" "),
				birthday_month: __birthdayMonthUiSelect.value(),
				birthday_year: __birthdayYearUiSelect.value(),
				sex: __sexUiSelect.value(),
				geo_koatuu_code: __geoKoatuuCodeUiAutoComplete.value(),
				education: __educationUiSelect.value(),
				professional_status: __professionalStatusUiSelect.value(),
				phone: "+38"+__phoneArr.join(""),
				statement: __documentsUiUploader.statement.value(),
				declaration: __documentsUiUploader.declaration.value()
			});
		}).afterSend(function(response){
			if(response.success){
				__this.hide();
				__confirmationUiFrame.show({
					email: $("input#email", __uiForm.element).val()
				});
				return;
			}
			
			if(typeof response.errors != "object")
				return;
			
			var __showError = "",
				__markedElement = new Array();
			
			if(
					$.inArray("need_a_statement", response.errors) != -1
					|| $.inArray("need_a_declaration", response.errors) != -1
			){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($("div[data-uiBox='documents']", __uiForm.element));
			}
			
			if($.inArray("email_has_not_correct_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($("input#email", __uiForm.element));
			}
			
			if($.inArray("invalid_password", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($("input#password, input#confirm_password", __uiForm.element));
			}
			
			if($.inArray("name_should_not_be_empty", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				$("input#first_name, input#last_name, input#middle_name", __uiForm.element).each(function(){
					if($(this).val() != "")
						return;
					
					__markedElement.push($(this));
				});
			}
			
			if($.inArray("phone_has_not_correct_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($("div.tx-phone", __uiForm.element));
			}
			
			if($.inArray("incorrect_birthday_day_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($("input#birthday_day", __uiForm.element));
			}
			
			if($.inArray("incorrect_birthday_month_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($(">span", __birthdayMonthUiSelect.wrapper));
			}
			
			if($.inArray("incorrect_birthday_year_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($(">span", __birthdayYearUiSelect.wrapper));
			}
			
			if($.inArray("incorrect_education_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($(">span", __educationUiSelect.wrapper));
			}
			
			if($.inArray("incorrect_professional_status_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($(">span", __professionalStatusUiSelect.wrapper));
			}
			
			if($.inArray("jobs_should_be_not_empty", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($("textarea#jobs", __uiForm.element));
			}
			
			if($.inArray("social_activity_should_be_not_empty", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($("textarea#social_activity", __uiForm.element));
			}
			
			if($.inArray("political_activity_should_be_not_empty", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($("textarea#political_activity", __uiForm.element));
			}
			
			if($.inArray("incorrect_geo_code_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($(__geoKoatuuCodeUiAutoComplete.sender.wrapper));
			}
			
			if($.inArray("incorrect_address_value", response.errors) != -1){
				__showError = "not_correct_values_in_fields";
				__markedElement.push($("input#address", __uiForm.element));
			}
			
			if($.inArray("user_already_exists", response.errors) != -1){
				__showError = "user_already_exists";
				__markedElement = [$("input#email", __uiForm.element)];
			}
			
			$("div[data-uiError='"+__showError+"']", __sectionUiBox).show();
			
			if(__markedElement != null)
				__markedElement.forEach(function(element){
					$(element).css("borderColor", "red");
				});
				setTimeout(function(){
					__markedElement.forEach(function(element){
						$(element).css("borderColor", "");
					});
				}, 5000);
		});
		
		var __documentsUiUploader = new Object();
		([
			$("input[name='statement']", __uiForm.element),
			$("input[name='declaration']", __uiForm.element)
		]).forEach(function(element){
			__documentsUiUploader[$(element).attr("name")] = (function(element){
				var __parent = $($(element).parents("div").eq(1));
				
				$(element).css({
					width: $(element).next("a").width() + "px",
					height: $(element).next("a").height() + "px",
					opacity: 0
				}).hover(function(){
					$(element).next("a").css("textDecoration", "underline");
				}, function(){
					$(element).next("a").css("textDecoration", "");
				}).fileupload({
					dataType: "json",
					url: "/s/storage/j_save?extension[]=jpg&extension[]=png&extension[]=pdf",
					sequentialUploads: true,
					done: (function(event, data){
						if( ! data.result.files[0]){
							alert("Файл, який ви завантажуєте, не підтримується");
							return;
						}
						$(__parent).attr("data-hash", data.result.files[0]);
						$(">div:first", __parent).hide();
						$(">div:last", __parent).show();
						$("span[data-label='name']", $(">div:last", __parent)).html(data.files[0].name);
					})
				});
				
				$("a[data-action='remove']", $(">div:last", __parent)).click(function(){
					$(__parent).attr("data-hash", "");
					$(">div:first", __parent).show();
					$(">div:last", __parent).hide();
				});
				
				$(">div:last", __parent).hide();
				
				return ({
					value: (function(){
						return (typeof $(__parent).attr("data-hash") != "undefined" ? $(__parent).attr("data-hash") : "");
					})
				});
			}(element));
		});
		
		var __sexUiSelect = $("select[data-ui='sex']", __uiForm.element).kendoDropDownList({
			value: 0
		}).data("kendoDropDownList");
		
		var __birthdayMonthUiSelect = $("select[data-ui='birthday_month']", __uiForm.element).kendoDropDownList({
			dataValueField: "id",
			dataTextField: "text",
			value: 0,
			dataSource: ({
				data: (function(){
					var __list = [{id: 0, text: "\u2014"}];
					
					for(var __i = 0; __i < 12; __i++)
						__list.push({
							id: (__i + 1),
							text: kendo.toString(new Date(0, __i, 1), "MMMM")
						});
					
					return __list;
				}())
			})
		}).data("kendoDropDownList");
		
		var __birthdayYearUiSelect = $("select[data-ui='birthday_year']", __uiForm.element).kendoDropDownList({
			value: 0
		}).data("kendoDropDownList");
		
		var __phoneUiTextBox = $("input[data-ui='phone']", __uiForm.element).kendoMaskedTextBox({
			mask: "000 000 00 00",
			promptChar: " ",
			value: ""
		}).data("kendoMaskedTextBox");
		
		var __geoKoatuuCodeUiAutoComplete = (function(element){
			var __value = "",
				__sender = $(element).kendoAutoComplete({
				dataTextField: "title",
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
									options.success(eval("("+response.responseText+")").list);
								})
							});
						})
					})
				}),
				select: (function(e){
					__value = $(">div", e.item).attr("data-id");
				})
			}).data("kendoAutoComplete");
			
			return ({
				sender: __sender,
				value: (function(){
					return __value;
				})
			});
		}($("input[data-ui='geo_koatuu_code']", __uiForm.element)));
		
		var __educationUiSelect = $("select[data-ui='education']", __uiForm.element).kendoDropDownList({
			value: 0
		}).data("kendoDropDownList");
		
		var __professionalStatusUiSelect = $("select[data-ui='professional_status']", __uiForm.element).kendoDropDownList({
			value: 0
		}).data("kendoDropDownList");
		
		$("a#submit", __uiForm.element).click(function(){
			__uiForm.send();
		});
		
		__this["show"] = (function(){
			([__headerUiBox, __sectionUiBox]).forEach(function(element){
				$(element).show();
			});
		});
		
		__this["hide"] = (function(){
			([__headerUiBox, __sectionUiBox]).forEach(function(element){
				$(element).hide();
			});
		});
		
		return __this;
	}($(">div[data-uiFrame='candidate']", __section)));
	
	// confirmationUiFrame
	var __confirmationUiFrame = (function(element){
		var __this = new Object(),
			__headerUiBox,
			__sectionUiBox;
		
		$(element).each(function(){
			if($(this).hasClass("header"))
				__headerUiBox = $(this);
			else if($(this).hasClass("section"))
				__sectionUiBox = $(this);
		});
		
		$(">div:nth-child(2), >div:last", $("div[data-uiBox='reply_email']", element)).hide();
		
		$("a[data-action='show_form']", element).click(function(){
			$(">div:nth-child(2), >div:last", $("div[data-uiBox='reply_email']", element)).show();
		});
		
		__this["show"] = (function(data){
			([__headerUiBox, __sectionUiBox]).forEach(function(element){
				$(element).show();
				
				if(typeof data == "undefined")
					return;
				
				if(typeof data.email != "undefined")
					$("span[data-label='email']", element).html(data.email);
			});
		});
		
		__this["hide"] = (function(){
			([__headerUiBox, __sectionUiBox]).forEach(function(element){
				$(element).hide();
			});
		});
		
		return __this;
	}($(">div[data-uiFrame='confirmation']", __section)));
	
	__selectionUiFrame.show();
	__subscriberUiFrame.hide();
	__supporterUiFrame.hide();
	__candidateUiFrame.hide();
	__confirmationUiFrame.hide();
	
});