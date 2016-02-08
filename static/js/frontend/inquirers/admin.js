﻿var inquirers = {
	tokens: {},
	forms: {
		id: 0,
		geo: null,
		fn : {},
		init: function(){

			var __inquirersFormUiWindow = (function(element){
				var __uiWindow = (new Window(element)).afterOpen(function(){

					$.post(inquirers.tokens.blocks.actions.get_list, {
						fid: inquirers.forms.id
					}, function(res){
						__blocksUiTable.dataSource.data(res.list);
					}, "json");

				}).afterClose(function(){
					$("span", "[data-block='location_name']").attr("data-geo", "");
				});

				var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function(){

					if( ! inquirers.forms.geo || __geo.fn.geo())
						inquirers.forms.geo = __geo.fn.geo();

					var __data = {
						fid: inquirers.forms.id,
						geo: inquirers.forms.geo
					};

					if( ! __data.geo) {
						alert("Оберіть регіон на території якого діє ця анкета");
						return false;
					}

					__uiForm.data(__data);
				}).afterSend(function(response){
					if( ! response.success)
						return;

					if( ! (inquirers.forms.id > 0)) {
						__formsUiTable.dataSource.insert(0, response.item);
						inquirers.forms.id = response.item.id;
					}else {
						var __item = __formsUiTable.dataSource.get(inquirers.forms.id);
						for(var __field in response.item)
							__item.set(__field, response.item[__field]);
					}

					inquirers.forms.geo = null;

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

								inquirers.forms.geo = e.sender.value();
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

								inquirers.forms.geo = e.sender.value();
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

								inquirers.forms.geo = e.sender.value();
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

								inquirers.forms.geo = e.sender.value();
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

				$("a[data-action='save']", __uiWindow.element).click(function(){
					__uiForm.send();
				});

				$("a[data-action='cancel']", __uiWindow.element).click(function(){
					__uiWindow.close();
				});

				return $.extend(__uiWindow, {
					getItemAndOpenWindow: (function(fid){
						if(fid > 0)
							$.post(inquirers.tokens.forms.actions.get_item, {
								fid: fid
							}, function(response){
								if( ! response.success)
									return;

								var __item = response.item;

								inquirers.forms.id = __item.id;
								inquirers.forms.geo = __item.geo;

								$("[data-block='geo']", __uiWindow.element).hide();

								$("span", "[data-block='location_name']").html(__item.title);
								$("[data-block='location_name']").show();

								__uiWindow.open();
							}, "json");

						inquirers.forms.id = 0;
					}),
					initGeo: (function(){
						__geo.initialize();
					}),
					geo: (function(){
						inquirers.forms.geo = __geo.fn.geo();
						return inquirers.forms.geo;
					})
				});

			}(inquirers.tokens.forms.window));

			var __blocksUiTable = (function(element){
				var __data = eval($(">script#data", element).text()),
					__templates = $(">script[type='text/x-kendo-template']", element);

				var __deleteItem = (function(bid, text){
					if(confirm(text)){
						$.post(inquirers.tokens.blocks.actions.delete_item, {
							bid: bid
						}, function(response){
							if( ! response.success)
								return;

							__uiTable.dataSource.remove(__uiTable.dataSource.get(bid));
						}, "json");
					}
				});

				var __publicateItem = (function(id, state){
					$.post(inquirers.tokens.blocks.actions.publicate_item, {
						bid: id,
						is_public: state
					}, function(){
						__uiTable.dataSource.get(id).set("is_public", state);
					}, "json");
				});

				__templates.each(function(i){
					if(typeof __data.columns[i] == "undefined")
						return;
					__data.columns[i]["template"] = kendo.template($(this).html());
				});

				var __uiTable = $(element).kendoGrid($.extend(__data, {
					dataBound: (function(e){
						if( ! (e.sender.dataSource.data().length > 0))
							$(e.sender.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));

						__inquirersFormUiWindow.checkPosition();
					})
				})).data("kendoGrid");

				$(__uiTable.tbody).click(function(event){
					var __a = $(event.srcElement);

					switch($(__a).attr("data-action")){
						case "edit":
							inquirers.blocks.fn.getItemAndOpenWindow($(__a).attr("data-id"));
							break;

						case "publicate":
							__publicateItem($(__a).attr("data-id"), ($(__a).attr("checked") ? 1 : 0));
							break;

						case "delete":
							__deleteItem($(__a).attr("data-id"), $(__a).attr("data-text"));
							break;
					}
				});

				if( ! ($(">tr", __uiTable.tbody).length > 0))
					$(__uiTable.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));

				return __uiTable;
			}( $(inquirers.tokens.forms.table.blocks, __inquirersFormUiWindow.element) ));

			var __formsUiTable = (function(element){
				var __data = eval($(">script#data", element).text()),
					__templates = $(">script[type='text/x-kendo-template']", element);

				__templates.each(function(i){
					if(typeof __data.columns[i] == "undefined")
						return;
					__data.columns[i]["template"] = kendo.template($(this).html());
				});

				var __updateItem = (function(fid, is_public){
					$.post(inquirers.tokens.forms.actions.publicate_item, {
						fid: fid,
						is_public: is_public
					}, function(response){
						if( ! response.success)
							return;

						__uiTable.dataSource.get(fid).set("is_public", is_public);
					}, "json");
				});

				var __deleteItem = (function(fid, text){
					if(confirm(text)){
						$.post(inquirers.tokens.forms.actions.delete_item, {
							fid: fid
						}, function(response){
							if( ! response.success)
								return;

							__uiTable.dataSource.remove(__uiTable.dataSource.get(fid));
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
					var __a = $(event.srcElement);

					switch($(__a).attr("data-action")){
						case "edit":
							inquirers.forms.fn.getItemAndOpenWindow($(__a).attr("data-id"));
							break;

						case "publicate":
							__updateItem($(__a).attr("data-id"), ($(__a).attr("checked") ? 1 : 0));
							break;

						case "delete":
							__deleteItem($(__a).attr("data-id"), $(__a).attr("data-text"));
							break;
					}
				});

				if( ! ($(">tr", __uiTable.tbody).length > 0))
					$(__uiTable.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));

				return __uiTable;
			}(inquirers.tokens.forms.table.forms));

			$("a[data-action='create']", inquirers.section).click(function(){
				$("[data-block='geo']", __inquirersFormUiWindow.element).show();

				$("span", "[data-block='location_name']").html("");
				$("[data-block='location_name']").hide();

				__inquirersFormUiWindow.getItemAndOpenWindow();
				__inquirersFormUiWindow.open();
				__inquirersFormUiWindow.initGeo();
				__inquirersFormUiWindow.checkPosition();
			});

			$("a[data-action='create_block']").click(function(){
				$.post(inquirers.tokens.forms.actions.save_item, {
					fid: inquirers.forms.id,
					geo: __inquirersFormUiWindow.geo()
				}, function(response){
					if( ! response.success)
						return;

					if( ! (inquirers.forms.id > 0))
						__formsUiTable.dataSource.insert(0, response.item);
					else {
						var __item = __formsUiTable.dataSource.get(inquirers.blocks.id );

						for(var __field in response.item)
							__item.set(__field, response.item[__field]);
					}

					inquirers.forms.id = response.item.id;
				}, "json");

				inquirers.blocks.fn.open();
			});

			inquirers.forms.fn = $.extend(__inquirersFormUiWindow, {
				setData: function(data){
					__formsUiTable.dataSource.data(data);
				},
				addBlock: function(data){
					__blocksUiTable.dataSource.insert(0, data);
				},
				updateBlock: function(id, data){
					var __item = __blocksUiTable.dataSource.get(id);

					for(var __field in data)
						__item.set(__field, data[__field]);
				}
			});
		}
	},

	blocks: {
		id: 0,
		fn: {},
		init: function(){
			var element = inquirers.tokens.blocks.element;

			var __formUiWindow = (function(element){
				var __uiWindow = (new Window(element)).afterOpen(function(){
					if(inquirers.blocks.id)
						$.post(inquirers.tokens.questions.actions.get_list, {
							bid: inquirers.blocks.id
						}, function(res){
							__questionsListUiTable.dataSource.data(res.list);
						}, "json");
				}).afterClose(function(){
					__questionsListUiTable.dataSource.data([]);
					inquirers.blocks.id = 0;
					inquirers.forms.fn.open();
					$("[data-ui='block_title']", __formUiWindow.element).val("");
				});

				var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function(){
					var __data = {
						id: inquirers.blocks.id,
						fid: inquirers.forms.id,
						title: $("[data-ui='block_title']", __formUiWindow.element).val()
					};

					if( ! __data.title || ! __data.fid) {
						alert("Введіть назву блоку питань");
						return false;
					}

					__uiForm.data(__data);
				}).afterSend(function(response){
					if( ! response.success)
						return;

					if( ! (inquirers.blocks.id > 0))
						inquirers.forms.fn.addBlock(response.item);
					else
						inquirers.forms.fn.updateBlock(inquirers.blocks.id, response.item);

					inquirers.blocks.id = response.item.id;

					$("[data-ui='block_title']", __formUiWindow.element).val("");
					inquirers.blocks.id = 0;

					__uiWindow.close();
				});

				$("a[data-action='save']", __uiWindow.element).click(function(){
					__uiForm.send();
				});

				$("a[data-action='cancel']", __uiWindow.element).click(function(){
					__uiWindow.close();
				});

				return $.extend(__uiWindow, {
					getItemAndOpenWindow: (function(bid){
						if(bid > 0) {
							$.post(inquirers.tokens.blocks.actions.get_item, {
								bid: bid
							}, function (response) {
								if (!response.success)
									return;

								var __item = response.item;

								inquirers.blocks.id = __item.id;

								$("[data-ui='block_title']", __formUiWindow.element).val(__item.title);

								__uiWindow.open();
							}, "json");
						}

						inquirers.blocks.id = 0;
					}),
					saveBlock: function(){
						__uiForm.send();
					}
				});

			}(inquirers.tokens.blocks.window));

			$("a[data-action='create_question']").click(function(){
				$.post(inquirers.tokens.blocks.actions.save_item, {
					id: inquirers.blocks.id,
					fid: inquirers.forms.id,
					title: $("[data-ui='block_title']", __formUiWindow.element).val()
				}, function(response){
					if( ! response.success)
						return;

					if( ! (inquirers.blocks.id > 0))
						inquirers.forms.fn.addBlock(response.item);
					else {
						inquirers.forms.fn.updateBlock(inquirers.blocks.id, response.item);
					}

					inquirers.blocks.id = response.item.id;

					$.post(inquirers.tokens.questions.actions.save_item, {
						bid: response.item.id,
						title: $("input#question_title").val()
					}, function(response){
						if( ! response.success)
							return;

						inquirers.blocks.title = $("input#question_title").val();

						$("#question_title").val("");
						__questionsListUiTable.dataSource.add(response.item);
					}, "json");
				}, "json");

				if($("input#question_title").val() == ""){
					$("input#question_title").css("borderColor", "red");
					setTimeout(function(){
						$("input#question_title").css("borderColor", "");
					}, 2000);
					return;
				}
			});

			var __questionsListUiTable = (function(element){
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

						__formUiWindow.checkPosition();
					})
				})).data("kendoGrid");

				var __deleteItem = (function(qid, text){
					if(confirm(text)){
						$.post(inquirers.tokens.questions.actions.delete_item, {
							qid: qid
						}, function(response){
							if( ! response.success)
								return;
							__uiTable.dataSource.remove(__uiTable.dataSource.get(qid));
						}, "json");
					}
				});

				var __publicateItem = (function(qid, state){
					$.post(inquirers.tokens.questions.actions.publicate_item, {
						qid: qid,
						is_public: state
					}, function(res){
						if( ! res.success)
							return;

						__uiTable.dataSource.get(qid).set("is_public", state);
					}, "json");
				});

				var __isTextItem = (function(qid, state){
					$.post(inquirers.tokens.questions.actions.is_text_item, {
						qid: qid,
						is_text: state
					}, function(res){
						if( ! res.success)
							return;

						__uiTable.dataSource.get(qid).set("is_text", state);

						if(state)
							$("[data-action='add_answers'][data-id='" + qid + "']").hide();
						else
							$("[data-action='add_answers'][data-id='" + qid + "']").show();
					}, "json");
				});

				var __editItem = (function(element){
					var __parentDiv = $($(element).parents("div").eq(0)),
						__a = $(element).clone(),
						__input = $("<input type=\"text\" class=\"textbox\" style=\"width: 100%\" />").bind("blur keyup", function(e){
							var __this = this;
							var __qid = $(__a).attr("data-id");

							if( ! ($.inArray(e.type, ["blur", "keyup"]) > -1) || (e.type == "keyup" && e.keyCode != 13))
								return;

							if($(__this).val() == ""){
								$(__this).css("borderColor", "red");
								setTimeout(function(){
									$(__this).css("borderColor", "");
								}, 2000);
								return;
							}

							$.post(inquirers.tokens.questions.actions.save_item, {
								qid: __qid,
								bid: inquirers.blocks.id,
								title: $(__this).val()
							}, function(){
								$(__parentDiv).css("padding", "")
									.append($(__a));
								$(__a).html($(__this).val());
								$(__this).remove();

								inquirers.blocks.title = $(__this).val();

								__uiTable.dataSource.get(__qid).set("title", $(__this).val());
							}, "json");
						});

					$(element).remove();

					$(__parentDiv).css("padding", 0)
						.append($(__input).val($(__a).html()));

					$(__input).focus();
				});

				$(__uiTable.tbody).click(function(event){
					var __element = $(event.srcElement);

					switch($(__element).attr("data-action")){
						case "edit":
							__editItem(__element);
							break;

						case "delete":
							__deleteItem($(__element).attr("data-id"), $(__element).attr("data-text"));
							break;

						case "is_text":
							__isTextItem($(__element).attr("data-id"), $(__element).prop("checked") ? 1 : 0);
							break;

						case "publicate":
							__publicateItem($(__element).attr("data-id"), $(__element).prop("checked") ? 1 : 0);
							break;

						case "add_answers":
							inquirers.questions.fn.getItemAndOpenWindow($(__element).attr("data-id"));
							break;
					}
				});

				return __uiTable;
			})($("table[data-ui='questions']", $('[data-section="questions"]')));

			inquirers.blocks.fn = $.extend(__formUiWindow, {
				addBlocks: (function(data){
					__questionsListUiTable.dataSource.data(data);
				})
			});
		}
	},

	questions: {
		id: 0,
		title: "",
		fn: {},
		init: function () {
			var __formUiWindow = (function(element){
				var __uiWindow = (new Window(element)).afterOpen(function(){
					if(inquirers.questions.id)
						$.post(inquirers.tokens.answers.actions.get_list, {
							qid: inquirers.questions.id
						}, function(res){
							__answersUiTable.dataSource.data(res.list);
						}, "json");

					$("[data-box='answers_num']", __formUiWindow.element).hide();
				}).afterClose(function(){
					__answersUiTable.dataSource.data([]);
					inquirers.questions.id = 0;
					inquirers.blocks.fn.open();
					$("input#answer_title").val("");
				});

				$("a[data-action='save']", __uiWindow.element).click(function(){
					$.post(inquirers.tokens.questions.actions.save_item, {
						qid: inquirers.questions.id,
						bid: inquirers.blocks.id,
						title: inquirers.blocks.title,
						type: answers_type.value(),
						num: answers_type.value() == 2 ? answers_num.value() : 0
					}, "json");

					__uiWindow.close();
				});

				return $.extend(__uiWindow, {
					getItemAndOpenWindow: (function(qid){
						if(qid > 0) {
							$.post(inquirers.tokens.questions.actions.get_item, {
								qid: qid
							}, function (response) {
								if ( ! response.success)
									return;

								var __item = response.item;

								inquirers.questions.id = __item.id;
								inquirers.blocks.title = __item.title;

								$('[data-ui="question"]').html(__item.title);

								answers_type.value(__item.type);
								if(__item.type == 2){
									answers_num.value(__item.num);
									$("[data-box='answers_num']").show();
								}

								$("[data-ui='answer_title']", __uiWindow.element).val(__item.title);

								__uiWindow.open();
							}, "json");
						}

						inquirers.questions.id = 0;
					})
				});

			}(inquirers.tokens.answers.window));

			$("a[data-action='create_answer']").click(function () {
				if ($("input#answer_title").val() == "") {
					$("input#answer_title").css("borderColor", "red");
					setTimeout(function () {
						$("input#answer_title").css("borderColor", "");
					}, 2000);
					return;
				}

				$.post(inquirers.tokens.answers.actions.save_item, {
					qid: inquirers.questions.id,
					title: $("input#answer_title").val()
				}, function (response) {
					if ( ! response.success)
						return;

					$("input#answer_title").val("");
					__answersUiTable.dataSource.add(response.item);
				}, "json");
			});

			var answers_type = $("[data-ui='answers_type']", __formUiWindow.element).kendoDropDownList({
				change: function(e){
					if(e.sender.value() == 2)
						$("[data-box='answers_num']", __formUiWindow.element).show();
					else
						$("[data-box='answers_num']", __formUiWindow.element).hide();
				}
			}).data("kendoDropDownList");

			var answers_num = $("[data-ui='answers_num']", __formUiWindow.element).kendoDropDownList({
				dataTextField: "text",
				dataValueField: "value"
			}).data("kendoDropDownList");

			var __answersUiTable = (function (element) {
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

						answers_num.dataSource.data([]);
						for(var i = (e.sender.dataSource.data().length); i > 0; i--) {
							answers_num.dataSource.insert({"text" : i, "value" : i});
						}
					})
				})).data("kendoGrid");

				var __publicateItem = (function (aid, state) {
					$.post(inquirers.tokens.answers.actions.publicate_item, {
						aid: aid,
						is_public: state
					}, function () {
						__uiTable.dataSource.get(aid).set("is_public", state);
					}, "json");
				});

				var __problemItem = (function (aid, state) {
					$.post(inquirers.tokens.answers.actions.is_problem, {
						aid: aid,
						is_problem: state
					}, function () {
						__uiTable.dataSource.get(aid).set("is_problem", state);
					}, "json");
				});

				var __deleteItem = (function (aid, text) {
					if (confirm(text)) {
						$.post(inquirers.tokens.answers.actions.delete_item, {
							aid: aid
						}, function (response) {
							if ( ! response.success)
								return;
							__uiTable.dataSource.remove(__uiTable.dataSource.get(aid));
						}, "json");
					}
				});

				var __isTextItem = (function(aid, state){
					$.post(inquirers.tokens.answers.actions.is_text_item, {
						aid: aid,
						is_text: state
					}, function(res){
						if( ! res.success)
							return;

						__uiTable.dataSource.get(aid).set("is_text", state);

						if(state)
							$("[data-action='is_problem'][data-id='" + aid + "']").prop("disabled", true);
						else
							$("[data-action='is_problem'][data-id='" + aid + "']").prop("disabled", false);
					}, "json");

					if(state)
						$.post(inquirers.tokens.answers.actions.is_problem, {
							aid: aid,
							is_problem: ! state
						}, function () {
							__uiTable.dataSource.get(aid).set("is_problem", ! state);
						}, "json");
				});

				var __editItem = (function (element) {
					var __parentDiv = $($(element).parents("div").eq(0)),
						__a = $(element).clone(),
						__input = $("<input type=\"text\" class=\"textbox\" style=\"width: 100%\" />").bind("blur keyup", function (e) {
							var __this = this;

							if (!($.inArray(e.type, ["blur", "keyup"]) > -1) || (e.type == "keyup" && e.keyCode != 13))
								return;

							if ($(__this).val() == "") {
								$(__this).css("borderColor", "red");
								setTimeout(function () {
									$(__this).css("borderColor", "");
								}, 2000);
								return;
							}

							$.post(inquirers.tokens.answers.actions.save_item, {
								aid: $(__a).attr("data-id"),
								qid: inquirers.questions.id,
								title: $(__this).val()
							}, function () {
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

				$(__uiTable.tbody).click(function (event) {
					var __element = $(event.srcElement);
					if (typeof $(__element).attr("data-action") == "undefined")
						__element = $($(__element).parents("*[data-action]").eq(0));

					switch ($(__element).attr("data-action")) {
						case "edit":
							__editItem(__element);
							break;

						case "delete":
							__deleteItem($(__element).attr("data-id"), $(__element).attr("data-text"));
							break;

						case "is_problem":
							__problemItem($(__element).attr("data-id"), ($(__element).prop("checked") ? 1 : 0));
							break;

						case "is_text":
							__isTextItem($(__element).attr("data-id"), $(__element).prop("checked") ? 1 : 0);
							break;

						case "publicate":
							__publicateItem($(__element).attr("data-id"), ($(__element).prop("checked") ? 1 : 0));
							break;
					}
				});

				return __uiTable;
			})($("table[data-ui='answers']", $('[data-section="answers"]')));

			inquirers.questions.fn = $.extend(__formUiWindow, {
				addAnswers: (function (data) {
					__answersUiTable.dataSource.data(data);
				})
			});
		}
	}
};

$(document).ready(function(){

	inquirers.section = $("body>section>div.section");
	inquirers.tokens = {
		forms: {
			window: $("div[ui-window='inquirers.admin.inquirer']"),
			table: {
				forms: $("table[data-ui='forms']", inquirers.section),
				blocks: "table[data-ui='blocks']"
			},
			actions: {
				get_item: "/inquirers/admin/get_form",
				save_item: "/inquirers/admin/save_form",
				publicate_item: "/inquirers/admin/publicate_form",
				delete_item: "/inquirers/admin/delete_form"
			}
		},
		blocks: {
			element: $("div[data-section='blocks']"),
			window: $("div[ui-window='inquirers.admin.blocks']"),
			actions: {
				get_list: "/inquirers/admin/get_blocks",
				get_item: "/inquirers/admin/get_block",
				save_item: "/inquirers/admin/save_block",
				publicate_item: "/inquirers/admin/publicate_block",
				delete_item: "/inquirers/admin/delete_block"
			}
		},
		questions: {
			element: $('[data-section="questions"]'),
			window: $("div[ui-window='inquirers.admin.questions']"),
			actions: {
				get_list: "/inquirers/admin/get_questions",
				get_item: "/inquirers/admin/get_question",
				save_item: "/inquirers/admin/save_question",
				publicate_item: "/inquirers/admin/publicate_question",
				is_problem: "/inquirers/admin/is_problem_question",
				delete_item: "/inquirers/admin/delete_question",
				is_text_item: "/inquirers/admin/is_text_question"
			}
		},
		answers: {
			element: $('[data-section="answers"]'),
			window: $("div[ui-window='inquirers.admin.answers']"),
			actions: {
				get_list: "/inquirers/admin/get_answers",
				get_item: "/inquirers/admin/get_answer",
				save_item: "/inquirers/admin/save_answer",
				publicate_item: "/inquirers/admin/publicate_answer",
				is_problem: "/inquirers/admin/is_problem_answer",
				delete_item: "/inquirers/admin/delete_answer",
				is_text_item: "/inquirers/admin/is_text_answer"
			}
		}
	};

	inquirers.forms.init();
	inquirers.blocks.init();
	inquirers.questions.init();

});