$(document).ready(function(){
	
	var __section = $("body>section");
	
	//$("div[data-uiBox='news_content'] img", __section).remove();
	
	$("div[data-uiBox='news_content'] a", __section).each(function(){
		var __matched = $(this).attr("href").match(/^\/news\/(.*)\/(.*)/);

		if(__matched == null)
			return;

		$(this).attr("href", "/news/"+__matched[2]);
	});
	
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
		
		$(">div", imagesUiBox).click(function(){
			$(">div", imagesUiBox).css({
				borderColor: "",
				opacity: 1
			});
			
			$(this).css({
				borderColor: "#0181C5",
				opacity: .5
			});
			
			previewUiBox.attr({
				"data-hash": $(this).attr("data-hash")
			}).css({
				backgroundImage: "url('/s/img/thumb/630x/"+$(this).attr("data-hash")+"')"
			});
		});
		
		$(">div:first-child", imagesUiBox).click();
		
		if( ! ($(">div", imagesUiBox).length > 2))
			$(imagesUiBox).hide();
	})(
			$("div[data-uiBox='preview']", __section),
			$("div[data-uiBox='images']", __section),
			$("div[ui-window='news.index.view_item.image_viewer']")
	);
	
	(function(element){
		if( ! ($(element).length > 0))
			return;
		
		$(element).kendoDropDownList({
			dataValueField: "id",
			dataTextField: "name",
			dataSource: ({
				data: ([{id: 0, name: "\u2014"}]).concat(eval($(">script", element).text()))
			}),
			value: $(element).attr("data-ecid"),
			change: (function(e){
				var __param = (function(href){
					var __o = new Object();
					(href.substr(href.indexOf("?")+1).split("&")).forEach(function(item){
						var __t = item.split("=");
						__o[__t[0]] = __t[1];
					});
					return __o;
				})(window.location.href);
				
				delete __param.page;
				delete __param.tag;
				
				var __href = "?";
				for(var __field in __param)
					__href += __field+"="+__param[__field]+"&";
				
				window.location.href = __href+"ecid="+e.sender.value();
			})
		});
	})($("select[data-ui='election_candidates']", __section));
	
});