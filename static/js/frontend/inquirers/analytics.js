$(document).ready(function(){

	var element = $("div.filter");

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
	})($("div[ui-box='location']", element));

	var blocks = $("select[data-ui-ddl='blocks']", element).kendoDropDownList({
		dataTextField: "text",
		dataValueField: "value"
	}).data("kendoDropDownList");

	var questions = $("select[data-ui-ddl='questions']", element).kendoDropDownList({
		dataTextField: "text",
		dataValueField: "value"
	}).data("kendoDropDownList");

	var answers = $("input[data-ui-ddl='answers']", element).kendoMultiSelect({
		dataTextField: "text",
		dataValueField: "value"
	}).data("kendoMultiSelect");
});