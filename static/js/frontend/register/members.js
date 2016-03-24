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

		var __documentsUiSelect = (function(element){
			var __inputTemplate = kendo.template($(">script#input_template", $($(element).parents("div").eq(0))).html());

			return $(element).kendoMultiSelect({
				placeholder: "Почніть вводити номер рішення",
				dataValueField: "id",
				dataTextField: "title",
				filter: "contains",
				minLength: 1,
				autoBind: false,
				maxSelectedItems: 1,
				template: $(">script#input_template", $($(element).parents("div").eq(0))).html(),
				dataSource: {
					serverFiltering: true,
					transport: {
						read: (function(options){
							$.ajax({
								url: "/register/documents/find_document?number="+options.data.filter.filters[0].value,
								dataType: "jsonp",
								complete: (function(response){
									options.success($.map(eval("("+response.responseText+")").list, function(item){
										item.template = __inputTemplate(item);
										return item;
									}));
								})
							});
						})
					}
				},
				select: function(){
					$("a[data-action='approve'], a[data-action='dismiss']", __uiWindow.element).css({
						"opacity": "1",
						"pointer-events": "auto",
						"cursor": "pointer"
					});
				}
			}).data("kendoMultiSelect");
		})($("select[data-uiAutoComplete='q']", __uiWindow.element));

		$("a[data-action='approve'], a[data-action='dismiss']", __uiWindow.element).click(function(){
			if( ! __documentsUiSelect.value()){
				$("input[data-uiAutoComplete='q']", __uiWindow.element).css("border", "solid 1px red");
				setTimeout(function(){
					$("input[data-uiAutoComplete='q']", __uiWindow.element).css("border", "solid 1px #A7A7A7");
				}, 2000);
			}

			var uid = $(this).attr("data-id");
			var type = $(this).attr("data-action") == "approve" ? 1 : -1;

			$.post("/register/members/set_approve",
				{
					uid: uid,
					did: __documentsUiSelect.value(),
					type: type,
					comment: $("textarea#approveComment", __viewerUiWindow.element).val()
				},
				function(res){
					if(type == 1)
					{
						var __item = __listUiTable.dataSource.get(uid);
						__item.set("type", 100);
					}

					__viewerUiWindow.close();
				}, "json");
		});

		return $.extend(__uiWindow, {
			getItemAndOpenWindow: (function(id){
				$.post("/register/members/get_member", {
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
					
					$("span#locality", __uiWindow.element).html(__item.locality);
					$("span#address", __uiWindow.element).html(([__item.street, __item.house_number]).join(", "));
					
					__education.value(__item.education_level);
					
					$("span#jobs", __uiWindow.element).html(__item.jobs);
					$("span#social_activity", __uiWindow.element).html(__item.social_activity);
					$("span#political_activity", __uiWindow.element).html(__item.political_activity);
					
					$("div#documents", __uiWindow.element).empty();
					__item.documents.forEach(function(document){
						$("div#documents", __uiWindow.element).append($("<a class=\"icon\" href=\"/s/storage/"+document+"\" target=\"_blank\"><i class=\"icon-file fs30\" style=\"padding: 0\"></i></a>"));
					});

					__documentsUiSelect.value("");
					$("textarea#approveComment", __uiWindow.element).val("");

					if(__item.approve != null && __item.approve.type == "1"){
						$("[data-type='approveForm']", __uiWindow.element).hide();
						$("[data-type='approved']", __uiWindow.element).show();

						$("div#approverAvatar", __uiWindow.element).html("");
						if(__item.approve.user_approver.avatar)
							$("div#approverAvatar", __uiWindow.element).css({
								backgroundImage: "url(http://volya.ua/s/img/thumb/ai/"+__item.verification.user_verifier.avatar+")"
							});

						$("span#approverName", __uiWindow.element).html(__item.verification.user_verifier.name);
						$("span#approveDate", __uiWindow.element).html(__item.verification.created_at);
					} else {
						$("[data-type='approveForm']", __uiWindow.element).show();
						$("[data-type='approved']", __uiWindow.element).hide();

						$("div#approverAvatar", __uiWindow.element).css({
							backgroundImage: ""
						});

						$("div#approverAvatar", __uiWindow.element).html("");
						$("span#approverName", __uiWindow.element).html("");
						$("span#approveDate", __uiWindow.element).html("");
					}

					if( ! __item.verification || __item.verification.type == "-1"){
						var comment = __item.verification ? __item.verification.comment : "";

						$("input#notVerified").prop('checked', true);
						$("textarea#comment", __uiWindow.element).val(comment).show();
						$("[data-type='notVerified']", __uiWindow.element).show();
						$("[data-type='verified']", __uiWindow.element).hide();
					} else {
						$("[data-type='notVerified']", __uiWindow.element).hide();
						$("[data-type='verified']", __uiWindow.element).show();

						$("div#verifierAvatar", __uiWindow.element).html("");
						if(__item.verification.user_verifier.avatar)
							$("div#verifierAvatar", __uiWindow.element).css({
								backgroundImage: "url(http://volya.ua/s/img/thumb/ai/"+__item.verification.user_verifier.avatar+")"
							});
						else
							$("div#verifierAvatar", __uiWindow.element).html('<i class="icon-user"></i>');

						$("a[data-action='approve'], a[data-action='dismiss']", __uiWindow.element).css({
							"opacity": ".5",
							"pointer-events": "none",
							"cursor": "default"
						});

						$("span#verifierName", __uiWindow.element).html(__item.verification.user_verifier.name);
						$("span#verificationDate", __uiWindow.element).html(__item.verification.created_at);
					}

					__uiWindow.open();
				}, "json");
			})
		});
	}($("div[ui-window='register.members.viewer']")));
	
	var __exportUiWindow = (function(element){
		var __uiWindow = new Window(element);
		
		return $.extend(__uiWindow, {
			getDocument: (function(url){
				$("div[data-uiBox='content']").empty()
						.append($("<iframe frameborder=\"0\" width=\"100%\" height=\"700px\" src=\"/s/pdf?url="+encodeURIComponent("/admin/register/export_members/c7a455383a2f22f10465dae825acf661"+url)+"\" />"));
				__uiWindow.open();
			})
		});
	}($("div[ui-window='register.export']")));
	
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
				window.location.href = "/register/members"+this.prepare();
			})
		});
	}());

	$("a#save", __viewerUiWindow.element).click(function(){
		var uid = $(this).attr("data-id");

		$.post("/register/members/set_varification",
			{
				uid: uid,
				state: $("input[name='varification']:checked", __viewerUiWindow.element).val(),
				comment: $("textarea#comment", __viewerUiWindow.element).val()
			},
			function(res){
				var __item = __listUiTable.dataSource.get(uid);
				__item.set("verification", res.item.verification);

				__viewerUiWindow.close();
			}, "json");
	});

	$("input[name='varification']", __viewerUiWindow.element).change(function(){
		$("textarea#comment", __viewerUiWindow.element).val("");

		if($(this).val() == "-1")
			$("textarea#comment", __viewerUiWindow.element).show();
		else
			$("textarea#comment", __viewerUiWindow.element).hide();
	});
	
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
				case "verification":
					__viewerUiWindow.getItemAndOpenWindow($(__a).attr("data-id"));
					$("a#save", __viewerUiWindow.element).attr("data-id", $(__a).attr("data-id"));
					break;
				case "approve":
					__viewerUiWindow.getItemAndOpenWindow($(__a).attr("data-id"));
					$("a[data-action='approve'], a[data-action='dismiss']", __viewerUiWindow.element).attr("data-id", $(__a).attr("data-id"));
					break;
				case "view":
					__viewerUiWindow.getItemAndOpenWindow($(__a).attr("data-id"));
					$("a#save", __viewerUiWindow.element).attr("data-id", $(__a).attr("data-id"));
					break;
			}
		});

		if( ! ($(">tr", __uiTable.tbody).length > 0))
			$(__uiTable.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));

		return __uiTable;
	}($("table[data-ui='list']", __section)));

});