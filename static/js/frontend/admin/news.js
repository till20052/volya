$(document).ready(function()
{
	var __section = $("body>section");
	var __data = eval($(">script#data", __section).text());
	
	var __formUiWindow = (function(){
		var __uiWindow = (new Window($("div[ui-window='admin.news.form']"))).afterOpen(function(){
			__uiTabStrip.select(0);
		});
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function(){
			var __data = {
				id: __uiForm.attr("data-id"),
				category_id: __categoriesUiSelect.value(),
				tags_ids: __tagsUiSelect.value(),
				//geo_koatuu_code: ,
				created_at: kendo.toString(__createdAtUiInput.value(), "yyyy-MM-dd HH:mm:ss"),
				text: __textUiEditor.value(),
				images: __imagesUiView.getImages(),
				in_top: $("input[data-ui='in_top']", __uiForm.element).attr("checked") == "checked" ? 1 : 0,
				in_election: $("input[data-ui='in_election']", __uiForm.element).attr("checked") == "checked" ? 1 : 0,
				in_main_block: $("input[data-ui='in_main_block']", __uiForm.element).attr("checked") == "checked" ? 1 : 0,
				in_volya_people: $("input[data-ui='in_volya_people']", __uiForm.element).attr("checked") == "checked" ? 1 : 0,
				election_candidate_id: __electionCandidatesUiSelect.value()
			};

			__data["geo_koatuu_code"] = 0;
			if(__cityUiAutoComplete.value().length == 10)
				__data["geo_koatuu_code"] = __cityUiAutoComplete.value();
			else if(__regionUiSelect.value().length == 10)
				__data["geo_koatuu_code"] = __regionUiSelect.value();

			__uiForm.data(__data);
		}).afterSend(function(response){
			if( ! response.success)
				return;
			
			if( ! (__uiForm.data("id") > 0))
				__listUiTable.dataSource.insert(0, response.item);
			else {
				var __item = __listUiTable.dataSource.get(__uiForm.data("id"));
				for(var __field in response.item)
					__item.set(__field, response.item[__field]);
			}
			
			__uiWindow.close();
		});
		
		var __uiTabStrip = $("div[data-uiTabStrip]", __uiWindow.element).kendoTabStrip({
			animation: false,
			select: (function(){
				setTimeout(function(){
					__uiWindow.checkPosition();
				}, 100);
			})
		}).data("kendoTabStrip");
		
		var __categoriesUiSelect = (function(element){
			return $(element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "name",
				dataSource: ({
					data: ([{id: 0, name: "\u2014"}]).concat(eval($(">script", element).text()))
				}),
				change: function(e){
					var __dataItem = e.sender.dataItem(e.sender.select());

					$("tr[data-uiGroupBox]", __uiTabStrip.contentElements[0]).hide();
					$("tr[data-uiGroupBox='"+__dataItem.symlink+"']", __uiTabStrip.contentElements[0]).show();

					var __value = $(__regionUiSelect.element).attr("data-value");
					if(typeof __value != "undefined")
						$(__regionUiSelect.element).removeAttr("data-value");
					else
						__value = 0;

					__regionUiSelect.value(__value);

					__regionUiSelect.options.change({
						sender: __regionUiSelect
					});

					$("input[data-ui='in_main_block']", __uiForm.element).attr("checked", false);
				}
			}).data("kendoDropDownList");
		})($("select[data-ui='categories']", __uiTabStrip.contentElements[0]));
		
		$("a[data-action='manage_categories']", __uiTabStrip.contentElements[0]).click(function(){
			__w.categories.open();
		});

		var __regionUiSelect = (function(element){
			return $(element).kendoDropDownList({
				value: 0,
				change: function(e){
					var __id = $(__cityUiAutoComplete.element).attr("data-id"),
						__title = $(__cityUiAutoComplete.element).attr("data-title");

					if(typeof __id != "undefined"){
						$(__cityUiAutoComplete.element).removeAttr("data-id");
						$(__cityUiAutoComplete.element).removeAttr("data-title");
					} else
						__id = 0;

					__cityUiAutoComplete.value(__id, __title);

					if(e.sender.value() != 0)
						__cityUiAutoComplete.enable(true);
					else
						__cityUiAutoComplete.enable(false);

					$("input[data-ui='in_top']", __uiForm.element).attr("checked", false);

					if(e.sender.value() == 2600000000)
						$("input[data-ui='in_top']", __uiForm.element).parent().show();
					else
						$("input[data-ui='in_top']", __uiForm.element).parent().hide();
				}
			}).data("kendoDropDownList");
		})($("select[data-ui='region']", __uiTabStrip.contentElements[0]));

		var __cityUiAutoComplete = (function(element){
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
								url: "/api/geo/find?q="+options.data.filter.filters[0].value+"&region_id="+__regionUiSelect.value(),
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

			return $.extend(__uiAutoComplete, {
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
		})($("input[data-uiAutoComplete='city']", __uiTabStrip.contentElements[0]));

		var __tagsUiSelect = (function(element){
			return $(element).kendoMultiSelect({
				dataValueField: "id",
				dataTextField: "name",
				dataSource: ({
					data: eval($(">script", element).text())
				})
			}).data("kendoMultiSelect");
		})($("select[data-ui='tags']", __uiWindow.element));
		
		$("a[data-action='manage_tags']", __uiTabStrip.contentElements[0]).click(function(){
			__w.tags.open();
		});
		
		var __w = new Object();
		([
			{
				name: "categories",
				element: $("div[ui-window='admin.news.categories_form']"),
				actions: ({
					get_list: "/admin/news/j_get_categories",
					save_item: "/admin/news/j_save_category",
					delete_item: "/admin/news/j_delete_category"
				}),
				sender: __categoriesUiSelect,
				needEmptyItem: true
			},
			{
				name: "tags",
				element: $("div[ui-window='admin.news.tags_form']"),
				actions: ({
					get_list: "/admin/news/j_get_tags",
					save_item: "/admin/news/j_save_tag",
					delete_item: "/admin/news/j_delete_tag"
				}),
				sender: __tagsUiSelect,
				needEmptyItem: false
			}
		]).forEach(function(token){
			__w[token.name] = (function(element){
				var __uiWindow = (new Window(element)).afterOpen(function(){
					$.post(token.actions.get_list, function(response){
						if( ! response.success)
							return;
						__listUiTable.dataSource.data(response.list);
					}, "json");
				}).afterClose(function(){
					__formUiWindow.open();
					$.post(token.actions.get_list, {
						is_public: 1,
						use_current_lang: 1
					}, function(response){
						if( ! response.success)
							return;
						
						if(token.needEmptyItem)
							response.list = ([{id: 0, name: "\u2014"}]).concat(response.list);
						
						token.sender.dataSource.data(response.list);
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

					$.post(token.actions.save_item, {
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

							$.post(token.actions.save_item, {
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
						$.post(token.actions.save_item, {
							id: id,
							is_public: state
						}, function(){
							__uiTable.dataSource.get(id).set("is_public", state);
						}, "json");
					});

					var __deleteItem = (function(id, text){
						if(confirm(text)){
							$.post(token.actions.delete_item, {
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
								__deleteItem($(__element).attr("data-id"), $(__element).attr("data-text"));
								break;
						}
					});

					return __uiTable;
				})($("table[data-ui='list']", __uiWindow.element));

				return __uiWindow;
			})(token.element);
		});
		
		var __createdAtUiInput = $("input[data-ui='created_at']", __uiTabStrip.contentElements[0]).kendoDateTimePicker({
			format: "dd MMMM yyyy hh:mm"
		}).data("kendoDateTimePicker");
		
		var __textUiEditor = (function(element){
			var __uiEditor = $(element).kendoEditor({
				tools: [
					"formatting",
					"bold",
					"italic",
					"underline",
					"justifyLeft",
					"justifyCenter",
					"justifyRight",
					"justifyFull",
					"createLink",
					"unlink",
					"cleanFormatting",
					({
						name: "setBlockquote",
						template: "<a role=\"button\" href=\"javascript:void(0);\" class=\"k-tool k-group-start k-group-end icon\"><i class=\"icon-quote\" style=\"padding: 0 7px\"></i></a>",
						exec: (function(e){
							var __html = __uiEditor.selectedHtml();
							__uiEditor.value(__uiEditor.value()
									.replace(__html, "<blockquote>"+__html+"</blockquote>"))
						})
					}),
					"viewHtml"
				]
			}).data("kendoEditor");

			$("<div class=\"fleft\" />").css({
				padding: "11px 15px",
				marginRight: "5px",
				backgroundColor: "#A7A7A7",
				color: "white"
			}).html($(element).attr("data-label")).insertBefore(__uiEditor.toolbar.element);

			return __uiEditor;
		})($("textarea[data-ui='text']", __uiTabStrip.contentElements[0]));
		
		var __imagesUiView = (function(element){
			var __listUiBox = $(">div[data-uiBox='list']", element),
				__imageTemplate = kendo.template($(">script", __listUiBox).html()),
				__uploaderUiBox = $(">div[data-uiBox='uploader']", element);
			
			$(__listUiBox).click(function(e){
				var __element = $(e.srcElement);
				if(typeof $(__element).attr("data-action") == "undefined")
					__element = $($(__element).parents("*[data-action]").eq(0));

				switch($(__element).attr("data-action")){
					case "delete":
						$($(__element).parents("div").eq(0)).remove();
						__refreshWidth();
						break;
				}
			});
			
			$(">a>input", __uploaderUiBox).css({
				opacity: 0
			}).fileupload({
				dataType: "json",
				url: "/s/storage/j_save?extension[]=jpg&extension[]=jpeg&extension[]=png",
				sequentialUploads: true,
				done: (function(event, data){
					if( ! data.result.files[0]){
						alert("Файл, який ви завантажуєте, не підтримується");
						return;
					}
					
					__addImage(data.result.files[0]);
				})
			});
			
			var __refreshWidth = (function(){
				var __width = 502;
				if(($(">div", __listUiBox).length - 1) > 6)
					__width = 667;
				$(__listUiBox).css("width", __width+"px");
			});
			
			var __addImage = (function(hash){
				$(__imageTemplate({
					hash: hash
				})).insertBefore($(">div:last-child", __listUiBox));
				__refreshWidth();
			});
			
			var __cleanUp = (function(){
				$(">div:not(:last-child)", __listUiBox).remove();
			});
			
			var __setImages = (function(data){
				data.forEach(function(hash){
					__addImage(hash);
				});
			});
			
			return ({
				addImage: __addImage,
				cleanUp: __cleanUp,
				setImages: __setImages,
				getImages: (function(){
					return $.map($(">div[data-hash]", __listUiBox), function(element){
						return $(element).attr("data-hash");
					});
				})
			});
		})($("div[data-uiView='images']", __uiWindow.element));
		
		var __electionCandidatesUiSelect = (function(element){
			return $(element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "name",
				dataSource: ({
					data: ([{id: 0, name: "\u2014"}]).concat(eval($(">script", element).text()))
				})
			}).data("kendoDropDownList");
		})($("select[data-ui='election_candidates']", __uiForm.element));
		
		$("input[data-ui='in_election']", __uiForm.element).change(function(){
			__electionCandidatesUiSelect.value(0);
			__electionCandidatesUiSelect.enable(false);
			$(__electionCandidatesUiSelect.wrapper).css("opacity", .3);
			
			if($(this).attr("checked") != "checked")
				return;
			
			__electionCandidatesUiSelect.enable(true);
			$(__electionCandidatesUiSelect.wrapper).css("opacity", 1);
		}).change();
		
		$("a[data-action='submit']", __uiWindow.element).click(function(){
			__uiForm.send();
		});
		
		$("a[data-action='cancel']", __uiWindow.element).click(function(){
			__uiWindow.close();
		});
		
		return $.extend(__uiWindow, {
			setData: (function(data){
				__uiForm.attr("data-id", typeof data.id != "undefined" ? data.id : 0);
				
				$("input#title", __uiForm.element).val(typeof data.title != "undefined" ? data.title : "");

				__categoriesUiSelect.value(typeof data.category_id != "undefined" ? data.category_id : 0);
				$(__regionUiSelect.element).attr("data-value", typeof data.region != "undefined" ? data.region : 0);
				$(__cityUiAutoComplete.element).attr({
					"data-id": typeof data.city != "undefined" ? data.city.id : 0,
					"data-title": typeof data.city != "undefined" ? data.city.title : ""
				});
				__categoriesUiSelect.options.change({
					sender: __categoriesUiSelect
				});

				$("input[data-ui='in_main_block']", __uiForm.element).attr("checked",
					typeof data.in_main_block != "undefined" && data.in_main_block != 0
						? true
						: false);

				$("input[data-ui='in_volya_people']", __uiForm.element).attr("checked",
					typeof data.in_volya_people != "undefined" && data.in_volya_people != 0
						? true
						: false);

				$("input[data-ui='in_top']", __uiForm.element).attr("checked",
					typeof data.in_top != "undefined" && data.in_top != 0
						? true
						: false);

				if(data.region == 2600000000)
					$("input[data-ui='in_top']", __uiForm.element).parent().show();

				__tagsUiSelect.value(typeof data.tags_ids != "undefined" ? data.tags_ids : []);
				__createdAtUiInput.value(kendo.parseDate(typeof data.created_at != "undefined" ? data.created_at : new Date()));
				$("textarea#announcement", __uiForm.element).val(typeof data.announcement != "undefined" ? data.announcement : "");
				__textUiEditor.value(typeof data.text != "undefined" ? data.text : "");
				
				$("input#meta_title", __uiForm.element).val(typeof data.meta_title != "undefined" ? data.meta_title : "");
				$("textarea#meta_description", __uiForm.element).val(typeof data.meta_description != "undefined" ? data.meta_description : "");
				$("textarea#meta_keywords", __uiForm.element).val(typeof data.meta_keywords != "undefined" ? data.meta_keywords : "");
				
				$("input[data-ui='in_election']", __uiForm.element)
						.attr("checked", typeof data.in_election != "undefined" ? (data.in_election != 1 ? false : true) : false)
						.change();
				
				__electionCandidatesUiSelect
						.value(typeof data.election_candidate_id != "undefined" ? data.election_candidate_id : 0);
				
				__imagesUiView.cleanUp();
				if(typeof data.images != "undefined")
					__imagesUiView.setImages(data.images);
			})
		});
	})();
	
	$("a[data-action='create']", __section).click(function(){
		__formUiWindow.open();
		__formUiWindow.setData([]);
	});
	
	var __listUiTable = (function(element){
		var __data = eval($(">script#data", element).text()),
			__templates = $(">script[type='text/x-kendo-template']", element);

		__templates.each(function(i){
			if(typeof __data.columns[i] == "undefined")
				return;
			__data.columns[i]["template"] = kendo.template($(this).html());
		});
		
		var __editItem = (function(id){
			$.post("/admin/news/j_get_item", {
				id: id
			}, function(response){
				if( ! response.success)
					return;
				__formUiWindow.open();
				__formUiWindow.setData(response.item);
			}, "json");
		});
		
		var __updateItem = (function(id, field, value){
			$.post("/admin/news/j_update_item", {
				id: id,
				field: field,
				value: value
			}, function(response){
				if( ! response.success)
					return;
				__uiTable.dataSource.get(id).set(field, value);
			}, "json");
		});
		
		var __deleteItem = (function(id, text){
			if(confirm(text)){
				$.post("/admin/news/j_delete_item", {
					id: id
				}, function(){
					__uiTable.dataSource.remove(__uiTable.dataSource.get(id));
				}, "json");
			}
		});
		
		var __uiTable = $(element).kendoGrid($.extend(__data, {
			dataBound: (function(e){
				if( ! (e.sender.dataSource.data().length > 0))
					$(e.sender.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));
			})
		})).data("kendoGrid");
		
		$(__uiTable.tbody).click(function(event){
			var __element = $(event.srcElement);
			if(typeof $(__element).attr("data-action") == "undefined")
				__element = $($(__element).parents("*[data-action]").eq(0));

			switch($(__element).attr("data-action")){
				case "edit":
					__editItem($(__element).attr("data-id"));
					break;

				case "publicate":
					__updateItem($(__element).attr("data-id"), "is_public", ($(__element).attr("checked") != "checked" ? 0 : 1));
					break;

				case "delete":
					__deleteItem($(__element).attr("data-id"), $(__element).attr("data-text"));
					break;
			}
		});
		
		return __uiTable;
	})($("table[data-ui='list']", __section));
	
});