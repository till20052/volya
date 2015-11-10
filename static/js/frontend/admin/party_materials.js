$(document).ready(function(){

	var __section = $("body>section>div.section");

	// ToolBar
	(function(ui){

		$("a[data-action]>input[type='file']", ui).css({
			opacity: 0
		}).fileupload({
			dataType: "json",
			url: "/s/storage/j_save",
			sequentialUploads: true,
			send: function(e, data){
				$(">div.onloading", __materials.add({
					id: -1,
					name: data.files[0].name
				})).show();
			},
			done: function(e, data){
				if( ! data.result.success)
					return;
				$.post("/admin/party_materials/j_file_save", {
					group_id: __groups.select(),
					hash: data.result.files[0],
					name: data.files[0].name
				}, function(res){
					if( ! res.success)
						return;
					__materials.edit(-1, res.item);
				}, "json");
			}
		});

	})($("div[data-uiBox='toolbar']", __section));

	var __confirmUiWindow = (function(ui){
		var __uiWindow = new Window(ui),
			__url = "",
			__data = {},
			__callback = function(){};

		$("a#yes", __uiWindow.element).click(function(){
			$.post(__url, __data, function(res){
				__uiWindow.close();
				if(typeof __callback != "function")
					return;
				__callback(res);
			}, "json");
		});

		$("a#no", __uiWindow.element).click(function(){
			__uiWindow.close();
		});

		return {
			open: function(data){
				__url = data.url;
				__data = data.data;
				__callback = data.callback;
				$("span#message", __uiWindow.element).html(data.message);
				__uiWindow.open();
			}
		};
	})($("div[ui-window='admin.party_materials.confirm']"));

	var __groups = (function(ui){
		var __ul = (function(ui){
			return $(ui).click(function(e){
				var __target = $(e.target);

				if(typeof $(__target).attr("data-action") == "undefined")
					__target = $($(__target).parents("*[data-action]").eq(0));

				switch($(__target).attr("data-action"))
				{
					case "select":
						__ui.select($(__target).attr("data-id"));
						break;

					case "edit":
						$.post("/admin/party_materials/j_get_group", {
							id: $(__target).attr("data-id")
						}, function(res){
							if( ! res.success)
								return;
							__uiWindow.open(res.item);
						}, "json");
						break;

					case "remove":
						__confirmUiWindow.open({
							message: $(__target).attr("data-message"),
							url: "/admin/party_materials/j_group_remove",
							data: {
								id: $(__target).attr("data-id")
							},
							callback: function(res){
								$($(__target).parents("li").eq(0)).remove();
								if($(">li", ui).length > 0)
									return;
								__ui.clear();
							}
						});
						break;
				}
			});
		})($(">section>ul", ui)),
		__itemTemplate = kendo.template($(">script#item", __ul).html()),
		__emptyTemplate = kendo.template($(">script#empty", __ul).html()),
		__data = eval($(">script#data", __ul).html());
		__ui = {
			add: function(data){
				if($(">li.empty", __ul).length != 0)
					$(__ul).empty();
				$(__ul).append(__itemTemplate(data));
			},
			edit: function(id, data){
				var __li = $(">li[data-id='"+id+"']", __ul);
				$(__itemTemplate(data)).insertBefore(__li);
				$(__li).remove();
			},
			select: function(id){
				if(typeof id == "undefined")
					return $(">li.selected", __ul).length != 0
						? parseInt($(">li.selected", __ul).attr("data-id"))
						: 0;

				$(">li", __ul).removeClass("selected");
				$(">li[data-id='"+id+"']", __ul).addClass("selected");
				$(">section>div.onloading", __materials.element).show()
					.css("opacity", 0)
					.animate({
						opacity: 1
					}, 100);

				$.post("/admin/party_materials/j_get_files", {
					group_id: id
				}, function(res){
					if( ! res.success)
						return;

					$(">section>div.onloading", __materials.element).animate({
						opacity: 0
					}, 100, function(){
						$(this).hide();
						__materials.clear();
						res.list.forEach(function(item){
							__materials.add(item);
						});
					});
				}, "json");

				return this;
			},
			clear: function(){
				$(__ul).empty()
					.append(__emptyTemplate({}));
				return this;
			}
		},
		__uiWindow = (function(ui){
			var __uiWindow = new Window(ui),
				__uiForm = (new Form($("form", __uiWindow.element))).afterSend(function(res){
					if( ! res.success)
						return;
					if(__uiForm.data("id") > 0)
						__ui.edit(__uiForm.data("id"), res.item);
					else
						__ui.add(res.item);
					__uiWindow.close();
				});

			$("a#save", __uiForm.element).click(function(){
				__uiForm.send();
			});

			$("a#cancel", __uiForm.element).click(function(){
				__uiWindow.close();
			});

			return {
				open: function(data){
					__uiForm.data({});

					if(typeof data == "undefined")
						data = {};

					__uiForm.data("id", typeof data.id != "undefined" ? data.id : 0);
					$("input#name", __uiForm.element).val(typeof data.name != "undefined"
						? data.name
						: "");

					__uiWindow.open();
				}
			};
		})($("div[ui-window='admin.party_materials.group_form']"));

		$("a#add", ui).click(function(){
			__uiWindow.open();
		});

		__ui.clear();
		__data.forEach(function(item){
			__ui.add(item);
		});

		return __ui;
	})($("div[data-ui='groups']", __section));

	var __materials = (function(ui){
		var __ul = (function(ui){
			return $(ui).click(function(e){
				var __target = $(e.target);

				if(typeof $(__target).attr("data-action") == "undefined")
					__target = $($(__target).parents("*[data-action]").eq(0));

				switch($(__target).attr("data-action"))
				{
					case "edit":
						var __li = $($(__target).parents("li").eq(0)),
							__div = $(">div.name", __li);
						$(__div).append($("<textarea rows='1' class='textbox' />").val($(">a", __div).html()));
						$(">a", __div).hide();
						$(">textarea", __div).height($(">textarea", __div).prop("scrollHeight"))
							.attr("data-id", $(__target).attr("data-id"))
							.bind("blur keydown", function(e){
								if(
									e.type != "blur"
									&& ! (e.type == "keydown" && e.which == 13)
								)
									return;

								$(this).hide();
								$(">a", __div).show();
								$(">div.onloading", __li).show()
									.css("opacity", 0)
									.animate({
										opacity: 1
									}, 100);

								$.post("/admin/party_materials/j_file_save", {
									id: $(this).attr("data-id"),
									name: $(this).val()
								}, function(res){
									if( ! res.success)
										return;

									$(">textarea, >a", __div).remove();
									$(__div).append($("<a href='#' />").html(res.item.name));
									$(">div.onloading", __li).animate({
										opacity: 0
									}, 100, function(){
										$(this).hide();
									});
								}, "json");
							}).focus();
						break;

					case "remove":
						__confirmUiWindow.open({
							message: $(__target).attr("data-message"),
							url: "/admin/party_materials/j_file_remove",
							data: {
								id: $(__target).attr("data-id")
							},
							callback: function(res){
								$($(__target).parents("li").eq(0)).remove();
								if($(">li", ui).length > 1)
									return;
								__ui.clear();
							}
						});
						break;
				}
			});
		})($(">section>ul", ui)),
		__itemTemplate = kendo.template($(">script#item", __ul).html()),
		__emptyTemplate = kendo.template($(">script#empty", __ul).html()),
		__ui = {
			element: ui,
			add: function(data){
				if( ! ($(">li", __ul).length > 1))
					$(__ul).empty()
						.append($("<li />"));
				return $(__itemTemplate(data)).insertBefore($(">li:last-child", __ul));
			},
			edit: function(id, data){
				var __li = $(">li[data-id='"+id+"']", __ul);
				$(__itemTemplate(data)).insertBefore(__li);
				$(__li).remove();
			},
			clear: function(){
				$(__ul).empty()
					.append(__emptyTemplate({}));
				return this;
			}
		};

		$(">script", __ul).remove();

		return __ui;
	})($("div[data-ui='materials']", __section))
		.clear();

});