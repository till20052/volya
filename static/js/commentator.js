var Commentator = function(o)
{
	var __element = o.element;
	var __template = kendo.template(o.template);
	var __data = typeof o.data != "object" ? new Array() : o.data;
	var __fn = {
		onAdd: typeof o.onAdd != "function" ? function(){} : o.onAdd
	}
	
	this.element = __element;
	
	var __init = function()
	{
		$(__element).append($("<ul />"));
		__buildTree(__data);
	}
	
	var __append = function(item, parent)
	{
		var __target = __element;
		
		if(typeof parent == "undefined")
			parent = 0;
		
		if(parent != 0)
		{
			if( ! ($("li[data-id='"+parent+"']>ul", __element).length > 0))
				$("li[data-id='"+parent+"']", __element).append($("<ul />"));
			
			__target = $("li[data-id='"+parent+"']", __element);
		}
		
		var __li = $("<li data-id=\""+item.id+"\" />");
		__li.append(__template({item: item}));
		
		$(">ul", __target).append(__li);
		
		__fn.onAdd({
			node: __li
		});
	}
	
	var __buildTree = function(tree, parent)
	{
		for(var __i in tree)
		{
			__append(tree[__i], parent);
			
			if(typeof tree[__i].children == "object")
				__buildTree(tree[__i].children, tree[__i].id);
		}
	}
	
	this.add = function(item, parent)
	{
		__append(item, parent);
	}
	
	this.data = function(data)
	{
		if(typeof data == "undefined")
			return __data;
		
		__data = data;
		__buildTree(__data);
		
		return __data;
	}
	
	__init();
	
}