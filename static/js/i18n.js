var i18n = function(data)
{
	var __fields = typeof data.fields != "object"
		? new Array()
		: data.fields;
	
	var __languages = typeof data.languages != "object"
		? new Array()
		: data.languages;
	
	var __i18n = new Object();
	
	var __init = function()
	{
		for(var __i in __fields)
		{
			__i18n[__fields[__i]] = new Object();
			for(var __j in __languages)
				__i18n[__fields[__i]][__languages[__j]] = "";
		}
	}
	
	this.value = function(field, value)
	{
		if(typeof field != "string")
			return __i18n;
		
		var __tokens = field.split(".");
		
		var __field = __tokens[0];
		var __lang = __tokens[1];

		if(
				typeof __field != "undefined"
				&& typeof __i18n[__field] != "undefined"
		){
			if(
					typeof __lang != "undefined"
					&& typeof __i18n[__field][__lang] != "undefined"
			){
				if(typeof value == "string")
					__i18n[__field][__lang] = value;

				return __i18n[__field][__lang];
			}

			if(typeof value == "object")
				__i18n[__field] = value;

			return __i18n[__field];
		}

		return null;
	}
	
	this.clearValues = function()
	{
		for(var __i in __fields)
		{
			for(var __j in __languages)
				__i18n[__fields[__i]][__languages[__j]] = "";
		}
	}
	
	__init();
}