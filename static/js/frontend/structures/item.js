$(document).ready(function(){

	var __section = $("body>section"),
		__contentUiBox = $("[data-id='content']", __section);

	$("a[data-action='join']", __section).click(function(){

		$.post("/structures/join_structure", {
			sid: $(this).attr("data-id"),
			geo: $(this).attr("data-geo")
		}, function(res){
			if( ! res.success){
				alert(res.msg);
				$(this).remove();
				return false;
			}
		}, "json");

	});

});