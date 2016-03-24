$(document).ready(function(){
	
	var __section = $("body>section");
	var __hideFormUiBox = $("div[ui-box='hide_form']", __section);
	
	var __confirmUiWindow = (function()
	{
		var __uiWindow = new Window($("div[ui-window='admin.menu.confirm']"));
		
		$("a#yes", __uiWindow.element).click(function()
		{
			var __selected = __menuUiTree.select();
			$.post("/admin/menu/j_delete", {
				id: __menuUiTree.dataItem(__selected).id
			}, function(response){
				if( ! response.success)
					return;
				
				__menuUiTree.remove(__selected);
				__menuUiTree.options.select({
					sender:	__menuUiTree
				});
				__uiWindow.close();
			}, "json");
		});
		
		$("a#no", __uiWindow.element).click(function()
		{
			__uiWindow.close();
		});
		
		return __uiWindow;
	})();
	
	$("a#add", __section).click(function(){
		var __selected = __menuUiTree.select();
		var __dataItem = __menuUiTree.dataItem(__selected);
		var __parent = typeof __dataItem != "undefined" ? __dataItem.id : 0;
		$.post("/admin/menu/j_save", {
			parent: __parent
		}, function(response){
			if( ! response.success)
				return;
			
			delete response.item.parent;
			
			var __parentItem;
			if(__parent > 0)
				__parentItem = __selected;
			__menuUiTree.append(response.item, __parentItem);
		}, "json");
	});
	
	$("a#remove", __section).click(function(){
		if($(this).css("opacity") != 1)
			return;
		__confirmUiWindow.open();
	});
	
	var __menuUiTree = $("div[ui-tree='menu']", __section).kendoTreeView({
		dataTextField: ["name_ua", "children"],
		template: "# if(item.name_ua != ''){ ##=item.name_ua## } else { #[ без назви ]# } #",
		dragAndDrop: true,
		dataSource: {
			schema: {
				model: {
					children: "sub_tree"
				}
			}
		},
		select: function(e)
		{
			if(typeof e.node == "undefined")
			{
				$("a#remove", __section).css("opacity", .3);
				$(__hideFormUiBox).show()
				.css({
					width: $(__hideFormUiBox).parent().width() + "px",
					height: $("div[ui-tree='menu']", __section).height() + "px"
				});
				return;
			}
			
			$("a#remove", __section).css("opacity", 1);
			$(__hideFormUiBox).hide();
			
			var __dataItem = e.sender.dataItem(e.node);
			
			$("a#remove", __section).css("opacity", __dataItem.id > 0 ? 1 : .3);
			
			var __name = new Object();
			$.each($("input[ui-lang]", __uiForm.element), function(){
				__name[$(this).attr("ui-lang")] = __dataItem.name[$(this).attr("ui-lang")];
			});
			
			$(__uiForm.element).attr("data-id", __dataItem.id);
			__i18n.value("name", __name);
			$("input#href", __uiForm.element).val(__dataItem.href);
			$("input#is_public", __uiForm.element).attr("checked", __dataItem.is_public != 1 ? false : true);
			
			$($("input[ui-lang]", __uiForm.element)[0]).click();
		},
		dragend: function(e)
		{
			var __sourceNode = $(e.sourceNode);
			var __parentNode = $($(e.sourceNode).parents("li").eq(0))
			
			var __data = {
				id: e.sender.dataItem(__sourceNode).id,
				parent: 0,
				order: []
			}
			
			if($(__parentNode).length == 1)
				__data.parent = e.sender.dataItem(__parentNode).id;
			
			$(">li", $(__sourceNode).parent()).each(function(i){
				__data.order.push({
					id: e.sender.dataItem(this).id,
					priority: i
				});
			});
			
			$.post("/admin/menu/j_on_dragend", __data, function(response){
				if( ! response.success)
					return;
				
				delete response.item.parent;
				
				var __dataItem = e.sender.dataItem(__sourceNode);
				for(var __field in response.item)
					__dataItem.set(__field, response.item[__field]);
			}, "json");
		}
	}).data("kendoTreeView");
	
	__menuUiTree.options.select({
		sender: __menuUiTree
	});
	
	var __uiForm = new Form($("form", __section));
	__uiForm.beforeSend(function(){
		__uiForm.data({
			id: $(__uiForm.element).attr("data-id"),
			name: __i18n.value("name")
		});
	});
	__uiForm.afterSend(function(response){
		if( ! response.success)
			return;
		
		delete response.item.parent;
		
		var __dataItem = __menuUiTree.dataItem(__menuUiTree.select()[0]);
		for(var __field in response.item)
			__dataItem.set(__field, response.item[__field]);
		
		__menuUiTree.updateIndeterminate();
	});
	
	var __i18n = new i18n({
		languages: $.map($("input[ui-lang]", __uiForm.element), function(item){return $(item).attr("ui-lang")}),
		fields: ["name"]
	});
	
	$("input[ui-lang]", __uiForm.element).click(function(){
		var __lang = $(this).attr("ui-lang");
		$("input[ui='name']", __uiForm.element).val(__i18n.value("name."+__lang));
	});
	
	$("input[ui='name']", __uiForm.element).change(function(){
		var __lang = $("input[ui-lang]:checked", __uiForm.element).attr("ui-lang");
		__i18n.value("name."+__lang, $(this).val());
	});
	
	$("input[ui='translit_link']", __uiForm.element).click(function(){
		$("input[ui='name']", __uiForm.element).translit("send", $("input#href", __uiForm.element));
	});
	
	$.post("/admin/menu/j_get_data", function(response){
		if( ! response.success)
			return;
		
		__menuUiTree.dataSource.data(response.tree);
	}, "json");
	
});