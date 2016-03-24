$(document).ready(function(){
	
	var __section = $("body>section>div.section");
	
	$("div.preview", __section).css({
		cursor: "pointer"
	}).click(function(){
		window.location.href = $(this).attr("data-href");
	});

	$("a[data-action='search']", __section).click(function(){
		window.location.href = "?q="+encodeURIComponent($("input#query", __section).val());
	});

	(function(element){
		if( ! ($(element).length > 0))
			return;

		$(element).kendoDropDownList({
			value: $(element).attr("data-value"),
			change: function(e){
				var __param = (function(href){
					var __o = new Object();
					(href.substr(href.indexOf("?")+1).split("&")).forEach(function(item){
						var __t = item.split("=");
						__o[__t[0]] = __t[1];
					});
					return __o;
				})(window.location.href);

				delete __param.page;
				delete __param.geo;

				var __href = "?";
				for(var __field in __param)
					__href += __field+"="+__param[__field]+"&";

				window.location.href = __href+"geo="+e.sender.value();
			}
		})
	})($("select[data-ui='regions']", __section));

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