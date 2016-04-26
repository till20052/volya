$(document).ready(function(){
	
	var __section = $("body>section>div.section"),
		__toolbarUiBox = $(">div>div[data-uiBox='toolbar']", __section);
	
	var __viewerUiWindow = (function(element){
		var __uiWindow = new Window(element);
		
		var __membersUiSpan = (function(element){
			return ({
				set: (function(list){
					var __list = new Array();
					$(element).empty();
					list.forEach(function(item){
						__list.push($("<a href=\"/profile/"+item.id+"\" />").html(item.name).prop("outerHTML"));
					});
					$(element).html(__list.join(", "));
				})
			});
		}($("span#members", __uiWindow.element)));
		
		return $.extend(__uiWindow, {
			viewItem: (function(id){
				$.post("/admin/register/j_get_cell_item", {
					id: id
				}, function(response){
					if( ! response.success)
						return;
					
					var __item = response.item;
					
					$("span#number", __uiWindow.element).html(__item.number);
					$("span#started_at", __uiWindow.element).html(__item.started_at);
					
					$("span#locality", __uiWindow.element).html(__item.locality);
					$("span#address", __uiWindow.element).html(__item.address);
					
					$("span#creator", __uiWindow.element).empty()
							.append($("<a href=\"/profile/"+__item.creator.id+"\" />").html(__item.creator.name));
					__membersUiSpan.set(__item.members);
					
					$("span#polling_places_numbers", __uiWindow.element).html(function(list){
						var __tokens = [];
						list.forEach(function(item){
							__tokens.push(item.number);
						});
						return __tokens.join(", ");
					}(__item.polling_places));
					$("span#polling_places_borders", __uiWindow.element).html(function(list){
						var __tokens = [];
						list.forEach(function(item){
							__tokens.push(item.borders.replace(/;\s/g, "<br />"));
						});
						return __tokens.join(", ");
					}(__item.polling_places));
					
					$("div#documents", __uiWindow.element).empty();
					__item.documents.forEach(function(document){
						$("div#documents", __uiWindow.element).append($("<a class=\"icon\" href=\"/s/storage/"+document+"\" target=\"_blank\"><i class=\"icon-file fs30\" style=\"padding: 0\"></i></a>"));
					});
					
					
					
					__uiWindow.open();
				}, "json");
			})
		});
	}($("div[ui-window='admin.register.cells.viewer']")));
	
	var __exportUiWindow = (function(element){
		var __uiWindow = new Window(element);
		
		return $.extend(__uiWindow, {
			getDocument: (function(url){
				$("div[data-uiBox='content']").empty()
						.append($("<iframe frameborder=\"0\" width=\"100%\" height=\"700px\" src=\"/s/pdf?url="+encodeURIComponent("/admin/register/export_cells/c7a455383a2f22f10465dae825acf661"+url)+"\" />"));
				__uiWindow.open();
			})
		});
	}($("div[ui-window='admin.register.export']")));
	
	var __filter = (function(){
		return ({
			prepare: (function(){
				var __params = "?";
				
				if(__regionUiSelect.value() != 0)
					__params += "region="+__regionUiSelect.value()+"&";
				
				return __params.substr(0, __params.length - 1);
			}),
			apply: (function(){
				window.location.href = "/admin/register/cells"+this.prepare();
			})
		});
	}());
	
	var __regionUiSelect = (function(element){
		return $(element).kendoDropDownList({
			value: $(element).attr("data-value"),
			change: (function(e){
				__filter.apply();
			})
		}).data("kendoDropDownList");
	}($("select[data-ui='region']", __toolbarUiBox)));
	
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
					__viewerUiWindow.viewItem($(__a).attr("data-id"));
					break;
			}
		});
		
		if( ! ($(">tr", __uiTable.tbody).length > 0))
			$(__uiTable.tbody).append(kendo.template($(__templates[__templates.length - 1]).html())({}));
		
		return __uiTable;
	}($("table[data-ui='list']", __section)));
	
});