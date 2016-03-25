$(document).ready(function(){
	
	var __commentsUIBox = $("body>section div[ui-box='comments']");
	var __formUIBox = $(">div[ui='form']", __commentsUIBox);
	var __treeUIBox = $(">div[ui='tree']", __commentsUIBox);
	
	var __initUiForm = function(uiForm)
	{
		var __css = [
			{color: "#A0A0A0", fontStyle: "italic", borderColor: ""},
			{color: "", fontStyle: "", borderColor: ""}
		];
		
		$("input[type='text'],textarea", uiForm).each(function(){
			$(this).attr({
				"data-empty": 1
			}).css(__css[0]).focus(function(){
				if($(this).attr("data-empty") == 1)
					$(this).css(__css[1])
					.val("");
			}).blur(function(){
				if($(this).val() == "")
					$(this).attr("data-empty", 1)
					.css(__css[0])
					.val($(this).attr("data-label"));
				else
					$(this).attr("data-empty", 0);
			}).val($(this).attr("data-label"));
		});
	}
	
	var __mainUiForm = (new Form($(">form", __formUIBox))).beforeSend(function()
	{
		var __hasError = false;
		
		$("input[type='text'],textarea", __mainUiForm.element).each(function(){
			$(this).css("borderColor", "");
			
			if($(this).attr("data-required") != 1)
				return;
			
			if(
					$(this).val() != "" 
					&& $(this).val() != $(this).attr("data-label")
			)
				return;
			
			$(this).css("borderColor", "#EE9725");
			__hasError = true;
		});
		
		if(__hasError)
			return false;
		
		__mainUiForm.data({
			content_id: $(__commentsUIBox).attr("data-cid"),
			parent_id: 0,
			author_id: $(__mainUiForm.element).attr("data-aid")
		});
		
		return true;
	}).afterSend(function(response)
	{
		if( ! response.success)
			return;
		$("input[type='text'],textarea", __mainUiForm.element).each(function(){
			$(this).val($(this).attr("data-label"));
		});
		__uiCommentator.add(response.item);
	});
	
	console.log(__mainUiForm.element);
	
	__initUiForm(__mainUiForm.element);
	
	var __data = eval($(">data", __treeUIBox).text());
	var __template = $(">template", __treeUIBox).html().toString();
	$(__treeUIBox).empty();
	
	var __uiCommentator = new Commentator({
		element: __treeUIBox,
		data: __data,
		onAdd: function(e)
		{
			$("input[ui='reply']", e.node).click(function(){
				$("div[ui='form']", __treeUIBox).remove();
				
				$(">div", $(e.node)).append($(__formUIBox).clone());
				$(">div[ui='form']", $(">div", $(e.node))).css("marginTop", "10px")
				
				var __uiForm = new Form($(">div[ui='form']>form", $(">div", $(e.node))));
				__uiForm.beforeSend(function(){
					__uiForm.data({
						content_id: $(__commentsUIBox).attr("data-cid"),
						parent_id: $(e.node).attr("data-id"),
						author_id: $(__uiForm.element).attr("data-aid")
					});
				});
				__uiForm.afterSend(function(response){
					if( ! response.success)
						return;
					$(">div[ui='form']", $(">div", $(e.node))).remove();
					__uiCommentator.add(response.item, __uiForm.data("parent_id"));
				});
				
				__initUiForm(__uiForm.element);
			});
		},
		template: __template
	});
	
});