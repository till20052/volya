$(document).ready(function(){
	
	var __section = $("body>section"),
		__contentUiBox = $("td[data-uiBox='content']", __section);

	var __usersFinderUiWindow = (function(){
		var __uiWindow = new Window($("div[ui-window='cells.index.users_finder']"));
		__uiWindow.beforeOpen(function(){
			$("input#q", __uiWindow.element).val("");
			$(">div[data-item]", __selectedUsersUiList.element).remove();
			__uiWindow.checkPosition();
		});

		var __selectedUsersUiList = (function(){
			var __element = $("div[data-uiList='selected_users']", __uiWindow.element),
				__template = kendo.template($(">script[type='text/x-kendo-template']", __element).text());

			$(__element).click(function(event){
				var __a = $($(event.target).parents("a").eq(0));
				switch($(__a).attr("data-event")){
					case "remove":
						$($(__a).parents("div[data-item]").eq(0)).remove();
						break;
				}
			});

			var __add = (function(data){
				$(__template(data)).insertBefore($(">div.cboth", __element));
			});

			return ({
				element: __element,
				add: __add
			});
		}());
		__uiWindow.ui("selected_users", __section);

		$("input#find", __uiWindow.element).click(function(){
			var __q = $("input#q", __uiWindow.element).val();

			if(__q == "")
				return;

			$.post("/api/users/j_find", {
				q: __q
			}, function(response){
				__listUiTable.dataSource.data(response.users);
				__uiWindow.checkPosition();
			}, "json");
		});

		var __listUiTable = (function(){
			var __element = $("table[data-ui='list']", __uiWindow.element),
				__options = eval($(">script#options", __element).text()),
				__templates = $.map($(">script[type='text/x-kendo-template']", __element), function(template){
					return kendo.template($(template).text());
				});

			for(var __i in __options["columns"])
				__options["columns"][__i]["template"] = __templates[__i];

			var __uiGrid = $(__element).kendoGrid($.extend({}, __options, {
				dataSource: {
					data: [],
					scheme: {model: {id: "id"}}
				}
			})).data("kendoGrid");

			$(__uiGrid.wrapper).click(function(event){
				switch($(event.target).attr("data-event")){
					case "add_user":
						__selectedUsersUiList.add(__uiGrid.dataSource.get($(event.target).attr("data-id")));
						break;
				}
			});

			return __uiGrid;
		}());

		var __selectedUsersUiList = (function(){
			var __element = $("div[data-uiList='selected_users']", __uiWindow.element),
				__template = kendo.template($(">script[type='text/x-kendo-template']", __element).text());

			$(__element).click(function(event){
				var __a = $($(event.target).parents("a").eq(0));
				switch($(__a).attr("data-event")){
					case "remove_user":
						$($(__a).parents("div[data-item]").eq(0)).remove();
						break;
				}
			});

			var __add = (function(data){
				$(__template(data)).insertBefore($(">div.cboth", __element));
			});

			return ({
				element: __element,
				add: __add
			});
		}());

		$("a#add_users", __uiWindow.element).click(function(){

			$(">div[data-item]", __selectedUsersUiList.element).each(function(){
				$.post("/cells/j_add_users", {
					user_id: $(this).attr("data-item"),
					cell_id: $("a#add_cell_users", __section).attr("data-cell-id")
				},"json");
			});

			__uiWindow.close();
		});

		return __uiWindow;
	}());

	$("a#add_cell_users", __section).click(function(){
		__usersFinderUiWindow.open();
	});

	$("a#delete_user", __section).click(function(){
		var __userId = $(this).attr("data-userId");
		var __cellId = $(this).attr("data-cellId");

		var __confirmUiWindow = (function()
		{
			var __uiWindow = new Window($("div[ui-window='cells.index.confirm']"));

			$("a#yes", __uiWindow.element).click(function(userId)
			{
				$.post("/cells/j_delete_users", {
					user_id: __userId,
					cell_id: __cellId
				}, function(response)
				{
					if( ! response.success)
						return;

					$("tr[data-userId='"+__userId+"']", __section).remove();

					__uiWindow.close();
				}, "json");
			});

			$("a#no", __uiWindow.element).click(function()
			{
				__uiWindow.close();
			});

			return __uiWindow;
		})();

		__confirmUiWindow.open();
	});

	(function(element){

		if( ! $(element).hasClass("tabbar"))
			$(element).addClass("tabbar");

		$(">ul>li", element).click(function(){
			$(">li", $(this).parents("ul").eq(0)).removeClass("selected");
			$(this).addClass("selected");
			$(">div", element).hide();
			$(">div[data-uiBox='"+$(">a", this).attr("data-boxId")+"']", element).show();
		});

		var __isClicked = false;
		window.location.hash.split(/^\#|\&/i).forEach(function(token){
			var __tokens = token.split(/\=/i);

			if(
					token == ""
					|| ! (__tokens.length > 0)
					|| __tokens[0] != "tab"
			)
				return;

			$(">ul>li>a[data-boxId='"+__tokens[1]+"']", element).click();

			__isClicked = true;
		});

		if( ! __isClicked)
			$(">ul>li:first-child", element).click();

	}($("div[data-uiTabbar='main']", __contentUiBox)));
	
});