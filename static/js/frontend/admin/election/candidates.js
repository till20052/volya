$(document).ready(function(){
	
	var __section = $("body>section>div.section"),
		__toolbarUiBox = $(">div>div[data-uiBox='toolbar']", __section);
	
	var __formUiWindow = (function(element){
		var __uiWindow = new Window(element);
		
		var __uiForm = (function(element){
			var __uiForm = new Form(element);
			
			__uiForm.beforeSend(function(){
				__uiForm.data({
					id: $(__uiForm.element).attr("data-id"),
					symlink_avatar: __avatarUiElement.getHash(),
					geo_koatuu_code: __GKCUiSelect.value(),
					county_number: __countyNumbersUiSelect.value(),
					announcement: __txt.announcement.value(),
					biography: __txt.biography.value(),
					program: __txt.program.value(),
					quote: __txt.quote.value(),
					is_results_visible: $("input[data-id='is_results_visible']", __uiWindow.element).attr("checked") != "checked" ? 0 : 1,
					contacts: ({
						email: [$("input[data-id='email']", __uiWindow.element).val()],
						phone: __phoneUiElement.fn.data(),
						facebook: [$("input[data-id='facebook']", __uiWindow.element).val()],
						twitter: [$("input[data-id='twitter']", __uiWindow.element).val()],
						website: [$("input[data-id='website']", __uiWindow.element).val()]
					}),
					opponents_ids: $.map(__opponentsUiTable.dataSource.data(), function(token){
						return token.id;
					}),
					agitations_ids: $.map(__agitationsUiTable.dataSource.data(), function(token){
						return token.id;
					})
				});
			});
			
			__uiForm.afterSend(function(response){
				if( ! response.success)
					return;
				
				if( ! (__uiForm.data("id") > 0))
					__listUiTable.dataSource.add(response.item);
				else {
					var __item = __listUiTable.dataSource.get(response.item.id);
					for(var __field in response.item)
						__item.set(__field, response.item[__field]);
				}
				
				__uiWindow.close();
			});
			
			return __uiForm;
		}($("form", __uiWindow.element)));
		
		var __uiTabStrip = $("div[data-uiTabStrip]", __uiWindow.element).kendoTabStrip({
			animation: false,
			select: (function(){
				setTimeout(function(){
					__uiWindow.checkPosition();
				}, 100);
			})
		}).data("kendoTabStrip");
		
		var __avatarUiElement = (function(element){
			var __i = $(">i", element).clone(),
				__cover = $(">div.avatar", element).css({
				opacity: 0
			}).hover(function(){
				$(this).animate({
					opacity: 1
				}, 100);
			}, function(){
				$(this).animate({
					opacity: 0
				}, 100);
			});
			
			$(">input", __cover).css({
				opacity: 0
			}).fileupload({
				dataType: "json",
				url: "/s/storage/j_save?extension[]=jpg&extension[]=png",
				sequentialUploads: true,
				done: (function(event, data){
					if( ! data.result.files[0]){
						alert("Файл, який ви завантажуєте, не підтримується");
						return;
					}
					
					__setHash(data.result.files[0]);
				})
			});
			
			var __setHash = (function(hash){
				$(">i", element).remove();

				$(element).attr({
					"data-hash": hash
				}).css({
					backgroundImage: "url('/s/img/thumb/ag/"+hash+"')"
				});
			});
			
			var __clear = (function(){
				if( ! ($(">i", element).length > 0))
					$(element).append(__i);
				
				$(element).attr({
					"data-hash": ""
				}).css({
					backgroundImage: ""
				});
			});
			
			return ({
				setHash: __setHash,
				getHash: (function(){
					return (typeof $(element).attr("data-hash") != undefined ? $(element).attr("data-hash") : "");
				}),
				clear: __clear
			});
		}($("div[data-ui='avatar']", __uiWindow.element)));
		
		var __GKCUiSelect = (function(element){
			var __uiSelect = $(element).kendoDropDownList({
				change: (function(e){
					__countyNumbersUiSelect.enable(false);
					$(__countyNumbersUiSelect.wrapper).css("opacity", .3);
					
					if( ! (e.sender.value() > 0)){
						__countyNumbersUiSelect.dataSource.data([{id: 0, text: "\u2014"}]);
						return;
					}
					
					$.post("/api/election/j_get_county_numbers_by_region", {
						geo_koatuu_code: e.sender.value()
					}, function(response){
						if( ! response.success)
							return;
						
						__countyNumbersUiSelect.enable(true);
						$(__countyNumbersUiSelect.wrapper).css("opacity", 1);
						__countyNumbersUiSelect.dataSource.data(([{id: 0, text: "\u2014"}]).concat(response.list));
						__countyNumbersUiSelect.value(typeof e.county_number != "undefined" ? e.county_number : 0);

					}, "json");
				})
			}).data("kendoDropDownList");
			
			return __uiSelect;
		}($("select[data-ui='geo_koatuu_code']", __uiWindow.element)));
		
		var __countyNumbersUiSelect = $("select[data-ui='county_number']", __uiWindow.element).kendoDropDownList({
			dataValueField: "id",
			dataTextField: "text"
		}).data("kendoDropDownList");
		
		var __phoneUiElement = (function(element){
			var __fn = new Object(),
				__phoneTemplate = $(">div", element).clone();
			
			$(element).click(function(e){
				var __a = $(e.srcElement);
				if($(__a).prop("tagName") != "A")
					__a = $($(__a).parents("a").eq(0));
				
				switch($(__a).attr("data-action")){
					case "add":
						__fn.add("");
						break;
						
					case "delete":
						$($(__a).parents("div").eq(1)).remove();
						__refreshView();
						break;
				};
			});
			
			var __refreshView = (function(){
				var __count = $(">div", element).length;
				$(">div", element).each(function(i){
					if(i == 0)
						$(this).css("margin-top", 0);
					
					if((i + 1) != __count){
						$($("a[data-action='add']", this).parents("div").eq(0)).hide();
						$($("a[data-action='delete']", this).parents("div").eq(0)).show();
					}
					else
						$($("a[data-action='delete']", this).parents("div").eq(0)).hide();
				});
			});
			
			__fn["add"] = (function(value){
				$(element).append(__phoneTemplate.clone());
				__refreshView();
				$(">div:last-child input", element).val(value);
			});
			
			__fn["data"] = (function(data){
				if(typeof data == "object"){
					__fn.empty();
					data.forEach(function(value){
						__fn.add(value);
					});
				}
				
				return $.map($(">div", element), function(div){
					return $("input", div).val();
				});
			});
			
			__fn["empty"] = (function(){
				$(">div", element).remove();
			});
			
			__fn.empty();
			__fn.add("");
			
			return ({
				element: element,
				fn: __fn
			});
		}($("div[data-ui='phone']", __uiWindow.element)));
		
		var __txt = new Object();
		([
			$("textarea[data-ui='announcement']", __uiWindow.element),
			$("textarea[data-ui='biography']", __uiWindow.element),
			$("textarea[data-ui='program']", __uiWindow.element),
			$("textarea[data-ui='quote']", __uiWindow.element)
		]).forEach(function(item){
			__txt[$(item).attr("data-ui")] = (function(element){
				var __uiTextarea = $(element).kendoEditor({
					tools: [
						"bold",
						"italic",
						"underline",
						"justifyLeft",
						"justifyCenter",
						"justifyRight",
						"justifyFull",
						"cleanFormatting"
					]
				}).data("kendoEditor");

				$("<div class=\"fleft\" />").css({
					padding: "11px 15px 10px",
					backgroundColor: "#A7A7A7",
					color: "white"
				}).html($(element).attr("data-label")).insertBefore(__uiTextarea.toolbar.element);

				return __uiTextarea;
			})(item);
		});
		
		$("a[data-action='add_agitation']", __uiWindow.element).click(function(){
			__agitationFormUiWindow.open();
			__agitationFormUiWindow.cleanUp();
		});
		
		var __opponentsUiTable = (function(element){
			var __opponentUiWindow = (function(element){
				var __uiWindow = (new Window(element)).afterClose(function(){
					__formUiWindow.open();
				});
				
				var __avatarUiElement = (function(element){
					var __i = $(">i", element).clone(),
						__cover = $(">div.avatar", element).css({
						opacity: 0
					}).hover(function(){
						$(this).animate({
							opacity: 1
						}, 100);
					}, function(){
						$(this).animate({
							opacity: 0
						}, 100);
					});

					$(">input", __cover).css({
						opacity: 0
					}).fileupload({
						dataType: "json",
						url: "/s/storage/j_save?extension[]=jpg&extension[]=png",
						sequentialUploads: true,
						done: (function(event, data){
							if( ! data.result.files[0]){
								alert("Файл, який ви завантажуєте, не підтримується");
								return;
							}

							__setHash(data.result.files[0]);
						})
					});

					var __setHash = (function(hash){
						$(">i", element).remove();

						$(element).attr({
							"data-hash": hash
						}).css({
							backgroundImage: "url('/s/img/thumb/ag/"+hash+"')"
						});
					});

					var __cleanUp = (function(){
						if( ! ($(">i", element).length > 0))
							$(element).append(__i);

						$(element).attr({
							"data-hash": ""
						}).css({
							backgroundImage: ""
						});
					});

					return ({
						setHash: __setHash,
						getHash: (function(){
							return (typeof $(element).attr("data-hash") != undefined ? $(element).attr("data-hash") : "");
						}),
						cleanUp: __cleanUp
					});
				}($("div[data-ui='avatar']", __uiWindow.element)));
				
				var __typeUiSelect = $("select[data-ui='type']", __uiWindow.element).kendoDropDownList({
					value: 0
				}).data("kendoDropDownList");
				
				$("a[data-action='submit']", __uiWindow.element).click(function(){
					$.post("/admin/election/j_save_opponent", {
						id: $(__uiWindow.element).attr("data-id"),
						type: __typeUiSelect.value(),
						symlink_avatar: __avatarUiElement.getHash(),
						name: $("input#name", __uiWindow.element).val(),
						appointment: $("textarea#appointment", __uiWindow.element).val(),
						description: $("textarea#description", __uiWindow.element).val()
					}, function(response){
						if( ! response.success)
							return;
						
						__uiWindow.close();
						
						if( ! ($(__uiWindow.element).attr("data-id") > 0))
							__uiTable.dataSource.add(response.item);
						else {
							var __item = __uiTable.dataSource.get($(__uiWindow.element).attr("data-id"));
							for(var __field in response.item)
								__item.set(__field, response.item[__field]);
						}
					}, "json");
				});
				
				$("a[data-action='cancel']", __uiWindow.element).click(function(){
					__uiWindow.close();
				});
				
				return $.extend(__uiWindow, {
					avatar: __avatarUiElement,
					setData: (function(data){
						$(__uiWindow.element).attr("data-id", typeof data.id != "undefined" ? data.id : 0);
						
						__avatarUiElement.cleanUp();
						if(typeof data.symlink_avatar != "undefined")
							__avatarUiElement.setHash(data.symlink_avatar);
						
						$("input#name", __uiWindow.element).val(typeof data.name != "undefined" ? data.name : "");
						__typeUiSelect.value(typeof data.type != "undefined" ? data.type : 0);
						$("textarea#appointment", __uiWindow.element).val(typeof data.appointment != "undefined" ? data.appointment : "");
						$("textarea#description", __uiWindow.element).val(typeof data.description != "undefined" ? data.description : "");
					})
				});
			})($("div[ui-window='admin.election.candidates.opponent_form']"));
			
			$("a[data-action='add_opponent']", __uiWindow.element).click(function(){
				__opponentUiWindow.open();
				__opponentUiWindow.setData([]);
			});
			
			var __uiTable = (function(element){
				var __data = eval($(">script#data", element).text()),
					__templates = $(">script[type='text/x-kendo-template']", element);

				__templates.each(function(i){
					if(typeof __data.columns[i] == "undefined")
						return;
					__data.columns[i]["template"] = kendo.template($(this).html());
				});
				
				return $(element).kendoGrid($.extend(__data, {
					dataBound: (function(e){
						if( ! (e.sender.dataSource.data().length > 0))
							$(e.sender.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));

						__uiWindow.checkPosition();
					})
				})).data("kendoGrid");
			})(element);
			
			var __editItem = (function(id){
				$.post("/admin/election/j_get_opponent", {
					id: id
				}, function(response){
					if( ! response.success)
						return;
					
					__opponentUiWindow.open();
					__opponentUiWindow.setData(response.item);
				}, "json");
			});
			
			var __updateStateItem = (function(id, field, state){
				$.post("/admin/election/j_update_opponent_state", {
					id: id,
					field: field,
					state: state
				}, function(response){
					if( ! response.success)
						return;
					__uiTable.dataSource.get(id).set(field, state);
				}, "json");
			});
			
			var __deleteItem = (function(id, text){
				if(confirm(text)){
					$.post("/admin/election/j_delete_opponent", {
						id: id
					}, function(){
						__uiTable.dataSource.remove(__uiTable.dataSource.get(id));
					}, "json");
				}
			});
			
			$(__uiTable.tbody).click(function(e){
				var __element = $(e.srcElement);
				if(typeof $(__element).attr("data-action") == "undefined")
					__element = $($(__element).parents("*[data-action]").eq(0));

				switch($(__element).attr("data-action")){
					case "edit":
						__editItem($(__element).attr("data-id"));
						break;

					case "publicate":
						__updateStateItem($(__element).attr("data-id"), "is_public", ($(__element).attr("checked") != "checked" ? 0 : 1));
						break;
						
					case "set_type":
						__updateStateItem($(__element).attr("data-id"), "type", $(__element).attr("data-value"));
						break;
						
					case "delete":
						__deleteItem($(__element).attr("data-id"), $(__element).attr("data-text"));
						break;
				}
			});
			
			return __uiTable;
		})($("table[data-ui='opponents']", __uiWindow.element));
		
		var __agitationsUiTable = (function(element){
			var __data = eval($(">script#data", element).text()),
				__templates = $(">script[type='text/x-kendo-template']", element);
			
			__templates.each(function(i){
				if(typeof __data.columns[i] == "undefined")
					return;
				__data.columns[i]["template"] = kendo.template($(this).html());
			});

			var __uiTable = $(element).kendoGrid($.extend(__data, {
				dataBound: (function(e){
					if( ! (e.sender.dataSource.data().length > 0))
						$(e.sender.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));

					__uiWindow.checkPosition();
				})
			})).data("kendoGrid");
			
			var __editItem = (function(id){
				$.post("/admin/election/j_get_agitation", {
					id: id,
					use_current_lang: 1
				}, function(response){
					if( ! response.success)
						return false;
					
					__agitationFormUiWindow.data(response.item);
					__agitationFormUiWindow.open();
				}, "json");
			});
			
			var __publicateItem = (function(id, state){
				$.post("/admin/election/j_publicate_agitation", {
					id: id,
					state: state
				}, function(){
					__uiTable.dataSource.get(id).set("is_public", state);
				}, "json");
			});
			
			var __deleteItem = (function(id){
				if(confirm("Ви дійсно бажаєте видалити запис?")){
					$.post("/admin/election/j_delete_agitation", {
						id: id
					}, function(){
						__uiTable.dataSource.remove(__uiTable.dataSource.get(id));
					}, "json");
				}
			});
			
			$(__uiTable.tbody).click(function(e){
				var __element = $(e.srcElement);
				if(typeof $(__element).attr("data-action") == "undefined")
					__element = $($(__element).parents("*[data-action]").eq(0));

				switch($(__element).attr("data-action")){
					case "edit":
						__editItem($(__element).attr("data-id"));
						break;

					case "publicate":
						__publicateItem($(__element).attr("data-id"), ($(__element).attr("checked") != "checked" ? 0 : 1));
						break;
						
					case "delete":
						__deleteItem($(__element).attr("data-id"));
						break;
				}
			});
			
			return __uiTable;
		})($("table[data-ui='agitations']", __uiWindow.element));
		
		$("a[data-action='submit']", __uiWindow.element).click(function(){
			__uiForm.send();
		});
		
		$("a[data-action='cancel']", __uiWindow.element).click(function(){
			__uiWindow.close();
		});
		
		return $.extend(__uiWindow, {
			data: (function(data){
				__uiTabStrip.select(0);
				
				$(__uiForm.element).attr("data-id", typeof data.id != "undefined" ? data.id : 0);

				__avatarUiElement.clear();
				if(typeof data.symlink_avatar != "undefined")
					__avatarUiElement.setHash(data.symlink_avatar);
				
				$("input#symlink", __uiWindow.element).val(typeof data.symlink != "undefined" ? data.symlink : "");
				
				$("input#first_name", __uiWindow.element).val(typeof data.first_name != "undefined" ? data.first_name : "");
				$("input#middle_name", __uiWindow.element).val(typeof data.middle_name != "undefined" ? data.middle_name : "");
				$("input#last_name", __uiWindow.element).val(typeof data.last_name != "undefined" ? data.last_name : "");

				$("input#staff_address", __uiWindow.element).val(typeof data.staff_address != "undefined" ? data.staff_address : "");

				__GKCUiSelect.value(typeof data.geo_koatuu_code != "undefined" ? data.geo_koatuu_code : 0);
				__GKCUiSelect.options.change({
					sender: __GKCUiSelect,
					county_number: typeof data.county_number != "undefined" ? data.county_number : 0
				});
				
				(["email", "facebook", "twitter", "website"]).forEach(function(token){
					if(
							typeof data.contacts == "undefined"
							|| typeof data.contacts[token] == "undefined"
							|| ! (data.contacts[token].length > 0)
					)
						$("input[data-id='"+token+"']", __uiWindow.element).val("");
					else
						$("input[data-id='"+token+"']", __uiWindow.element).val(data.contacts[token][0]);
				});
				
				__phoneUiElement.fn.empty();
				if(
						typeof data.contacts == "undefined"
						|| typeof data.contacts.phone == "undefined"
						|| ! (data.contacts.phone.length > 0)
				)
					__phoneUiElement.fn.add("");
				else
					__phoneUiElement.fn.data(data.contacts.phone);

				__txt.announcement.value(typeof data.announcement != "undefined" ? data.announcement : "");
				__txt.biography.value(typeof data.biography != "undefined" ? data.biography : "");
				__txt.program.value(typeof data.program != "undefined" ? data.program : "");
				__txt.quote.value(typeof data.quote != "undefined" ? data.quote : "");

				__opponentsUiTable.dataSource.data(typeof data.opponents != "undefined" ? data.opponents : []);
				__agitationsUiTable.dataSource.data(typeof data.agitations != "undefined" ? data.agitations : []);
				
				$("input[data-id='is_results_visible']", __uiWindow.element).attr("checked", typeof data.is_results_visible != "undefined" && data.is_results_visible > 0 ? true : false);
				$("input#percent", __uiWindow.element).val(typeof data.percent != "undefined" ? data.percent : "");
				$("input#place_number", __uiWindow.element).val(typeof data.place_number != "undefined" ? data.place_number : "");
				$("input#votes_count", __uiWindow.element).val(typeof data.votes_count != "undefined" ? data.votes_count : "");
				$("input#difference", __uiWindow.element).val(typeof data.difference != "undefined" ? data.difference : "");
				
				$("a[data-action='submit']", __uiWindow.element).html(
						typeof data.id != "undefined"
						? $("a[data-action='submit']", __uiWindow.element).attr("data-edit")
						: $("a[data-action='submit']", __uiWindow.element).attr("data-add")
				);
			}),
			tabStrip: __uiTabStrip,
			agitations: __agitationsUiTable
		});
	})($("div[ui-window='admin.election.candidates.form']"));
	
	var __agitationFormUiWindow = (function(element){
		var __uiWindow = (new Window(element)).afterClose(function(){
			__formUiWindow.open();
			__formUiWindow.tabStrip.select(3);
		});
		
		var __categoriesUiWindow = (function(element){
			var __uiWindow = (new Window(element)).afterOpen(function(){
				$.post("/admin/election/j_get_agitation_categories", function(response){
					if( ! response.success)
						return;
					__listUiTable.dataSource.data(response.list);
				}, "json");
			}).afterClose(function(){
				__agitationFormUiWindow.open();
				$.post("/admin/election/j_get_agitation_categories", {
					is_public: 1,
					use_current_lang: 1
				}, function(response){
					if( ! response.success)
						return;
					__categoriesUiSelect.dataSource.data(response.list);
				}, "json");
			});
			
			$("a[data-action='add']", __uiWindow.element).click(function(){
				if($("input#name", __uiWindow.element).val() == ""){
					$("input#name", __uiWindow.element).css("borderColor", "red");
					setTimeout(function(){
						$("input#name", __uiWindow.element).css("borderColor", "");
					}, 2000);
					return;
				}
				
				$.post("/admin/election/j_add_agitation_category", {
					name: $("input#name", __uiWindow.element).val()
				}, function(response){
					if( ! response.success)
						return;
					
					$("input#name", __uiWindow.element).val("");
					__listUiTable.dataSource.add(response.item);
				}, "json");
			});
			
			var __listUiTable = (function(element){
				var __data = eval($(">script#data", element).text()),
					__templates = $(">script[type='text/x-kendo-template']", element);

				__templates.each(function(i){
					if(typeof __data.columns[i] == "undefined")
						return;
					__data.columns[i]["template"] = kendo.template($(this).html());
				});

				var __uiTable = $(element).kendoGrid($.extend(__data, {
					dataBound: (function(e){
						if( ! (e.sender.dataSource.data().length > 0))
							$(e.sender.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));
						
						__uiWindow.checkPosition();
					})
				})).data("kendoGrid");
				
				var __editItem = (function(element){
					var __parentDiv = $($(element).parents("div").eq(0)),
						__a = $(element).clone(),
						__input = $("<input type=\"text\" class=\"textbox\" style=\"width: 100%\" />").bind("blur keyup", function(e){
						var __this = this;
						
						if( ! ($.inArray(e.type, ["blur", "keyup"]) > -1) || (e.type == "keyup" && e.keyCode != 13))
							return;
						
						if($(__this).val() == ""){
							$(__this).css("borderColor", "red");
							setTimeout(function(){
								$(__this).css("borderColor", "");
							}, 2000);
							return;
						}
						
						$.post("/admin/election/j_edit_agitation_category", {
							id: $(__a).attr("data-id"),
							name: $(__this).val()
						}, function(){
							$(__parentDiv).css("padding", "")
								.append($(__a));
							$(__a).html($(__this).val());
							$(__this).remove();
						}, "json");
					});
					
					$(element).remove();
					
					$(__parentDiv).css("padding", 0)
							.append($(__input).val($(__a).html()));
					
					$(__input).focus();
				});
				
				var __publicateItem = (function(id, state){
					$.post("/admin/election/j_publicate_agitation_category", {
						id: id,
						state: state
					}, function(){
						__uiTable.dataSource.get(id).set("is_public", state);
					}, "json");
				});
				
				var __deleteItem = (function(id){
					if(confirm("Ви дійсно бажаєте видалити цю категорію?")){
						$.post("/admin/election/j_delete_agitation_category", {
							id: id
						}, function(response){
							if( ! response.success)
								return;
							__uiTable.dataSource.remove(__uiTable.dataSource.get(id));
						}, "json");
					}
				});
				
				$(__uiTable.tbody).click(function(event){
					var __element = $(event.srcElement);
					if(typeof $(__element).attr("data-action") == "undefined")
						__element = $($(__element).parents("*[data-action]").eq(0));

					switch($(__element).attr("data-action")){
						case "edit":
							__editItem(__element);
							break;

						case "publicate":
							__publicateItem($(__element).attr("data-id"), ($(__element).attr("checked") != "checked" ? 0 : 1));
							break;
							
						case "delete":
							__deleteItem($(__element).attr("data-id"));
							break;
					}
				});
				
				return __uiTable;
			})($("table[data-ui='list']", __uiWindow.element));
			
			return __uiWindow;
		})($("div[ui-window='admin.election.candidates.agitation_categories_form']"));
		
		var __uiForm = (function(element){
			var __uiForm = new Form(element);
			
			__uiForm.beforeSend(function(){
				__uiForm.data({
					id: $(__uiForm.element).attr("data-id"),
					image: __previewUiUploader.getHash(),
					file: __fileUiUploader.getHash(),
					categories_ids: __categoriesUiSelect.value()
				});
			});
			
			__uiForm.afterSend(function(response){
				__uiWindow.close();
				
				if( ! (__uiForm.data("id") > 0))
					__formUiWindow.agitations.dataSource.add(response.item);
				else {
					var __item = __formUiWindow.agitations.dataSource.get(__uiForm.data("id"));
					for(var __field in response.item)
						__item.set(__field, response.item[__field]);
				}
			});
			
			return __uiForm;
		})($("form", __uiWindow.element));
		
		var __previewUiUploader = (function(element){
			var __i = $(">i", element).clone(),
				__cover = $(">div.avatar", element).css({
				opacity: 0
			}).hover(function(){
				$(this).animate({
					opacity: 1
				}, 100);
			}, function(){
				$(this).animate({
					opacity: 0
				}, 100);
			});
			
			$(">input", __cover).css({
				opacity: 0
			}).fileupload({
				dataType: "json",
				url: "/s/storage/j_save?extension[]=jpg&extension[]=png",
				sequentialUploads: true,
				done: (function(event, data){
					if( ! data.result.files[0]){
						alert("Файл, який ви завантажуєте, не підтримується");
						return;
					}
					
					__setHash(data.result.files[0]);
				})
			});
			
			var __setHash = (function(hash){
				$(">i", element).remove();

				$(element).attr({
					"data-hash": hash
				}).css({
					backgroundImage: "url('/s/img/thumb/ag/"+hash+"')"
				});
			});
			
			var __cleanUp = (function(){
				if( ! ($(">i", element).length > 0))
					$(element).append(__i);
				
				$(element).attr({
					"data-hash": ""
				}).css({
					backgroundImage: ""
				});
			});
			
			return ({
				setHash: __setHash,
				getHash: (function(){
					return (typeof $(element).attr("data-hash") != undefined ? $(element).attr("data-hash") : "");
				}),
				cleanUp: __cleanUp
			});
		}($("div[data-uiUploader='preview']", __uiWindow.element)));
		
		var __categoriesUiSelect = (function(element){
			return $("select[data-ui='categories']", __uiWindow.element).kendoMultiSelect({
				dataValueField: "id",
				dataTextField: "name",
				dataSource: ({
					data: eval($(">script", element).text())
				})
			}).data("kendoMultiSelect");
		})($("select[data-ui='categories']", __uiWindow.element));
		
		$("a[data-action='manage_categories']", __uiWindow.element).click(function(){
			__categoriesUiWindow.open();
		});
		
		var __fileUiUploader = (function(element){
			var __uploaderUiBox = $(">div[data-uiBox='uploader']", element),
				__successUiBox = $(">div[data-uiBox='success']", element);
			
			$(">a>input", __uploaderUiBox).css({
				opacity: 0
			}).fileupload({
				dataType: "json",
				url: "/s/storage/j_save?extension[]=jpg&extension[]=png&extension[]=ai&extension[]=pdf&extension[]=psd&extension[]=esp",
				sequentialUploads: true,
				done: (function(event, data){
					if( ! data.result.files[0]){
						alert("Файл, який ви завантажуєте, не підтримується");
						return;
					}
					
					__setHash(data.files[0].name, data.result.files[0]);
				})
			});
			
			var __setHash = (function(name, hash){
				$(__uploaderUiBox).hide();
				$(__successUiBox).show();
				$(">div>span", __successUiBox).attr({
					"data-hash": hash
				}).html(name);
				$("input#name", __uiWindow.element).val(name);
			});
			
			$(">div>a", __successUiBox).click(function(){
				$(">div>span", __successUiBox).attr("data-hash", "");
				$(__successUiBox).hide();
				$(__uploaderUiBox).show();
			});
			
			return ({
				cleanUp: (function(){
					$(">div>a", __successUiBox).click();
				}),
				setHash: __setHash,
				setName: (function(name){
					$(">div>span", __successUiBox).html(name);
				}),
				getHash: (function(){
					return $(">div>span", __successUiBox).attr("data-hash");
				})
			});
		})($("div[data-uiUploader='file']", __uiWindow.element));
		
		$("input#name", __uiWindow.element).keyup(function(){
			__fileUiUploader.setName($(this).val());
		});
		
		$("a[data-action='submit']", __uiWindow.element).click(function(){
			__uiForm.send();
		});
		
		$("a[data-action='cancel']", __uiWindow.element).click(function(){
			__uiWindow.close();
		});
		
		var __cleanUp = (function(){
			$(__uiForm.element).attr("data-id", 0);
			__previewUiUploader.cleanUp();
			$("input#name", __uiWindow.element).val("");
			__categoriesUiSelect.value([]);
			__fileUiUploader.cleanUp();
		});
		
		var __data = (function(data){
			__cleanUp();
			
			$(__uiForm.element).attr("data-id", typeof data.id != "undefined" ? data.id : 0);
			
			if(typeof data.image != "undefined")
				__previewUiUploader.setHash(data.image);
			
			if(typeof data.file != "undefined")
				__fileUiUploader.setHash(data.name, data.file);
			
			if(typeof data.name != "undefined")
				$("input#name", __uiWindow.element).val(data.name);
			
			if(typeof data.categories_ids != "undefined")
				__categoriesUiSelect.value(data.categories_ids);
		});
		
		return $.extend(__uiWindow, {
			data: __data,
			cleanUp: __cleanUp
		});
	})($("div[ui-window='admin.election.candidates.agitation_form']"));
	
	var __exportFormUiWindow = (function(element){
		var __uiWindow = (new Window(element)).beforeOpen(function(){
			__fromUiDatePicker.value(new Date());
			__toUiDatePicker.value(new Date());
		});
		
		var __fromUiDatePicker = $("input[data-uiDatePicker='from']", __uiWindow.element).kendoDatePicker({
			format: "dd MMMM yyyy"
		}).data("kendoDatePicker");
		
		var __toUiDatePicker = $("input[data-uiDatePicker='to']", __uiWindow.element).kendoDatePicker({
			format: "dd MMMM yyyy"
		}).data("kendoDatePicker");
		
		$("a[data-action='export']", __uiWindow.element).click(function(){
			window.open("/admin/election/export?from="+kendo.toString(__fromUiDatePicker.value(), "yyyy-MM-dd")
					+"&to="+kendo.toString(__toUiDatePicker.value(), "yyyy-MM-dd"), "_blank");
			__exportFormUiWindow.close();
		});
		
		return __uiWindow;
	})($("div[ui-window='admin.election.candidates.export_form']"));
	
	$("a[data-action='create']", __toolbarUiBox).click(function(){
		__formUiWindow.open();
		__formUiWindow.data([]);
	});
	
	$("a[data-action='export']", __toolbarUiBox).click(function(){
		__exportFormUiWindow.open();
	});
	
	var __listUiTable = (function(element){
		var __data = eval($(">script#data", element).text()),
			__templates = $(">script[type='text/x-kendo-template']", element);
		
		var __editItem = (function(id){
			$.post("/admin/election/j_get_candidate", {
				id: id
			}, function(response){
				if( ! response.success)
					return;
				__formUiWindow.open();
				__formUiWindow.data(response.item);
			}, "json");
		});
		
		var __publicateItem = (function(id, state){
			$.post("/admin/election/j_candidate_publicate", {
				id: id,
				state: state
			}, function(){
				__uiTable.dataSource.get(id).set("is_public", state);
			}, "json");
		});
		
		var __deleteItem = (function(id, text){
			if(confirm(text)){
				$.post("/admin/election/j_delete_candidate", {
					id: id
				}, function(){
					__uiTable.dataSource.remove(__uiTable.dataSource.get(id));
				}, "json");
			}
		});
		
		__templates.each(function(i){
			if(typeof __data.columns[i] == "undefined")
				return;
			__data.columns[i]["template"] = kendo.template($(this).html());
		});
		
		var __uiTable = $(element).kendoGrid(__data).data("kendoGrid");
		
		$(__uiTable.tbody).click(function(event){
			var __element = $(event.srcElement);
			if(typeof $(__element).attr("data-action") == "undefined")
				__element = $($(__element).parents("*[data-action]").eq(0));
			
			switch($(__element).attr("data-action")){
				case "edit":
					__editItem($(__element).attr("data-id"));
					break;
					
				case "publicate":
					__publicateItem($(__element).attr("data-id"), ($(__element).attr("checked") != "checked" ? 0 : 1));
					break;
					
				case "delete":
					__deleteItem($(__element).attr("data-id"), $(__element).attr("data-text"));
			}
		});
		
		if( ! ($(">tr", __uiTable.tbody).length > 0))
			$(__uiTable.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));
		
		return __uiTable;
	}($("table[data-ui='list']", __section)));
});