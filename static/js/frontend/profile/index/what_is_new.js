$(document).ready(function(){
	
	var __section = $("body>section"),
		__uiBox = $("div[data-uiBox='what_is_new']", __section),
		__toolbarUiBox = $("div[data-uiBox='toolbar']", __uiBox);

	$("body").click(function(){
		$(__formUiBox.element).hide();
	});

	$("a.button", __toolbarUiBox).hover(function(){
		var __src = $(">img", this).attr("src"),
			__splitted = __src.split(".");
		$(">img", this).attr({
			"data-src": __src,
			src: __splitted[0]+"_hover."+__splitted[1]
		});
	}, function(){
		$(">img", this).attr({
			src: $(">img", this).attr("data-src")
		});
	}).click(function(){
		$(__formUiBox.element).show();
		$(">div[data-uiFrame]", __formUiBox.element).hide();
		$(">div[data-uiFrame='first']", __formUiBox.element).show();
		$(">span.bubble", __formUiBox.element).css({
			marginLeft: $(this).attr("data-bml")+"px"
		});
		event.stopPropagation();
		$(__formUiBox.element).attr("data-type", $(this).attr("data-type"));
		__formUiBox.text.value("");
		__formUiBox.text.update();
		$("input#title", __formUiBox.element).val("")
				.focus();
	});

	var __formUiBox = (function(element){
		$(element).click(function(event){
			event.stopPropagation();
		}).hide();

		var __uiForm = new Form($("form", element));
		__uiForm.beforeSend(function(){
			if($("input#title", element).val() == ""){
				$("input#title", element).css({
					backgroundColor: "rgba(255,0,0,.1)",
					borderColor: "red"
				});
				setTimeout(function(){
					$("input#title", element).css({
						backgroundColor: "",
						borderColor: ""
					});
				}, 1000);
				return false;
			}

			__uiForm.data({
				type: $(element).attr("data-type"),
				text: __textUiTextarea.value()
			});
		});
		__uiForm.afterSend(function(response){
			if( ! response.success)
				return;

			$(">div[data-uiFrame]", element).hide();
			$(">div[data-uiFrame='after_send']", element).show();

			__listUiBox.prepend(response.item);
		});

		var __textUiTextarea = $("textarea[data-ui='text']", element).kendoEditor({
			tools: [
				"bold",
				"italic",
				"underline",
				"justifyLeft",
				"justifyCenter",
				"justifyRight",
				"justifyFull"
			]
		}).data("kendoEditor");
		__textUiTextarea.body.style.font = $("body").css("font");

		return ({
			element: element,
			form: __uiForm,
			text: __textUiTextarea
		});
	}($("div[data-uiBox='form']", __uiBox)));

	var __listUiBox = (function(element){
		var __template = kendo.template($(">script[type='text/x-kendo-template']", element).text());

		$(">script[type='text/x-kendo-template']", element).remove();

		var __prepend = (function(data){
			$(element).prepend(__template(data));
		});

		return ({
			element: element,
			prepend: __prepend
		});
	}($("div[data-uiBox='list']", __uiBox)));
	
});