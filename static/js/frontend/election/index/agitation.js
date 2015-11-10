$(document).ready(function(){
	
	var __section = $("body>section>div.section"),
		__rightSideUiBox = $("div[data-uiBox='right_side']", __section);
	
	// Right Side
	(function(element){
		var __uiSelect = $(element).kendoDropDownList({
			dataValueField: "id",
			dataTextField: "county_number",
			dataSource: ({
				data: eval($(">script", element).text())
			}),
			change: (function(e){
				var __item = e.sender.dataSource.get(e.sender.value());
				
				console.log(__item);
				
				(["email", "phone"]).forEach(function(field){
					$("div[data-uiBox='"+field+"']", __rightSideUiBox).hide();
					if(typeof __item.contacts[field] != "undefined" && __item.contacts[field].length > 0){
						$("div[data-uiBox='"+field+"']", __rightSideUiBox).show();
						$("div[data-uiBox='"+field+"']>span", __rightSideUiBox).html(__item.contacts[field].join(", "));
					}
				});
			})
		}).data("kendoDropDownList");
		
		__uiSelect.options.change({
			sender: __uiSelect
		});
	})($("select[data-ui='counties']", __rightSideUiBox));
	
	// General Switch
	(function(element){
		$("a", element).click(function(){
			$(">li", element).removeClass("selected");
			$(">li>a", element).css({
				textDecoration: "",
				cursor: ""
			});
			
			$($(this).parents("li").eq(0)).addClass("selected");
			$(this).css({
				textDecoration: "none",
				cursor: "default"
			});
			
			if($(">span", $($(this).parents("li").eq(0))).length > 0){
				$(__candidatesUiSelect.wrapper).show();
				__candidatesUiSelect.value(0);
				return;
			}
			else {
				$(__candidatesUiSelect.wrapper).hide();
			}
			
			$.post("/election/index/j_get_agitations", {
				in_election: 1
			}, function(response){
				__categoriesUiSwitch.agitations(response.agitations);
				__categoriesUiSwitch.setData(response.categories);
				setTimeout(function(){
					$(">li:first>a", __categoriesUiSwitch.element).click();
				}, 100);
			}, "json");
		});
		
		var __candidatesUiSelect = $("select[data-ui='candidates']", element).kendoDropDownList({
			change: (function(e){
				if( ! (e.sender.value() > 0))
					return;
				$.post("/election/index/j_get_agitations", {
					candidate_id: e.sender.value()
				}, function(response){
					__categoriesUiSwitch.agitations(response.agitations);
					__categoriesUiSwitch.setData(response.categories);
					$(">li:first-child>a", __categoriesUiSwitch.element).click();
				}, "json");
			})
		}).data("kendoDropDownList");
		
		var __candidateId = 0,
			__hash = parseInt(window.location.hash.substring(1));
		$.map(__candidatesUiSelect.dataSource.data(), function(item){
			if(__hash != item.value)
				return;
			__candidateId = __hash;
		});
		
		if(__candidateId > 0){
			$(">li:last-child>a", element).click();
			__candidatesUiSelect.value(__candidateId);
			__candidatesUiSelect.options.change({
				sender: __candidatesUiSelect
			});
		}
		else
			$(">li:first-child>a", element).click();
	})($("ul[data-uiSwitch='general']", __section));
	
	// Categories Switch
	var __categoriesUiSwitch = (function(element){
		var __agitationsUiDiv = $("div[data-ui='agitations']", __section),
			__groupTemplate = kendo.template($(">script#group", __agitationsUiDiv).html()),
			__itemTemplate = kendo.template($(">script#item", __agitationsUiDiv).html()),
			__agitations = new Array();
		
		var __cleanUp = (function(){
			$(">li", element).remove();
		});
		
		var __addCategory = (function(id, name){
			$(element).append(
				$("<li />").append(
					$("<a />").attr({
						href: "javascript:void(0);",
						"data-action": "switch_category",
						"data-id": id
					}).html(name)
				)
			);
		});
		
		var __setData = (function(data){
			__cleanUp();
			data.forEach(function(item){
				__addCategory(item.id, item.name);
			});
		});
		
		var __switchCategory = (function(__element){
			$(">li", element).removeClass("selected");
			$(">li>a", element).css({
				textDecoration: "",
				cursor: ""
			});
			
			$($(__element).parents("li").eq(0)).addClass("selected");
			$(__element).css({
				textDecoration: "none",
				cursor: "default"
			});
			
			$(">div", __agitationsUiDiv).remove();
			
			var __categoryId = $(__element).attr("data-id");
			__agitations.forEach(function(item){
				if($.inArray(__categoryId, item.categories_ids) == -1)
					return;
				
				if($(">div[data-name='"+item.name+"']", __agitationsUiDiv).length != 1)
					__agitationsUiDiv.append(__groupTemplate({
						name: item.name
					}));
				
				var __groupUiDiv = $(">div[data-name='"+item.name+"']", __agitationsUiDiv);
				
				$(__itemTemplate(item)).insertBefore($(">div:last-child>div:last-child", __groupUiDiv));
			});
		});
		
		$(element).click(function(event){
			var __element = $(event.target);
			if(typeof $(__element).attr("data-action") == "undefined")
				__element = $($(__element).parents("*[data-action]").eq(0));

			switch($(__element).attr("data-action")){
				case "switch_category":
					__switchCategory(__element);
					break;
			}
		});
		
		return ({
			element: element,
			cleanUp: __cleanUp,
			addCategory: __addCategory,
			setData: __setData,
			agitations: (function(agitations){
				__agitations = agitations;
			})
		});
	})($("ul[data-uiSwitch='categories']", __section));
});