$(document).ready(function(){
	
	var __section = $("body>section>div.section"),
		__toolbarUiBox = $(">div>div[data-uiBox='toolbar']", __section);

	var __formUiWindow = (function(element){
		var __uiWindow = (new Window(element)).afterOpen(function(){
			__imagesUiView.cleanUp();
			__geo.initialize();
			__uiWindow.checkPosition();
			__membersUiSelect.value([]);
			$("[data-id='is_primary']").val(0).hide();

			$("#structure_level")
				.html( "Не обрано" )
				.removeAttr("type")
				.removeAttr("title");

			$("[data-error]").hide();
		});

		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function(){
			var __data = {
				geo: __geo.fn.geo(),
				members: __membersUiSelect.value(),
				address: $("input[data-ui-tb='address']", __uiWindow.element).val(),
				images: __imagesUiView.getImages(),
				level : $("#structure_level").attr("type")
			};

			$("[data-error]").hide();

			var err = false;
			if( __membersUiSelect.value().length < 3)
			{
				err = true;
				$("[data-error='members']").show();
			}

			if( $("select[data-ui-ddl='region']", __uiWindow.element).val() < 1)
			{
				err = true;
				$("[data-error='region']").show();
			}

			if( $("input[data-ui-tb='address']", __uiWindow.element).val().length < 1 )
			{
				err = true;
				$("[data-error='address']").show();
			}

			if( __imagesUiView.getImages().length < 2 )
			{
				err = true;
				$("[data-error='images']").show();
			}

			if(err)
				return false;

			$.post("/register/structures/check_structure", {
				geo: __geo.fn.geo(),
				members: __membersUiSelect.value(),
				level : $("#structure_level").attr("type")
			}, function(res){

				$.each(res.message, function(n, msg){
					$("[data-ui='errors']").append("<div data-error='structure' class='mt10'>"+msg+"</div>");
				});

				__uiWindow.checkPosition();

				if(res.type == "error");
					return false;
			}, "json");

			__uiForm.data(__data);
		}).afterSend(function(response){
			if( ! response.success)
				return;

			if( ! response.item)
			{
				$("[data-error='duplicate']").show();
				return false;
			}

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
							__addressUiTB.fn.hide();
							return;
						}

						__article.fn.geo( e.sender.value() );

						if(e.sender.value() != null)
							$.post("/register/structures/get_structure_level", {
								geo: e.sender.value()
							}, function(res){
								$("#structure_level")
									.html(res.level.long)
									.attr("type", res.level.level);
							}, "json");

						if(e.sender.value() == "8000000000") {
							__areaUiDDL.fn.hide();
							__locationUiCB.fn.hide();

							return __cityDistrictUiDDL.fn.show(e.sender.value(), function (e) {
								__addressUiTB.fn.show();
								if (e.visible)
									return;
							});
						} else {
							__addressUiTB.fn.show();
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

						if(e.sender.value() != null && e.sender.value() > 0) {
							$.post("/register/structures/get_structure_level", {
								geo: e.sender.value()
							}, function (res) {
								$("#structure_level")
									.html(res.level.long)
									.attr("type", res.level.level);
							}, "json");

							__article.fn.geo(e.sender.value())
						}

						if(e.sender.value().match(/[0-9]{2}2[0-9]{7}/i)) {
							__cityDistrictUiDDL.fn.hide();
							return __locationUiCB.fn.show(e.sender.value());
						} else {
							__locationUiCB.fn.hide();

							return __cityDistrictUiDDL.fn.show(e.sender.value(), function (e) {
								if (e.visible)
									return;

								if($("#structure_level").attr("type") < 6)
									$("[data-id='is_primary']").show();

								__cityDistrictUiDDL.fn.hide();
							});
						}
					}
				}).data('kendoDropDownList')), {
					fn: {
						show: function(code, fn){
							__article.preloading.show();
							__cityDistrictUiDDL.fn.hide();
							$("[data-id='is_primary']").hide();

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

						if(e.sender.value() != null && e.sender.value() > 0) {
							$.post("/register/structures/get_structure_level", {
								geo: e.sender.value()
							}, function (res) {
								$("#structure_level")
									.html(res.level.long)
									.attr("type", res.level.level);

								if($("#structure_level").attr("type") < 6)
								{
									alert($("#structure_level").attr("type"));
									$("[data-id='is_primary']").show();
								}
							}, "json");
						}
						else
							$("[data-id='is_primary']").hide();

						__article.fn.geo(e.sender.value());
						__cityDistrictUiDDL.fn.show(e.sender.value(), function(e){
							if(e.visible)
								return;
							__cityDistrictUiDDL.fn.hide();
							__addressUiTB.fn.show();
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
							$("[data-id='is_primary']").hide();

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

							$.post("/register/structures/get_structure_level", {
								geo: e.sender.value()
							}, function (res) {
								$("#structure_level")
									.html(res.level.long)
									.attr("type", res.level.level);

								if($("#structure_level").attr("type") < 6)
									$("[data-id='is_primary']").show();
							}, "json");

							return;
						}

						$("[data-id='is_primary']").hide();
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
									} else
									if($("#structure_level").attr("type") < 6)
											$("[data-id='is_primary']").show();

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

			var __addressUiTB = (function(ui){
				return $.extend(ui, {
					fn: {
						show: function(){
							$(">tr[data-id='"+$(ui).attr('data-ui-tb')+"']", $($(ui).parents('tbody').eq(0))).show();
							$(ui).val($(ui).attr('data-value'));
							if($(ui).attr('data-value') != '')
								$(ui).attr('data-value', '');

							__uiWindow.checkPosition();

							return this;
						},
						hide: function(){
							$(">tr[data-id='"+$(ui).attr('data-ui-tb')+"']", $($(ui).parents('tbody').eq(0))).hide();
							return this;
						}
					}
				});
			})($("input[data-ui-tb='address']", ui));

			$("#is_primary").change(function(){

				if($(this).prop("checked"))
					$("#structure_level")
						.attr({
							"old_type": $("#structure_level").attr("type"),
							"old_title": $("#structure_level").html(),
							"type": 6
						})
						.html("Первинна партійна огранізація");
				else
					$("#structure_level")
						.html( $("#structure_level").attr("old_title") )
						.attr("type", $("#structure_level").attr("old_type"))
						.removeAttr("old_type")
						.removeAttr("old_title");
			});

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
					},
					address: function(value) {
						if (typeof value == 'undefined')
							return __addressUiTB.val();
						__addressUiTB.val(value);
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
			var __inputTemplate = kendo.template($(">script[data-ui='input_template']", $($(element).parents("td").eq(0))).html());

			return $(element).kendoMultiSelect({
				placeholder: "Почніть вводити email",
				dataValueField: "id",
				dataTextField: "name",
				filter: "contains",
				minLength: 3,
				autoBind: false,
				change: function(){
					__uiWindow.checkPosition();

					var members = __membersUiSelect.value();
					members.forEach(function(uid){
						if(user = __membersUiSelect.dataSource.get(uid)){
							if( ! __headUiSelect.dataSource.get(uid))
								__headUiSelect.dataSource.insert( user );

							if( ! __coordinatorUiSelect.dataSource.get(uid))
								__coordinatorUiSelect.dataSource.insert( user );
						}
					});

					var headData = __headUiSelect.dataSource.data();
					if(headData.length > 0)
						headData.forEach(function(user){
							if(
								typeof user == "object"
								&&
								(
									(__membersUiSelect.value().indexOf(user.id) < 0)
									|| (__coordinatorUiSelect.value().indexOf(user.id) >= 0)
								)
							)
								__headUiSelect.dataSource.remove( user );
						});

					var coordinatorData = __coordinatorUiSelect.dataSource.data();
					if(coordinatorData.length > 0)
						coordinatorData.forEach(function(user){
							if(
								typeof user == "object"
								&&
								(
									(__membersUiSelect.value().indexOf(user.id) < 0)
									|| (__headUiSelect.value().indexOf(user.id) >= 0)
								)
							)
								__coordinatorUiSelect.dataSource.remove( user );
						});
				},
				template: $(">script#input_template", $($(element).parents("td").eq(0))).html(),
				dataSource: {
					serverFiltering: true,
					transport: {
						read: (function(options){
							$.ajax({
								url: "/api/users/find?email="+options.data.filter.filters[0].value+"&geo="+__geo.fn.geo()+"&uniq_structure=true",
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
			}).data("kendoMultiSelect");
		})($("select[data-uiAutoComplete='q']", __uiWindow.element));

		var __headUiSelect = (function(element){
			return $(element).kendoDropDownList({
				//placeholder: "Почніть вводити email",
				dataValueField: "id",
				dataTextField: "name",
				filter: "contains",
				minLength: 3,
				autoBind: false,
				change: function(){
					var members = __membersUiSelect.value();
					members.forEach(function(uid){
						if(user = __membersUiSelect.dataSource.get(uid)){
							if( ! __coordinatorUiSelect.dataSource.get(uid))
								__coordinatorUiSelect.dataSource.insert( user );
						}
					});

					var coordinatorData = __coordinatorUiSelect.dataSource.data();
					if(coordinatorData.length > 0)
						coordinatorData.forEach(function(user){
							if(
								typeof user == "object"
								&&
								(
									(__membersUiSelect.value().indexOf(user.id) < 0)
									|| (__headUiSelect.value().indexOf(user.id) >= 0)
								)
							)
								__coordinatorUiSelect.dataSource.remove( user );
						});
				},
				template: $(">script[data-ui='input_template']", $($(element).parents("td").eq(0))).html(),
			}).data("kendoDropDownList");
		})($("select[data-ui='head']", __uiWindow.element));

		var __coordinatorUiSelect = (function(element){
			return $(element).kendoDropDownList({
				//placeholder: "Почніть вводити email",
				dataValueField: "id",
				dataTextField: "name",
				filter: "contains",
				minLength: 3,
				autoBind: false,
				template: $(">script[data-ui='input_template']", $($(element).parents("td").eq(0))).html(),
			}).data("kendoDropDownList");
		})($("select[data-ui='coordinator']", __uiWindow.element));

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
						break;
				}
			});

			$(">a>input", __uploaderUiBox).css({
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

					__addImage(data.result.files[0]);
				})
			});

			var __addImage = (function(hash){
				$(__imageTemplate({
					hash: hash
				})).insertBefore($(">div:last-child", __listUiBox));

				__uiWindow.checkPosition();
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

		$("a[data-action='send']", __uiWindow.element).click(function(){
			__uiForm.send();
		});

		$("a[data-action='cancel']", __uiWindow.element).click(function(){
			__uiWindow.close();
		});

		return $.extend(__uiWindow);

	}($("div[ui-window='register.structures.form']")));

	$("a[data-action='create']", __section).click(function(){
		__formUiWindow.open();
	});

	var __viewerUiWindow = (function(element){
		var __uiWindow = new Window(element);
		
		return $.extend(__uiWindow, {
			getItemAndOpenWindow: (function(id){
				$.post("/register/structures/get_structure", {
					id: id
				}, function(response){
					if( ! response.success)
						return;
					
					var __item = response.item;
					
					$("span#locality", __uiWindow.element).html(__item.location);
					$("span#address", __uiWindow.element).html(([__item.address]));

					$("h3[data-header='title']").html(__item.title);
					$("span[data-header='location']").html(__item.locality);

					$("span#mcount").html("(" + __item.mcount + ")");
					$("span#address").html(__item.address);
					$("span#location").html(__item.locality);
					$("span#level").html(__item.level);

					$("div#membersList", __uiWindow.element).empty();
					__item.members.forEach(function(member){
						var __div = $("div.member_template", __uiWindow.element).clone();
						$(__div)
							.removeClass("member_template")
							.show();

						$(".avatar", __div).html("");
						if(member.avatar != "")
							$(".avatar", __div).css("backgroundImage", "url('http://volya.ua/s/img/thumb/aa/"+member.avatar+"')");
						else
							$(".avatar", __div)
								.css("backgroundImage", "")
								.append($("<i class=\"icon-user\" />"));

						$("#name", __div).html(member.name);
						//$("#status", __div).html(member.is_head ? "Голова осередку" : member.is_coordinator ? "Координатор осередку" : "Член осередку");

						$("div#membersList", __uiWindow.element).append(__div);
					});
					$("div#members", __uiWindow.element).append("<div class='cboth'></div>");

					$("div#documents", __uiWindow.element).empty();
					__item.documents.forEach(function(document){
						$("div#documents", __uiWindow.element).append($("<div class=\"fleft mr5\" style=\"width: 147.5px; height: 170px; background: url(/s/img/thumb/ak/" + document.hash + "); background-color: cover;\" ></div>"));
					});
					$("div#documents", __uiWindow.element).append("<div class='cboth'></div>");

					if( __item.verification == null || __item.verification.type == "-1"){
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
	}($("div[ui-window='register.structures.viewer']")));

	$("input[name='varification']", __viewerUiWindow.element).change(function(){
		$("textarea#comment", __viewerUiWindow.element).val("");

		if($(this).val() == "-1")
			$("textarea#comment", __viewerUiWindow.element).show();
		else
			$("textarea#comment", __viewerUiWindow.element).hide();
	});

	$("a#save", __viewerUiWindow.element).click(function(){
		var sid = $(this).attr("data-id");

		$.post("/register/structures/set_varification",
			{
				sid: sid,
				state: $("input[name='varification']:checked", __viewerUiWindow.element).val(),
				comment: $("textarea#comment", __viewerUiWindow.element).val()
			},
			function(res){
				var __item = __listUiTable.dataSource.get(sid);
				__item.set("verification", res.item.verification);

				__viewerUiWindow.close();
			}, "json");
	});
	
	var __exportUiWindow = (function(element){
		var __uiWindow = new Window(element);
		
		return $.extend(__uiWindow, {
			getDocument: (function(url){
				$("div[data-uiBox='content']").empty()
						.append($("<iframe frameborder=\"0\" width=\"100%\" height=\"700px\" src=\"/s/pdf?url="+encodeURIComponent("/register/export_members/c7a455383a2f22f10465dae825acf661"+url)+"\" />"));
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

				//if(typeof __cityUiSelect != "undefined" && __cityUiSelect.value() != 0)
				//	__params += "city="+__cityUiSelect.value()+"&";
				//
				//if(typeof __cityAreaUiSelect != "undefined" && __cityAreaUiSelect.value() != 0)
				//	__params += "cityArea="+__cityAreaUiSelect.value()+"&";
				
				//if(__typeUiSelect.value() != 0)
				//	__params += "type="+__typeUiSelect.value()+"&";
				
				if(__verificationUiSelect != null && __verificationUiSelect.value() != 0)
					__params += "verification="+__verificationUiSelect.value()+"&";
				
				return __params.substr(0, __params.length - 1);
			}),
			apply: (function(){
				window.location.href = "/register/structures"+this.prepare();
			})
		});
	}());
	
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
					$("a#save", __viewerUiWindow.element).attr("data-id", $(__a).attr("data-id"));
					break;
			}
		});

		if( ! ($(">tr", __uiTable.tbody).length > 0))
			$(__uiTable.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));

		return __uiTable;
	}($("table[data-ui='list']", __section)));

});