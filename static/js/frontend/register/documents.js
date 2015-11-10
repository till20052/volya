$(document).ready(function(){
	
	var __section = $("body>section>div.section");
	
	var __formUiWindow = (function(element){
		var __uiWindow = new Window(element);

		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function(){
			var __data = {
				id: $(__uiWindow.element).attr("data-id"),
				cid: __categoriesUiSelect.value(),
				number: $("#number", __uiWindow.element).val(),
				images: __imagesUiView.getImages(),
				created_at: kendo.toString(__createdAtUiInput.value(), "yyyy-MM-dd")
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

		var __categoriesUiSelect = (function(element){
			return $(element).kendoDropDownList({
				dataValueField: "id",
				dataTextField: "title",
				dataSource: ({
					data: ([{id: 0, title: "\u2014"}]).concat(eval($(">script", element).text()))
				})
			}).data("kendoDropDownList");
		})($("select[data-ui='categories']", __uiWindow.element));

		var __createdAtUiInput = $("input[data-ui='created_at']", __uiWindow.element).kendoDateTimePicker({
			format: "dd MMMM yyyy"
		}).data("kendoDateTimePicker");

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

		$("a[data-action='manage_categories']", __section).click(function(){
			__w.categories.open();
		});

		var __w = new Object();
		([
			{
				name: "categories",
				element: $("div[ui-window='register.documents.categories_form']"),
				actions: ({
					get_list: "/register/documents/j_get_categories",
					save_item: "/register/documents/j_save_category",
					delete_item: "/register/documents/j_delete_category"
				}),
				sender: __categoriesUiSelect,
				needEmptyItem: true
			}
		]).forEach(function(token){
			__w[token.name] = (function(element){
				var __uiWindow = (new Window(element)).afterOpen(function(){
					$.post(token.actions.get_list, function(response){
						if( ! response.success)
							return;
						__listUiTable.dataSource.data(response.list);
					}, "json");
				});

				$("a[data-action='add']", __uiWindow.element).click(function(){
					if($("input#title", __uiWindow.element).val() == ""){
						$("input#title", __uiWindow.element).css("borderColor", "red");
						setTimeout(function(){
							$("input#title", __uiWindow.element).css("borderColor", "");
						}, 2000);
						return;
					}

					$.post(token.actions.save_item, {
						title: $("input#title", __uiWindow.element).val()
					}, function(response){
						if( ! response.success)
							return;

						$("input#title", __uiWindow.element).val("");
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
									title: $(__this).val()
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

		return $.extend(__uiWindow, {
			getItemAndOpenWindow: (function(id){
				__imagesUiView.cleanUp();

				if(id > 0)
					$.post("/register/documents/j_get_document", {
						id: id
					}, function(response){
						if( ! response.success)
							return;

						var __item = response.item;

						$(__uiWindow.element).attr("data-id", __item.id);
						__categoriesUiSelect.value(__item.cid);
						__categoriesUiSelect.enable(false);

						$("#number", __uiWindow.element).val(__item.number);
						$("#number", __uiWindow.element).attr("disabled", true);

						__createdAtUiInput.value(kendo.parseDate(typeof data.created_at != "undefined" ? data.created_at : new Date()));
						__createdAtUiInput.enable(false);

						if(typeof __item.images != "undefined")
							__imagesUiView.setImages(__item.images);

						__uiWindow.open();
					}, "json");

				$(__uiWindow.element).removeAttr("data-id");
				__categoriesUiSelect.value(0);
				__categoriesUiSelect.enable(true);

				$("#number", __uiWindow.element).removeAttr("disabled");
				$("#number", __uiWindow.element).val("");

				__createdAtUiInput.value(0);
				__createdAtUiInput.enable(true);
			}),
		});

	}($("div[ui-window='register.documents.form']")));

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