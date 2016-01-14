$(document).ready(function(){

	var __section = $("body>section>div.section");

	var __formUiWindow = (function(element){
		var __uiWindow = (new Window(element)).afterOpen(function(){
			__geo.initialize();
			__uiWindow.checkPosition();
		});

		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function(){
			var __data = {
				id: $(__uiWindow.element).attr("data-id"),
				geo: __geo.fn.geo()
			};

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

		var __geo = (function(ui){
			var __article;

			var __regionUiDDL = (function(ui){
				return $(ui).kendoDropDownList({
					open: function(e){
						$(e.sender.list).width($(e.sender.wrapper).width() - 2);
					},
					change: function(e){

						if(e.sender.value() == 0){
							__article.fn.geo(null);
							__areaUiDDL.fn.hide();
							__locationUiCB.fn.hide();
							__cityDistrictUiDDL.fn.hide();
							return;
						}

						__article.fn.geo( e.sender.value() );

						if(e.sender.value() == "8000000000") {
							__areaUiDDL.fn.hide();
							__locationUiCB.fn.hide();

							return __cityDistrictUiDDL.fn.show(e.sender.value(), function (e) {
								if (e.visible)
									return;
							});
						} else {
							__areaUiDDL.fn.show(e.sender.value());
						}
					}
				}).data('kendoDropDownList');
			})($("select[data-ui-ddl='region']", ui));

			var __areaUiDDL = (function(ui){
				var __ddl;
				return $.extend((__ddl = $(ui).kendoDropDownList({
					dataValueField: 'id',
					dataTextField: 'title',
					open: function(e){
						$(e.sender.list).width($(e.sender.wrapper).width() - 2);
					},
					change: function(e){

						__article.fn.geo(e.sender.value() != 0 ? e.sender.value() : undefined);

						if(e.sender.value().match(/[0-9]{2}2[0-9]{7}/i)) {
							__cityDistrictUiDDL.fn.hide();
							return __locationUiCB.fn.show(e.sender.value());
						} else {
							__locationUiCB.fn.hide();

							return __cityDistrictUiDDL.fn.show(e.sender.value(), function (e) {
								if (e.visible)
									return;

								__cityDistrictUiDDL.fn.hide();
							});
						}
					}
				}).data('kendoDropDownList')), {
					fn: {
						show: function(code, fn){
							__article.preloading.show();
							__cityDistrictUiDDL.fn.hide();

							$.post('/api/geo/cities_with_districts/'+code, function(r){
								var __isVisible = (r.success && r.list.length > 0 ? true : false);

								__article.preloading.hide();

								if(__isVisible){
									$(">tr[data-id='"+$(ui).attr('data-ui-ddl')+"']", $($(ui).parents('tbody').eq(0))).show();
									__ddl.dataSource.data(([{id: 0, title: '\u2014'}]).concat(r.list));
									__ddl.value($(ui).attr('data-value'));
									$(ui).attr('data-value', 0);
									__ddl.options.change({
										sender: __ddl
									});
								}

								if(typeof fn == 'function')
									fn({
										visible: __isVisible,
										code: code
									});

								__uiWindow.checkPosition();
							}, 'json');

							return this;
						},
						hide: function(){
							$(">tr[data-id='"+$(ui).attr('data-ui-ddl')+"']", $($(ui).parents('tbody').eq(0))).hide();
							return this;
						}
					}
				});
			})($("select[data-ui-ddl='area']", ui));

			var __locationUiCB = (function(ui){
				var __cb, __code = '',
					__re = new RegExp(/[0-9]{10}/);
				return $.extend((__cb = $(ui).kendoComboBox({
					dataValueField: 'id',
					dataTextField: 'title',
					filter: 'contains',
					autoBind: false,
					minLength: 3,
					template: kendo.template($(">script[type='text/x-kendo-template']", ui).html()),
					dataSource: {
						serverFiltering: true,
						transport: {
							read: function(options){
								var __filter = options.data.filter;

								if( ! ($("span.k-preloading", __cb.wrapper).length > 0))
									$("<span class='k-preloading'><span class='k-icon k-loading' /></span>").insertBefore(
										$(">span.k-dropdown-wrap>span.k-select", __cb.wrapper)
									);

								if(
									typeof __filter == 'undefined'
									|| ! (__filter.filters.length > 0)
									|| __filter.filters[0].value == ""
								)
									return options.success(__cb.dataSource.data());

								$("span.k-preloading", __cb.wrapper).css('opacity', 1);

								$.ajax({
									url: '/api/geo/find/'+__code+'?q='+__filter.filters[0].value,
									dataType: "jsonp",
									complete: function(xhr){
										var __res = eval("("+xhr.responseText+")");
										options.success(__res.success != false ? __res.list : []);
										$("span.k-preloading", __cb.wrapper).css('opacity', 0);
									}
								});
							}
						},
						scheme: {model: {id: 'id'}}
					},
					open: function(e){
						$(e.sender.list).width($(e.sender.wrapper).width() - 2);
					},
					change: function(e){

						if( ! __re.test(e.sender.value())){
							__article.fn.geo(undefined);
							__cityDistrictUiDDL.fn.hide();
							return;
						}

						__article.fn.geo(e.sender.value());
						__cityDistrictUiDDL.fn.show(e.sender.value(), function(e){
							if(e.visible)
								return;
							__cityDistrictUiDDL.fn.hide();
						});
					}
				}).data('kendoComboBox')), {
					fn: {
						show: function(code){
							__code = code;
							$(">tr[data-id='"+$(ui).attr('data-ui-cb')+"']", $($(ui).parents('tbody').eq(0))).show();
							__cb.dataSource.data($('>script#data', ui).length > 0 ? eval($('>script#data', ui).html()) : []);
							$('>script#data', ui).remove();
							__cb.value($(ui).attr('data-value'));
							$(ui).attr('data-value', '');
							__cb.options.change({
								sender: __cb
							});

							__uiWindow.checkPosition();

							return this;
						},
						hide: function(){
							$(">tr[data-id='"+$(ui).attr('data-ui-cb')+"']", $($(ui).parents('tbody').eq(0))).hide();
							return this;
						}
					}
				});
			})($("select[data-ui-cb='location']", ui));

			var __cityDistrictUiDDL = (function(ui){
				var __ddl;
				return $.extend((__ddl = $(ui).kendoDropDownList({
					dataValueField: 'id',
					dataTextField: 'title',
					open: function(e){
						$(e.sender.list).width($(e.sender.wrapper).width() - 2);
					},
					change: function(e){

						__article.fn.geo(e.sender.value() != 0 ? e.sender.value() : undefined);

						if(e.sender.value() != null && e.sender.value() > 0) {
							__article.fn.geo(e.sender.value())

							return;
						}
					}
				}).data('kendoDropDownList')), {
					fn: {
						show: function(code, fn){
							__article.preloading.show();

							if(code > 0)
								$.post('/api/geo/city_districts/'+code, function(r){
									var __isVisible = (r.success && r.list.length > 0 ? true : false);

									__article.preloading.hide();

									if(__isVisible){
										$(">tr[data-id='"+$(ui).attr('data-ui-ddl')+"']", $($(ui).parents('tbody').eq(0))).show();
										__ddl.dataSource.data(([{id: 0, title: '\u2014'}]).concat(r.list));
										__ddl.value($(ui).attr('data-value'));
										$(ui).attr('data-value', 0);
										__ddl.options.change({
											sender: __ddl
										});
									}

									if(typeof fn == 'function')
										fn({
											visible: __isVisible,
											code: code
										});

									__uiWindow.checkPosition();
								}, 'json');
							return this;
						},
						hide: function(){
							$(">tr[data-id='"+$(ui).attr('data-ui-ddl')+"']", $($(ui).parents('tbody').eq(0))).hide();
							return this;
						}
					}
				});
			})($("select[data-ui-ddl='city_district']", ui));

			return (__article = $.extend(ui, {
				__geo: null,
				initialize: function(){
					__regionUiDDL.value(0);
					__regionUiDDL.options.change({
						sender: __regionUiDDL
					});

					return this;
				},
				fn: {
					geo: function(value){
						if(typeof value == 'undefined')
							return __article.__geo;

						__article.__geo = value;
						return __article;
					}
				},
				preloading: {
					show: function(){
						$(">section>div[data-ui='preloading']", ui).show();
						return this;
					},
					hide: function(){
						$(">section>div[data-ui='preloading']", ui).hide();
						return this;
					}
				}
			})).initialize();
		})($("div[ui-box='location']", __uiWindow.element));

		$("a[data-action='save']", __uiWindow.element).click(function(){
			__uiForm.send();
		});

		$("a[data-action='cancel']", __uiWindow.element).click(function(){
			__uiWindow.close();
		});

		//var __categoriesUiSelect = (function(element){
		//	return $(element).kendoDropDownList({
		//		dataValueField: "id",
		//		dataTextField: "title",
		//		dataSource: ({
		//			data: ([{id: 0, title: "\u2014"}]).concat(eval($(">script", element).text()))
		//		})
		//	}).data("kendoDropDownList");
		//})($("select[data-ui='categories']", __uiWindow.element));

		//var __createdAtUiInput = $("input[data-ui='created_at']", __uiWindow.element).kendoDateTimePicker({
		//	format: "dd MMMM yyyy"
		//}).data("kendoDateTimePicker");

		$("a[data-action='manage_categories']", __section).click(function(){
			__w.categories.open();
		});

		//var __w = new Object();
		//([
		//	{
		//		name: "categories",
		//		element: $("div[ui-window='register.documents.categories_form']"),
		//		actions: ({
		//			get_list: "/register/documents/j_get_categories",
		//			save_item: "/register/documents/j_save_category",
		//			delete_item: "/register/documents/j_delete_category"
		//		}),
		//		sender: __categoriesUiSelect,
		//		needEmptyItem: true
		//	}
		//]).forEach(function(token){
		//	__w[token.name] = (function(element){
		//		var __uiWindow = (new Window(element)).afterOpen(function(){
		//			$.post(token.actions.get_list, function(response){
		//				if( ! response.success)
		//					return;
		//				__listUiTable.dataSource.data(response.list);
		//			}, "json");
		//		});
		//
		//		$("a[data-action='add']", __uiWindow.element).click(function(){
		//			if($("input#title", __uiWindow.element).val() == ""){
		//				$("input#title", __uiWindow.element).css("borderColor", "red");
		//				setTimeout(function(){
		//					$("input#title", __uiWindow.element).css("borderColor", "");
		//				}, 2000);
		//				return;
		//			}
		//
		//			$.post(token.actions.save_item, {
		//				title: $("input#title", __uiWindow.element).val()
		//			}, function(response){
		//				if( ! response.success)
		//					return;
		//
		//				$("input#title", __uiWindow.element).val("");
		//				__listUiTable.dataSource.add(response.item);
		//			}, "json");
		//		});
		//
		//		var __listUiTable = (function(element){
		//			var __data = eval($(">script#data", element).text()),
		//				__templates = $(">script[type='text/x-kendo-template']", element);
		//
		//			__templates.each(function(i){
		//				if(typeof __data.columns[i] == "undefined")
		//					return;
		//				__data.columns[i]["template"] = kendo.template($(this).html());
		//			});
		//
		//			var __uiTable = $(element).kendoGrid($.extend(__data, {
		//				dataBound: (function(e){
		//					if( ! (e.sender.dataSource.data().length > 0))
		//						$(e.sender.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));
		//
		//					__uiWindow.checkPosition();
		//				})
		//			})).data("kendoGrid");
		//
		//			var __editItem = (function(element){
		//				var __parentDiv = $($(element).parents("div").eq(0)),
		//					__a = $(element).clone(),
		//					__input = $("<input type=\"text\" class=\"textbox\" style=\"width: 100%\" />").bind("blur keyup", function(e){
		//						var __this = this;
		//
		//						if( ! ($.inArray(e.type, ["blur", "keyup"]) > -1) || (e.type == "keyup" && e.keyCode != 13))
		//							return;
		//
		//						if($(__this).val() == ""){
		//							$(__this).css("borderColor", "red");
		//							setTimeout(function(){
		//								$(__this).css("borderColor", "");
		//							}, 2000);
		//							return;
		//						}
		//
		//						$.post(token.actions.save_item, {
		//							id: $(__a).attr("data-id"),
		//							title: $(__this).val()
		//						}, function(){
		//							$(__parentDiv).css("padding", "")
		//								.append($(__a));
		//							$(__a).html($(__this).val());
		//							$(__this).remove();
		//						}, "json");
		//					});
		//
		//				$(element).remove();
		//
		//				$(__parentDiv).css("padding", 0)
		//					.append($(__input).val($(__a).html()));
		//
		//				$(__input).focus();
		//			});
		//
		//			var __deleteItem = (function(id, text){
		//				if(confirm(text)){
		//					$.post(token.actions.delete_item, {
		//						id: id
		//					}, function(response){
		//						if( ! response.success)
		//							return;
		//						__uiTable.dataSource.remove(__uiTable.dataSource.get(id));
		//					}, "json");
		//				}
		//			});
		//
		//			$(__uiTable.tbody).click(function(event){
		//				var __element = $(event.srcElement);
		//				if(typeof $(__element).attr("data-action") == "undefined")
		//					__element = $($(__element).parents("*[data-action]").eq(0));
		//
		//				switch($(__element).attr("data-action")){
		//					case "edit":
		//						__editItem(__element);
		//						break;
		//
		//					case "delete":
		//						__deleteItem($(__element).attr("data-id"), $(__element).attr("data-text"));
		//						break;
		//				}
		//			});
		//
		//			return __uiTable;
		//		})($("table[data-ui='list']", __uiWindow.element));
		//
		//		return __uiWindow;
		//	})(token.element);
		//});

		return $.extend(__uiWindow, {
			getItemAndOpenWindow: (function(id){
				if(id > 0)
					$.post("/register/documents/j_get_document", {
						id: id
					}, function(response){
						if( ! response.success)
							return;

						var __item = response.item;

						$(__uiWindow.element).attr("data-id", __item.id);
						//__categoriesUiSelect.value(__item.cid);
						//__categoriesUiSelect.enable(false);

						$("#number", __uiWindow.element).val(__item.number);
						$("#number", __uiWindow.element).attr("disabled", true);

						//__createdAtUiInput.value(kendo.parseDate(typeof data.created_at != "undefined" ? data.created_at : new Date()));
						//__createdAtUiInput.enable(false);

						if(typeof __item.images != "undefined")
							__imagesUiView.setImages(__item.images);

						__uiWindow.open();
					}, "json");

				$(__uiWindow.element).removeAttr("data-id");
				//__categoriesUiSelect.value(0);
				//__categoriesUiSelect.enable(true);

				$("#number", __uiWindow.element).removeAttr("disabled");
				$("#number", __uiWindow.element).val("");

				//__createdAtUiInput.value(0);
				//__createdAtUiInput.enable(true);
			}),
		});

	}($("div[ui-window='inquirers.admin.inquirer']")));

	$("a[data-action='create']", __section).click(function(){
		__formUiWindow.getItemAndOpenWindow();
		__formUiWindow.open();
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
				case "edit":
					__formUiWindow.getItemAndOpenWindow($(__a).attr("data-id"));
					break;
			}
		});

		if( ! ($(">tr", __uiTable.tbody).length > 0))
			$(__uiTable.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));

		return __uiTable;
	}($("table[data-ui='list']", __section)));

	(function(previewUiBox, imagesUiBox, imageViewerUiWindow){
		var __uiWindow = new Window(imageViewerUiWindow);

		if( ! ($(">div", imagesUiBox).length > 1)){
			$(previewUiBox).parent().hide();
			return;
		}

		$(previewUiBox).click(function(){
			var __image = new Image();
			__image.src = "/s/img/thumb/630x/"+$(this).attr("data-hash");

			__image.onload = (function(){
				$("img", __uiWindow.element).attr("src", __image.src);
				__uiWindow.open(function(){
					__uiWindow.checkPosition();
				});
			});
		});
	})(
		$("div[data-uiBox='preview']", __section),
		$("div[data-uiBox='images']", __section),
		$("div[ui-window='register.documents.scans_viewer']")
	);
});