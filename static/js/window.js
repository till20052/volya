var Window = (function(element)
{
	var __window = element;
	var __windowsUiBox = $($(__window).parents("div[ui-box='windows']").eq(0));
	
	var __beforeOpen = (function(){}),
		__afterOpen = (function(){}),
		__beforeClose = (function(){}),
		__afterClose = (function(){});
		
	var __uiElements = new Object();
	
	this.element = __window;
	
	(function()
	{
		window.onmousewheel =
		document.onmousewheel = (function()
		{
			return true;
		});
		
		var __windowContent = $(__window).html();
		$(__window).empty()
				.append($("<div />").html(__windowContent));
		
		if($("a.closeButton", __window).length == 1)
		{
			$("a.closeButton", __window).attr("href", "javascript:void(0);")
					.click(function()
					{
						__close();
					})
					.append($("<i class=\"icon-remove\"></i>"));
					
		}
		
		([__window, __windowsUiBox]).forEach(function(element)
		{
			$(element).hide();
		});
	})();
	
	var __open = (function(fn)
	{
		$(">div[ui-window]", __windowsUiBox).each(function()
		{
			$(this).hide();
		});
		
		$("body").css("overflow", "hidden");
		
		window.onscroll =
		document.onscroll = (function()
		{
			return false;
		});
		
		([__window, __windowsUiBox]).forEach(function(element)
		{
			$(element).show()
					.css("opacity", 0);
		});
		
		var __marginTop = Math.ceil(($(__windowsUiBox).height() - ($(__window).height() + 250)) / 2);
		if(__marginTop < 20)
			__marginTop = 20;
		
		__beforeOpen();
		
		$(__windowsUiBox).css({
			opacity: 1,
			marginTop: $(window).scrollTop()+"px",
			overflow: "auto"
		});
		
		$(__window).css({
			opacity: 1,
			marginTop: __marginTop+"px"
		});
		
		__afterOpen();
		
		if(typeof fn == "function")
			fn();
	});
	
	var __close = function(fn)
	{
		$("body").css("overflow", "");
		
		window.onscroll =
		document.onscroll = (function()
		{
			return true;
		});
		
		__beforeClose();
		
		([__window, __windowsUiBox]).forEach(function(element)
		{
			$(element).hide();
		});
		
		__afterClose();
		
		if(typeof fn == "function")
			fn();
	}
	
	this.beforeOpen = (function(fn)
	{
		if(typeof fn == "function")
			__beforeOpen = fn;
		else if(typeof fn == "undefined")
			return __beforeOpen;
		
		return this;
	});
	
	this.open = (function(fn)
	{
		__open(fn);
	});
	
	this.afterOpen = (function(fn)
	{
		if(typeof fn == "function")
			__afterOpen = fn;
		else if(typeof fn == "undefined")
			return __afterOpen;
		
		return this;
	});
	
	this.beforeClose = (function(fn)
	{
		if(typeof fn == "function")
			__beforeClose = fn;
		else if(typeof fn == "undefined")
			return __beforeClose;
		
		return this;
	});
	
	this.close = (function(fn)
	{
		__close(fn);
	});
	
	this.afterClose = (function(fn)
	{
		if(typeof fn == "function")
			__afterClose = fn;
		else if(typeof fn == "undefined")
			return __afterClose;
		
		return this;
	});
	
	this.ui = (function(name, ui)
	{
		if(typeof ui != "undefined")
			__uiElements[name] = ui;
		
		return __uiElements[name];
	});
	
	this.checkPosition = (function()
	{
		var __marginTop = Math.ceil(($(__windowsUiBox).height() - ($(__window).height() + 250)) / 2);
		if(__marginTop < 20)
			__marginTop = 20;
		
		$(__window).animate({
			marginTop: __marginTop+"px"
		}, 200);
	});
});
