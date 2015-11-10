$(document).ready(function(){
	
	var __section = $("body>section>div.section"),
		__toolbarUiBox = $(">div>div[data-uiBox='toolbar']", __section);
	
	var __viewerUiWindow = (function(element){
		var __uiWindow = new Window(element);
		
		var __professionalStatus = (function(element){
			var __template = kendo.template($(">script", element).html());
			return ({
				value: (function(id){
					if(id > 0)
						$(element).html(__template({
							id: id
						}));
					else
						$(element).empty();
				})
			});
		}($("span#professional_status", __uiWindow.element)));
		
		var __education = (function(element){
			var __template = kendo.template($(">script", element).html());
			return ({
				value: (function(id){
					if(id > 0)
						$(element).html(__template({
							id: id
						}));
					else
						$(element).empty();
				})
			});
		}($("span#education", __uiWindow.element)));
		
		var __verification = (function(elements){
			var __header,
				__section,
				__typeTemplate;
			
			$(elements).each(function(){
				if($(this).attr("data-uiBox").indexOf("header") != -1)
					__header = $(this);
				if($(this).attr("data-uiBox").indexOf("section") != -1)
					__section = $(this);
			});
			
			__typeTemplate = kendo.template($("div#type>script", __section).html());
			
			var __check = (function(data){
				if(data == null){
					([__header, __section]).forEach(function(element){$(element).hide();});
					return;
				}
				
				([__header, __section]).forEach(function(element){$(element).show();});
				
				$("div#user_verifier-name", __section)
						.html($("<a href=\"/profile/"+data.user_verifier.id+"\" target=\"_blank\" />").html(data.user_verifier.name));
				
				$($("div#decision_number", __section).parents("tr").eq(0)).show();
				$("div#decision_number", __section).html(data.decision_number);
				if(data.type != 10)
					$($("div#decision_number", __section).parents("tr").eq(0)).hide();
				
				$("div#created_at", __section).html(kendo.toString(kendo.parseDate(data.created_at), "dd MMMM yyyy"));
				$("div#type", __section).html(__typeTemplate({type: data.type}));
				$("div#comment", __section).html(data.comment);
			});
			
			return ({
				check: __check
			});
		}($("div[data-uiBox='verification.header'], div[data-uiBox='verification.section']", __uiWindow.element)));
		
		var __nav = (function(element){
			var __data = eval($(">script", element).html());
			
			var __check = (function(verification){
				var __item;
				
				$(">a", element).remove();
				
				__data.forEach(function(item){
					if(
							(typeof item.type != "object" && item.type != verification.type)
							&& ! (typeof item.type == "object" && $.inArray(verification.type, item.type) == -1)
					)
						return;
					
					__item = item;
				});
				
				__item.buttons.forEach(function(button, i){
					var __a = $("<a class=\"v-button v-button-blue\" />").attr({
						"data-userId": verification.user_id,
						"data-type": button.type,
						"data-need": button.need.join(",")
					}).click(__onClick).html(button.html);
					
					if((i + 1) < __item.buttons.length)
						$(__a).addClass("mr5");
					
					$(element).append($(__a));
				});
			});
			
			var __onClick = (function(){
				var __need = $(this).attr("data-need").split(",");
				
				$(__verificationUiWindow.element).attr({
					"data-userId": $(element).attr("data-userId"),
					"data-type": $(this).attr("data-type")
				});
				
				$("div[data-uiBox]", __verificationUiWindow.element).hide();
				__need.forEach(function(id){
					$("div[data-uiBox="+id+"]", __verificationUiWindow.element).show();
				});
				
				$("a#submit", __verificationUiWindow.element).html($(this).html());
				
				__verificationUiWindow.open();
			});
			
			return ({
				element: element,
				check: __check
			});
		}($("nav", __uiWindow.element)));
		
		return $.extend(__uiWindow, {
			getItemAndOpenWindow: (function(id){
				$.post("/admin/register/j_get_member_item", {
					id: id
				}, function(response){
					if( ! response.success)
						return;
					
					var __item = response.item;
					
					$(__uiWindow.element).attr("data-userId", __item.id);
					
					if(__item.avatar != "")
						$("div#avatar", __uiWindow.element).empty()
								.css("backgroundImage", "url('/s/img/thumb/aa/"+__item.avatar+"')");
					else
						$("div#avatar", __uiWindow.element).empty()
								.css("backgroundImage", "")
								.append($("<i class=\"icon-user\" />"));
					
					$("span#name", __uiWindow.element).html(__item.name);
					
					__professionalStatus.value(__item.professional_status);
					
					$("span#birthday", __uiWindow.element).html(kendo.toString(new Date(
							__item.birthday_year,
							(__item.birthday_month - 1),
							__item.birthday_day), "dd MMMM yyyy"));
					
					for(var __type in __item.contacts){
						(function(element, data){
							$(element).empty();
							data.forEach(function(item){
								$(element).append($("<div />").html(item));
							});
						}($("span#"+__type, __uiWindow.element), __item.contacts[__type]));
					}
					
					$("span#locality", __uiWindow.element).html($.map(["region", "area", "title"], function(field){
						if(
								typeof __item.locality == "undefined"
								|| typeof __item.locality[field] == "undefined"
						)
							return null;
						
						return __item.locality[field];
					}).join(" / "));
					$("span#address", __uiWindow.element).html(([__item.street, __item.house_number]).join(", "));
					
					__education.value(__item.education_level);
					
					$("span#jobs", __uiWindow.element).html(__item.jobs);
					$("span#social_activity", __uiWindow.element).html(__item.social_activity);
					$("span#political_activity", __uiWindow.element).html(__item.political_activity);
					
					$("div#documents", __uiWindow.element).empty();
					__item.documents.forEach(function(document){
						$("div#documents", __uiWindow.element).append($("<a class=\"icon\" href=\"/s/storage/"+document+"\" target=\"_blank\"><i class=\"icon-file fs30\" style=\"padding: 0\"></i></a>"));
					});
					
					__verification.check(__item.verification);
					
					$(__nav.element).attr("data-userId", __item.id);
					__nav.check((__item.verification != null) ? __item.verification : ({
						type: 0
					}));
					
					__uiWindow.open();
				}, "json");
			})
		});
	}($("div[ui-window='admin.register.members.viewer']")));
	
	var __verificationUiWindow = (function(element){
		var __uiWindow = (new Window(element)).beforeOpen(function(){
			$("input#decision_number", __uiWindow.element).val("");
			$("textarea#comment", __uiWindow.element).val("");
		});
		
		$("a#submit", __uiWindow.element).click(function(){
			var __type = $(__uiWindow.element).attr("data-type"),
				__dicisionNumber = $("input#decision_number", __uiWindow.element).val(),
				__comment = $("textarea#comment", __uiWindow.element).val();

			if(__type == 10 && __dicisionNumber == ""){
				$("input#decision_number", __uiWindow.element).css("borderColor", "red");
				setTimeout(function(){
					$("input#decision_number", __uiWindow.element).css("borderColor", "");
				}, 2048);
				return;
			}
			
			if(__comment == ""){
				$("textarea#comment", __uiWindow.element).css("borderColor", "red");
				setTimeout(function(){
					$("textarea#comment", __uiWindow.element).css("borderColor", "");
				}, 2048);
				return;
			}
				
			$.post("/admin/register/j_set_member_verification", {
				user_id: $(__uiWindow.element).attr("data-userId"),
				type: $(__uiWindow.element).attr("data-type"),
				decision_number: __dicisionNumber,
				comment: __comment
			}, function(response){
				if( ! response.success)
					return;
				
				__listUiTable.dataSource.get(response.user_id)
						.set("verification", response.verification);
				__listUiTable.dataSource.get(response.user_id)
						.set("type", response.user_type);
				
				__viewerUiWindow.getItemAndOpenWindow(response.user_id);
				
				__uiWindow.close();
			}, "json");
		});
		
		$("a#cancel", __uiWindow.element).click(function(){
			__uiWindow.close();
			__viewerUiWindow.open();
		});
		
		return __uiWindow;
	}($("div[ui-window='admin.register.members.verification']")));
	
	var __exportUiWindow = (function(element){
		var __uiWindow = new Window(element);
		
		return $.extend(__uiWindow, {
			getDocument: (function(url){
				$("div[data-uiBox='content']").empty()
						.append($("<iframe frameborder=\"0\" width=\"100%\" height=\"700px\" src=\"/s/pdf?url="+encodeURIComponent("/admin/register/export_members/c7a455383a2f22f10465dae825acf661"+url)+"\" />"));
				__uiWindow.open();
			})
		});
	}($("div[ui-window='admin.register.export']")));
	
	var __filter = (function(){
		return ({
			prepare: (function(){
				var __params = "?";
				
				if($("input#q", __toolbarUiBox).val() != "")
					__params += "q="+$("input#q", __toolbarUiBox).val()+"&";

				if(typeof __regionUiSelect != "undefined" && __regionUiSelect.value() != 0)
					__params += "region="+__regionUiSelect.value()+"&";

				if(typeof __areaUiSelect != "undefined" && __areaUiSelect.value() != 0)
					__params += "area="+__areaUiSelect.value()+"&";

				if(typeof __cityUiSelect != "undefined" && __cityUiSelect.value() != 0)
					__params += "city="+__cityUiSelect.value()+"&";

				if(typeof __cityAreaUiSelect != "undefined" && __cityAreaUiSelect.value() != 0)
					__params += "cityArea="+__cityAreaUiSelect.value()+"&";
				
				if(__typeUiSelect.value() != 0)
					__params += "type="+__typeUiSelect.value()+"&";
				
				if(__verificationUiSelect != null && __verificationUiSelect.value() != 0)
					__params += "verification="+__verificationUiSelect.value()+"&";
				
				return __params.substr(0, __params.length - 1);
			}),
			apply: (function(){
				window.location.href = "/admin/register/members"+this.prepare();
			})
		});
	}());
	
	$("input#q", __toolbarUiBox).bind("keyup blur", function(event){
		if(event.type == "keyup" && event.which != 13)
			return;
		
		__filter.apply();
	});

	if($("select[data-ui='region']", __toolbarUiBox).length == 1){
		var __regionUiSelect = (function(element){
			return $(element).kendoDropDownList({
				value: $(element).attr("data-value"),
				change: (function(e){
					$("select[data-ui='area']", __toolbarUiBox).val(0);
					$("select[data-ui='cityArea']", __toolbarUiBox).val(0);
					$("select[data-ui='city']", __toolbarUiBox).val(0);
					__filter.apply();
				})
			}).data("kendoDropDownList");
		}($("select[data-ui='region']", __toolbarUiBox)));
	}

	if($("select[data-ui='area']", __toolbarUiBox).length == 1){
		var __areaUiSelect = (function(element){
			return $(element).kendoDropDownList({
				value: $(element).attr("data-value"),
				change: (function(e){
					$("select[data-ui='city']", __toolbarUiBox).val(0);
					$("select[data-ui='cityArea']", __toolbarUiBox).val(0);

					__filter.apply();
				})
			}).data("kendoDropDownList");
		}($("select[data-ui='area']", __toolbarUiBox)));
	}

	if($("select[data-ui='city']", __toolbarUiBox).length == 1){
		var __cityUiSelect = (function(element){
			return $(element).kendoDropDownList({
				value: $(element).attr("data-value"),
				change: (function(e){
					__filter.apply();
				})
			}).data("kendoDropDownList");
		}($("select[data-ui='city']", __toolbarUiBox)));
	}

	if($("select[data-ui='cityArea']", __toolbarUiBox).length == 1){
		var __cityAreaUiSelect = (function(element){
			return $(element).kendoDropDownList({
				value: $(element).attr("data-value"),
				change: (function(e){
					__filter.apply();
				})
			}).data("kendoDropDownList");
		}($("select[data-ui='cityArea']", __toolbarUiBox)));
	}
	
	var __typeUiSelect = (function(element){
		return $(element).kendoDropDownList({
			value: $(element).attr("data-value"),
			change: (function(e){
				__filter.apply();
			})
		}).data("kendoDropDownList");
	}($("select[data-ui='type']", __toolbarUiBox)));
	
	var __verificationUiSelect = (function(element){
		return $(element).kendoDropDownList({
			value: $(element).attr("data-value"),
			change: (function(e){
				__filter.apply();
			})
		}).data("kendoDropDownList");
	}($("select[data-ui='verification']", __toolbarUiBox)));
	
	$("a[data-action='export']", __toolbarUiBox).click(function(){
		__exportUiWindow.getDocument(__filter.prepare());
	});
	
	var __listUiTable = (function(element){
		var __data = eval($(">script#data", element).text()),
			__templates = $(">script[type='text/x-kendo-template']", element);
		
		__templates.each(function(i){
			if(typeof __data.columns[i] == "undefined")
				return;
			__data.columns[i]["template"] = kendo.template($(this).html());
		});
		
		var __uiTable = $(element).kendoGrid(__data).data("kendoGrid");
		
		$(__uiTable.tbody).click(function(event){
			var __a = $(event.srcElement);
			if($(__a).prop("tagName") != "A")
				__a = $($(__a).parents("a").eq(0));
			
			switch($(__a).attr("data-action")){
				case "view":
					__viewerUiWindow.getItemAndOpenWindow($(__a).attr("data-id"));
					break;
			}
		});
		
		if( ! ($(">tr", __uiTable.tbody).length > 0))
			$(__uiTable.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));
		
		return __uiTable;
	}($("table[data-ui='list']", __section)));

});