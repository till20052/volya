$(document).ready(function(){
	
	var __section = $("body>section>div.section");
	
	var __supportUiWindow = (function(element){
		var __uiWindow = (new Window(element)).afterOpen(function(){
			$("div[data-uiBox='form']", __uiWindow.element).show();
			$("div[data-uiBox='success']", __uiWindow.element).hide();
			
			$("input#name", __uiForm.element).val("");
			$("input#email", __uiForm.element).val("");
			__phoneUiTextBox.value("");
			
			__uiWindow.checkPosition();
		});
		
		var __uiForm = (new Form($("form", __uiWindow.element))).beforeSend(function(){
			var __phoneArr = __phoneUiTextBox.value().match(/([0-9])/g);
			if(__phoneArr == null)
				__phoneArr = new Array();
			
			__uiForm.data({
				helper_type: 1,
				candidate_id: $(__uiForm.element).attr("data-candidateId"),
				phone: "+38"+__phoneArr.join("")
			});
		}).afterSend(function(response){
			if(response.success){
				$("div[data-uiBox='form']", __uiWindow.element).hide();
				$("div[data-uiBox='success']", __uiWindow.element).show();
				
				__uiWindow.checkPosition();
				
				$("a[data-action='support']", __section).next().show();
				$("a[data-action='support']", __section).hide();
			
				return;
			}
			
			if(typeof response.errors == "undefined" || ! (response.errors.length > 0))
				return;
			
			var __err = response.errors,
				__elements = new Array();
			
			if($.inArray("name_should_not_be_empty", __err) != -1)
				__elements.push($("input#name", __uiForm.element));
			
			if($.inArray("email_has_not_correct_value", __err) != -1)
				__elements.push($("input#email", __uiForm.element));
			
			if(__elements.length > 0){
				__elements.forEach(function(element){
					$(element).css("borderColor", "red");
				});
				setTimeout(function(){
					__elements.forEach(function(element){
						$(element).css("borderColor", "");
					});
				}, 2048);
			}
				
		});
		
		var __phoneUiTextBox = $("input[data-ui='phone']", __uiForm.element).kendoMaskedTextBox({
			mask: "000 000 00 00",
			promptChar: " ",
			value: ""
		}).data("kendoMaskedTextBox");
		
		$("a[data-action='submit']", __uiForm.element).click(function(){
			__uiForm.send();
		});
		
		return __uiWindow;
	})($("div[ui-window='election.index.candidates.item.support']"));
	
//	(function(element){
//		$(">div[data-uiBox='text']", element).css({
//			height: ($(">div", $($($(element).parents("td").eq(0)).prev())).height() - 70) + "px"
//		});
//		
//		$("a[data-action='show']", element).click(function(){
//			$(">div[data-uiBox='bigText']", element).show();
//		});
//		
//		$("a[data-action='close']", $(">div[data-uiBox='bigText']", element)).click(function(){
//			$(">div[data-uiBox='bigText']", element).hide();
//		}).click();
//	})($("div[data-uiBox='program']", __section));
	
	([
		$("div[data-uiCarousel='competitors']", __section),
		$("div[data-uiCarousel='punished']", __section)
	]).forEach(function(element){
		if( ! ($(element).length > 0))
			return;
		
		(function(element){
			var __contentUiBox = $(">div[data-uiBox='content']", element);

			var __tr = $(">table>tbody>tr", __contentUiBox),
				__count = $(">td", __tr).length - 2,
				__tdWidth = $(">td:nth-child(2)", __tr).prop("offsetHeight"),
				__tdPaddingRight = parseInt($(">td:nth-child(2)", __tr).css("paddingRight"));

			$(">table", __contentUiBox).width(__count * __tdWidth + (__count - 1) * __tdPaddingRight + 192);

			var __delta = 0;
			setInterval(function(){
				$(__contentUiBox).scrollLeft($(__contentUiBox).scrollLeft() - __delta);
			}, 10);

			$(element).mousemove(function(e){
				__delta = (($(window).width() / 2) - e.clientX) / 15;
			}).mouseout(function(){
				__delta = 0;
			});
		})(element);
	});
	
	$("a[data-action='support']", __section).click(function(){
		__supportUiWindow.open();
	}).next().hide();
	
});