$(document).ready(function(){

	var __section = $("body>section"),
		__contentUiBox = $("[data-id='content']", __section);

	$("[data-id='tabstrip']", __contentUiBox).kendoTabStrip({
		animation:  {
			open: {
				effects: "fadeIn"
			}
		}
	});

	$("a[data-action='join']", __section).click(function(){

		$.post("/structures/join_structure", {
			sid: $(this).attr("data-id")
		}, function(res){
			if( ! res.success)
				alert("Ви вже долучені до однієї з структур");

			window.location.href = window.location.href;
			$(this).remove();
		}, "json");

	});

});