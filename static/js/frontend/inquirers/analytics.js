$(document).ready(function(){

	var element = $("div.section");

	var filter = (function(element){

		var geo = (function(ui){
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
						},
						init: function(code){
							$.post("/api/geo/city/" + code, {}, function(res){

								console.log( res );

								__cb.dataSource.insert(res.item);
							}, "json");
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

						$.post("/inquirers/analytics/get_blocks_by_geo", {
							"geo": __article.__geo
						}, function(res){

							blocks.dataSource.data(([{value: 0, title: "Оберіть блок питань"}]).concat(res.list));
							blocks.value(0);

							questions.dataSource.data(([{id: 0, title: "Оберіть питання"}]));
							questions.enable(false);
							questions.value(0);

							answers.dataSource.data([]);
							answers.enable(false);
							answers.value(0);

						}, "json");

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

			return {
				geo: geo
			};
		})($("div[ui-box='location']", element));

		var blocks = $("select[data-ui-ddl='blocks']", element).kendoDropDownList({
			dataTextField: "title",
			dataValueField: "id",
			change: function(e){
				if(e.sender.value() > 0)
					$.post("/inquirers/analytics/get_questions_by_block", {
						"bid": e.sender.value()
					}, function(res){
						questions.dataSource.data(([{id: 0, title: "Оберіть питання"}]).concat(res.list));
						questions.enable();
					}, "json");
				else {
					questions.dataSource.data(([{id: 0, title: "Оберіть питання"}]));
					questions.enable(false);
					questions.value(0);
				}

				answers.dataSource.data([]);
				answers.enable(false);
				answers.value(0);
			}
		}).data("kendoDropDownList");

		var questions = $("select[data-ui-ddl='questions']", element).kendoDropDownList({
			dataTextField: "title",
			dataValueField: "id",
			change: function(e){
				if(e.sender.value() > 0)
					$.post("/inquirers/analytics/get_answers_by_question", {
						"qid": e.sender.value()
					}, function(res){
						answers.dataSource.data(res.list);
						answers.enable();
					}, "json");
				else {
					answers.dataSource.data([]);
					answers.enable(false);
				}
			}
		}).data("kendoDropDownList");

		var answers = $("input[data-ui-ddl='answers']", element).kendoMultiSelect({
			dataTextField: "title",
			dataValueField: "id"
		}).data("kendoMultiSelect");

		$("a[data-action='filter']", element).click(function(){

			var data = {
				geo: geo.fn.geo(),
				block: blocks.value(),
				question: questions.value(),
				answers: answers.value()
			};

			$.post("/inquirers/analytics/filter", data,
				function(res){
					if( ! res.success)
						return;

					supportersUiTable.dataSource.data(res.list);
				}, "json");
		});

	})($("div.filter", element));

	$("[data-id='tabstrip']", element).kendoTabStrip({
		animation:  {
			open: {
				effects: "fadeIn"
			}
		}
	});

	var supportersUiTable = (function (element) {
		var __data = eval($(">script#data", element).text()),
			__templates = $(">script[type='text/x-kendo-template']", element);

		__templates.each(function (i) {
			if (typeof __data.columns[i] == "undefined")
				return;
			__data.columns[i]["template"] = kendo.template($(this).html());
		});

		var __uiTable = $(element).kendoGrid($.extend(__data, {
			dataBound: (function (e) {
				if (!(e.sender.dataSource.data().length > 0))
					$(e.sender.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));
			})
		})).data("kendoGrid");

		$(__uiTable.tbody).click(function (event) {
			var __element = $(event.srcElement);
			if (typeof $(__element).attr("data-action") == "undefined")
				__element = $($(__element).parents("*[data-action]").eq(0));

			switch ($(__element).attr("data-action")) {
				case "view":
					viewerUiWindow.getItemAndOpenWindow($(__element).attr("data-id"));
					break;
			}
		});

		return __uiTable;
	})($("table[data-ui='supporters']", element));

	var viewerUiWindow = (function(element){
		var __uiWindow = (new Window(element)).afterClose(function(){
			$("[data-key]").not(".reserved").html("");
			$(".val", $("[data-key].reserved")).remove();

			$("[data-key].added").remove();
			$("[data-id='form']", __uiWindow.element).html("");
			$("[data-id='form']", __uiWindow.element).masonry('destroy');
		}).beforeOpen(function(){
			$("[data-id='form']", __uiWindow.element).masonry({
				itemSelector: '.block',
				columnWidth: 330
			});
		});
		var __profileTable = $("table#profile_info", __uiWindow.element);

		$("a[data-action='close']", __uiWindow.element).click(function(){
			__uiWindow.close();
		});

		return $.extend(__uiWindow, {
			getItemAndOpenWindow: (function(id){
				if(id > 0)
					$.post("/inquirers/analytics/get_form", {
						id: id
					}, function(response){
						if( ! response.success)
							return;

						var __form = response.item.form;
						var __profile = response.item.profile;
						var __reservedFields = [
							"id", "created_at", "modified_at"
						];

						$.each(__profile, function(key, val){
							if(__reservedFields.indexOf(key) >= 0)
								return;

							if($("[data-key='" + key + "']", __profileTable).length > 0) {
								if($(".title", $("[data-key='" + key + "']")).length == 0)
									$("[data-key='" + key + "']")
										.prepend(
											$("<td />")
												.addClass("title")
												.html(val.field_title)
										);

								var value = $("<td />").addClass("val");

								switch (key) {
									case "email":
										value.html(
											"<a href='mailto:" + (typeof val == "object" ? val.value : val) + "'>" + (typeof val == "object" ? val.value : val) + "</a>"
										);

										break;

									case "phone":
										value.html(
											"<a href='tel:" + (typeof val == "object" ? val.value : val) + "'>" + (typeof val == "object" ? val.value : val) + "</a>"
										);

										break;

									default:
										value.html(
											typeof val == "object" ? val.value : val
										);
										break;
								}

								$("[data-key='" + key + "']").append(value).show();
							} else
								__profileTable
									.append(
										$("<tr />")
											.attr("class", "added")
											.attr("data-key", key)
											.prepend(
												$("<td />")
													.addClass("title")
													.html(val.field_title)
											)
											.append(
												$("<td />")
													.addClass("val")
													.html(val.value)
											)
									);

						});

						$.each(__form.blocks, function(id, block){

							var __block = $("<div />")
								.addClass("block")
								.html("<h3 class='blockTitle'>" + block.title + "</h3>");

							$.each(block.questions, function(id, question){

								var __question = $("<div />")
									.addClass("question")
									.html("<div class='marker'></div>" + "<p class='questionTitle'>" + question.title + "</p>");

								if(question.is_text == 1)
									$(__question).append(
										$("<div />")
											.addClass("answer")
											.append(
												$("<div />")
													.addClass("textAnswer")
													.html(question.answer)
											)
									);
								else
									$.each(question.answers, function(id, answer){

										if(typeof answer.selected == "object"){
											var __answers = $("<div />")
												.addClass("answer")
												.html('<div class="checkbox"><i class="icon icon-ok"></i></div>' + "<p class='answerTitle'>" + answer.title + "</p>");

											if(typeof answer.selected.value == "string") {

												$("p.answerTitle", __answers).html($("p.answerTitle", __answers).html() + " :");

												__answers
													.append(
														$("<div />")
															.addClass("textAnswer")
															.css("margin-left", "27px")
															.html(answer.selected.value)
													);
											}
										}

										$(__question).append(__answers);

									});

								$(__block).append(__question);

							});

							$("[data-id='form']", __uiWindow.element).append(__block);
						});

						__uiWindow.open();
					}, "json");
			})
		});

	}($("[ui-window='inquirers.analytics.viewer']")));

	$('#container').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: 'Аналіз відповідей'
		},
		xAxis: {
			type: 'category'
		},
		yAxis: {
			title: {
				text: 'Total percent market share'
			}
		},
		legend: {
			enabled: false
		},
		plotOptions: {
			series: {
				borderWidth: 0,
				dataLabels: {
					enabled: true,
					format: '{point.y:.1f}%'
				}
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
			pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
		},
		series: [{
			name: 'Блоки питань',
			colorByPoint: true,
			data: [{
				name: 'Местная полиция',
				y: 56.33,
				drilldown: '1'
			}, {
				name: 'Образование',
				y: 24.03,
				drilldown: '2'
			}, {
				name: 'Комунальщики',
				y: 10.38,
				drilldown: '3'
			}, {
				name: 'Медицина',
				y: 14.77,
				drilldown: '4'
			}]
		}],
		drilldown: {
			series: [{
				name: 'Местная полиция',
				id: '1',
				data: [
					{
						name: 'Вы давали взятку ?',
						y: 56.33,
						drilldown: '1.1'
					},
					{
						name: 'Они превышали полномочия ?',
						y: 36.13,
						drilldown: '1.2'
					},
					{
						name: 'Они выполняют свои обязанности ?',
						y: 46.33,
						drilldown: '1.3'
					}
				]
			},{
				name: 'Образование',
				id: '2',
				data: [
					{
						name: 'Вас влаштовує рівень освіти ?',
						y: 26.33,
						drilldown: '2.1'
					},
					{
						name: 'Ви давали хабаря працівникам освіти ?',
						y: 61,
						drilldown: '2.2'
					}
				]
			},{
				name: 'Комунальщики',
				id: '3',
				data: [
					{
						name: 'У Вашому районі прибирають вулиці ?',
						y: 16.33,
						drilldown: '3.1'
					},
					{
						name: 'У Вашому районі вивозять сміття ?',
						y: 86.13,
						drilldown: '3.2'
					},
					{
						name: 'У Вашому районі прибирають сніг ?',
						y: 26.33,
						drilldown: '3.3'
					}
				]
			},{
				name: 'Медицина',
				id: '4',
				data: [
					{
						name: 'Ви задоволені рівнем надання послуг ?',
						y: 56.33,
						drilldown: '4.1'
					},
					{
						name: 'Ви давали хабаря лікарям ?',
						y: 36.13,
						drilldown: '4.2'
					},
					{
						name: 'Ви задоволені рівнем лікарень ?',
						y: 46.33,
						drilldown: '4.3'
					}
				]
			},{
				name: 'Вы давали взятку ?',
				id: '1.1',
				data: [
					{
						name: 'Сумська обл.',
						y: 36.33
					},
					{
						name: 'Київська обл.',
						y: 56.33
					},
					{
						name: 'Хмельницька обл.',
						y: 16.33
					},
					{
						name: 'Франківська обл.',
						y: 6.33
					}
				]
			},{
				name: 'Они превышали полномочия ?',
				id: '1.2',
				data: [
					{
						name: 'Сумська обл.',
						y: 11
					},
					{
						name: 'Київська обл.',
						y: 31
					},
					{
						name: 'Хмельницька обл.',
						y: 13
					},
					{
						name: 'Франківська обл.',
						y: 21
					}
				]
			},{
				name: 'Они выполняют свои обязанности ?',
				id: '1.3',
				data: [
					{
						name: 'Сумська обл.',
						y: 64
					},
					{
						name: 'Київська обл.',
						y: 97
					},
					{
						name: 'Хмельницька обл.',
						y: 42
					},
					{
						name: 'Франківська обл.',
						y: 3
					}
				]
			},{
				name: 'Вас влаштовує рівень освіти ?',
				id: '2.1',
				data: [
					{
						name: 'Сумська обл.',
						y: 64
					},
					{
						name: 'Київська обл.',
						y: 97
					},
					{
						name: 'Хмельницька обл.',
						y: 42
					},
					{
						name: 'Франківська обл.',
						y: 3
					}
				]
			},{
				name: 'Ви давали хабаря працівникам освіти ?',
				id: '2.2',
				data: [
					{
						name: 'Сумська обл.',
						y: 64
					},
					{
						name: 'Київська обл.',
						y: 97
					},
					{
						name: 'Хмельницька обл.',
						y: 42
					},
					{
						name: 'Франківська обл.',
						y: 3
					}
				]
			},{
				name: 'У Вашому районі прибирають вулиці ?',
				id: '3.1',
				data: [
					{
						name: 'Сумська обл.',
						y: 64
					},
					{
						name: 'Київська обл.',
						y: 97
					},
					{
						name: 'Хмельницька обл.',
						y: 42
					},
					{
						name: 'Франківська обл.',
						y: 3
					}
				]
			},{
				name: 'У Вашому районі вивозять сміття ?',
				id: '3.2',
				data: [
					{
						name: 'Сумська обл.',
						y: 64
					},
					{
						name: 'Київська обл.',
						y: 97
					},
					{
						name: 'Хмельницька обл.',
						y: 42
					},
					{
						name: 'Франківська обл.',
						y: 3
					}
				]
			},{
				name: 'У Вашому районі прибирають сніг ?',
				id: '3.3',
				data: [
					{
						name: 'Сумська обл.',
						y: 64
					},
					{
						name: 'Київська обл.',
						y: 97
					},
					{
						name: 'Хмельницька обл.',
						y: 42
					},
					{
						name: 'Франківська обл.',
						y: 3
					}
				]
			},{
				name: 'Ви задоволені рівнем надання послуг ?',
				id: '4.1',
				data: [
					{
						name: 'Сумська обл.',
						y: 64
					},
					{
						name: 'Київська обл.',
						y: 97
					},
					{
						name: 'Хмельницька обл.',
						y: 42
					},
					{
						name: 'Франківська обл.',
						y: 3
					}
				]
			},{
				name: 'Ви давали хабаря лікарям ?',
				id: '4.2',
				data: [
					{
						name: 'Сумська обл.',
						y: 64
					},
					{
						name: 'Київська обл.',
						y: 97
					},
					{
						name: 'Хмельницька обл.',
						y: 42
					},
					{
						name: 'Франківська обл.',
						y: 3
					}
				]
			},{
				name: 'Ви задоволені рівнем лікарень ?',
				id: '4.3',
				data: [
					{
						name: 'Сумська обл.',
						y: 64
					},
					{
						name: 'Київська обл.',
						y: 97
					},
					{
						name: 'Хмельницька обл.',
						y: 42
					},
					{
						name: 'Франківська обл.',
						y: 3
					}
				]
			}]
		}
	});
});