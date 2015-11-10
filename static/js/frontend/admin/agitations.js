$(document).ready(function(){
	var __section = $("body>section>div.section");
	
	var __formUiWindow = (function(element){
		var __uiWindow = new Window(element);

		var __categoriesUiWindow = (function(element){
			var __uiWindow = (new Window(element)).afterOpen(function(){
				$.post("/admin/agitations/j_get_categories", function(response){
					if( ! response.success)
						return;
					__listUiTable.dataSource.data(response.list);
				}, "json");
			}).afterClose(function(){
				__formUiWindow.open();
				$.post("/admin/agitations/j_get_categories", {
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

				$.post("/admin/agitations/j_save_category", {
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

						$.post("/admin/agitations/j_save_category", {
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
					$.post("/admin/agitations/j_save_category", {
						id: id,
						is_public: state
					}, function(){
						__uiTable.dataSource.get(id).set("is_public", state);
					}, "json");
				});

				var __deleteItem = (function(id, text){
					if(confirm(text)){
						$.post("/admin/agitations/j_delete_category", {
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
		})($("div[ui-window='admin.agitations.categories_form']"));

		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function(){
			__uiForm.data({
				id: $(__uiForm.element).attr("data-id"),
				in_election: $(__uiForm.element).attr("data-inElection"),
				image: __previewUiUploader.getHash(),
				file: __fileUiUploader.getHash(),
				categories_ids: __categoriesUiSelect.value()
			});
		}).afterSend(function(response){
			__uiWindow.close();

			if( ! (__uiForm.data("id") > 0))
				__listUiTable.dataSource.insert(0, response.item);
			else {
				var __item = __listUiTable.dataSource.get(__uiForm.data("id"));
				for(var __field in response.item)
					__item.set(__field, response.item[__field]);
			}
		});

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
				url: "/s/storage/j_save?extension[]=jpg&extension[]=png&extension[]=ai&extension[]=pdf&extension[]=psd&extension[]=eps",
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

		var __setData = (function(data){
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
			setData: __setData,
			cleanUp: __cleanUp
		});
	})($("div[ui-window='admin.agitations.form']"));
	
	$("a[data-action='create']", __section).click(function(){
		__formUiWindow.open();
		__formUiWindow.cleanUp();
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
			$.post("/admin/agitations/j_get_item", {
				id: id,
				use_current_lang: 1
			}, function(response){
				if( ! response.success)
					return;
				__formUiWindow.open();
				__formUiWindow.setData(response.item);
			}, "json");
		});
		
		var __updateItem = (function(id, field, value){
			$.post("/admin/agitations/j_update_item", {
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
				$.post("/admin/agitations/j_delete_item", {
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