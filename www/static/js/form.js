var Form = (function(form)
{
	// PRIVATE FIELDS
	var _form = form;
	var _data = new Object();
	var __uiElements = new Object();
	
	var __beforeSend = (function(){ return true; }),
		__afterSend = (function(){ return true; });
	
	// PUBLIC FIELDS
	this.element = _form;
	
	// PRIVATE METHODS
	(function()
	{
		$(_form).attr("onsubmit", "return false;");
		$("input[type='submit']", _form).click(function()
		{
			__send();
		});
	})();
	
	var _scan = function()
	{
		var data = new Object();
		
		$("input[type='text'], input[type='checkbox'], input[type='radio'], input[type='hidden'], input[type='password'], select, textarea", _form).each(function(){
			var key;
			var value;
			
			if(
				($(this).is("input") && $.inArray($(this).attr("type"), ["text", "hidden", "password"]) != -1)
				|| $(this).is("textarea")
				|| $(this).is("select")
			)
			{
				if(typeof $(this).attr("id") != "undefined")
				{
					key = $(this).attr("id");
				}
				else if(typeof $(this).attr("name") != "undefined")
				{
					key = $(this).attr("name");
				}

				value = $(this).val();
			}
			
			if($(this).is("input") && $.inArray($(this).attr("type"), ["checkbox", "radio"]) != -1)
			{
				if(typeof $(this).attr("id") != "undefined")
				{
					key = $(this).attr("id");
				}
				else if(typeof $(this).attr("name") != "undefined")
				{
					if($(this).attr("name").match(/(\[)/))
						key = $(this).attr("name").split(/(\[|\])/)[0];
					else
						key = $(this).attr("name");
				}

				value = $(this).attr("checked") == "checked" ? 1 : 0;
			}
			
			if(typeof key != "undefined")
				data[key] = value;
		});
		
		return data;
	}
	
	var __send = (function()
	{
		if(__beforeSend() == false)
			return false;
		
		var __options = new Object({
			url: $(_form).attr("action"),
			type: $(_form).attr("method").toUpperCase(),
			data: $.extend(_data, _scan()),
			dataType: "json",
			complete: (function(xhr)
			{
				__afterSend(eval('('+xhr.responseText+')'));
			})
		});
		
		return $.ajax(__options);
	});
	
	// PUBLIC METHODS
	this.attr = function(attr, val)
	{
		if(typeof attr == 'object')
			$(_form).attr(attr);
		else if(typeof val != 'undefined')
			$(_form).attr(attr, val);
		else
			return $(_form).attr(attr);
		
		return true;
	}
	
	this.action = function(value)
	{
		if(typeof value != 'undefined')
			this.attr("action", value);
		else
			return this.attr("action");
		
		return true;
	}
	
	this.method = (function(value)
	{
		if(typeof value != 'undefined')
			this.attr("method", value);
		else
			return this.attr("method");
		
		return this;
	});
	
	this.beforeSend = (function(fn)
	{
		if(typeof fn == 'function')
			__beforeSend = fn;
		else if(typeof fn == 'undefined')
			return __beforeSend;
		
		return this;
	})
	
	this.afterSend = (function(fn)
	{
		if(typeof fn == 'function')
			__afterSend = fn;
		else if(typeof fn == 'undefined')
			return __afterSend;
		
		return this;
	});
	
	this.data = function(key, value)
	{
		if(typeof key == "object")
			_data = key; // $.extend(_data, key)
		else if(typeof value != "undefined")
			_data[key] = value;
		else if(typeof key != "undefined")
			return _data[key];
		
		return _data;
	}
	
	this.send = (function()
	{	
		__send();
	});
	
	this.ui = (function(name, ui)
	{
		if(typeof ui != "undefined")
			__uiElements[name] = ui;
		
		return __uiElements[name];
	});
});

