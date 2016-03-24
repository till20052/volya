$(document).ready(function(){
	
	var __section = $("body>section");
	
	var __bannerUiBox = (function(element){
		var __data = eval($(">script", element).html()),
			__coverUiBox = $(">div[data-uiBox='cover']", element),
			__prevIndex = __data.length - 1,
			__nextIndex = 0,
			__interval;
		
		var __checkIndex = (function(){
			__prevIndex = __nextIndex;
			__nextIndex++;
			if(typeof __data[__nextIndex] == "undefined")
				__nextIndex = 0;
		});
		
		var __showBannerByIndex = (function(prevIndex, nextIndex, withAnimation){
			var __withAnimation = typeof withAnimation != "undefined" ? withAnimation : true;
			
			$("div[data-uiBox='title']>a").attr("href", __data[nextIndex].href)
					.html(__data[nextIndex].title);
			$("div[data-uiBox='description']").html(__data[nextIndex].description);
			
			$("div:last-child>ul>li>a[data-index]", __coverUiBox).removeClass("selected");
			$("div:last-child>ul>li>a[data-index='"+nextIndex+"']", __coverUiBox).addClass("selected");	
			
			if( ! __withAnimation){
				$(">div[data-index]", element).css({
					opacity: 0
				});
				
				$(">div[data-index='"+nextIndex+"']", element).css({
					opacity: 1
				});
				
				__nextIndex = nextIndex;
				__checkIndex();
				
				__interval = setInterval(function(){
					__showBannerByIndex(__prevIndex, __nextIndex);
				}, 10000);
				
				return;
			}
			
			$(">div[data-index='"+prevIndex+"']", element).animate({
				opacity: 0
			}, 100);
			
			$(">div[data-index='"+nextIndex+"']", element).animate({
				opacity: 1
			}, 100, __checkIndex);
		});
		
//		$("div[data-uiBox='arrows']", element).css({
//			opacity: 0
//		}).hover(function(){
//			$(this).animate({
//				opacity: .75
//			}, 512);
//		}, function(){
//			$(this).animate({
//				opacity: 0
//			}, 256);
//		});
		
		$(__coverUiBox).click(function(e){
			var __element = $(e.srcElement);
			if(typeof $(__element).attr("data-action") == "undefined")
				__element = $($(__element).parents("*[data-action]").eq(0));

			switch($(__element).attr("data-action")){
				case "change_image":
					clearInterval(__interval);
					__interval = null;
					__nextIndex = parseInt($(__element).attr("data-index"));
					__prevIndex = __nextIndex - 1;
					if(__prevIndex < 0)
						__prevIndex = __data.length - 1;
					__showBannerByIndex(__prevIndex, __nextIndex, false);
					break;
			}
		});
		
		__data.forEach(function(item, i){
			var __div = $("<div />").attr({
				"data-uiBox": "banner",
				"data-index": i
			}).css({
				backgroundImage: "url(/s/img/thumb/x400/"+item.image+")"
			});
			
			var __li = $("<li />").append(
				$("<a href=\"javascript:void(0)\" />").attr({
					"data-action": "change_image",
					"data-index": i
				})
			);
			
			$(element).append(__div);
			$(">div:last-child>ul", __coverUiBox).append(__li);
		});
		
		__showBannerByIndex(__prevIndex, __nextIndex, false);
		
		return ({
			element: element,
			cover: __coverUiBox
		});
	})($("div[data-uiBox='banners']", __section));
	
	(function(element){
		$("td:nth-child(odd)", element).css({
			cursor: "pointer"
		}).click(function(){
			if( ! ($("a", this).length > 0))
				return;
			window.location.href = $("a", this).attr("href");
		});
	})($("table[data-ui='images']", __section));
	
	$(window).resize(function(){
		var __wW = $(this).width();

		$(">div", __bannerUiBox.cover).css({
			marginLeft: (__wW / 2) + "px",
			width: (__wW / 2) + "px"
		});
	});
	
});