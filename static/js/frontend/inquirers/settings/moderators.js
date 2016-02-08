$(document).ready(function(){
	
	var __section = $("body>section>div.section"),
		__toolbarUiBox = $(">div>div[data-uiBox='toolbar']", __section);
	
	var __formUiWindow = (function(element){
		var __uiWindow = new Window(element);

		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function(){
			var __data = {
				id: $(__uiWindow.element).attr("data-id"),
				geo: __geo.fn.geo(),
				user: __membersUiSelect.value()
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

		$("a[data-action='save']", __uiWindow.element).click(function(){
			__uiForm.send();
		});

		$("a[data-action='cancel']", __uiWindow.element).click(function(){
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
				initialize: function(code){
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

		var __membersUiSelect = (function(element){
			var __inputTemplate = kendo.template($(">script#input_template", $($(element).parents("td").eq(0))).html());

			return $(element).kendoAutoComplete({
				placeholder: "Почніть вводити email",
				dataValueField: "id",
				dataTextField: "name",
				filter: "contains",
				minLength: 3,
				autoBind: false,
				template: __inputTemplate,
				dataSource: {
					serverFiltering: true,
					transport: {
						read: (function(options){
							$.ajax({
								url: "/api/users/find?q="+options.data.filter.filters[0].value + "&geo=" + __geo.fn.geo(),
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
				}
			}).data("kendoAutoComplete");
		})($("input[data-uiAutoComplete='q']", __uiWindow.element));

		return $.extend(__uiWindow, {
			getItemAndOpenWindow: (function(id){
				if(id > 0)
					$.post("/inquirers/settings/moderators/get_moderator", {
						id: id
					}, function(response){
						if( ! response.success)
							return;

						var __item = response.item;

						$(__uiWindow.element).attr("data-id", __item.id);

						__geo.fn.geo(__item.geo);

						__membersUiSelect.value(__item.user.first_name + " " + __item.user.last_name);

						__uiWindow.open();
					}, "json");

				$(__uiWindow.element).removeAttr("data-id");
				__geo.fn.geo(0);

				__membersUiSelect.value([]);
			}),
		});

	}($("div[ui-window='inquirers.settings.moderators.form']")));

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

});