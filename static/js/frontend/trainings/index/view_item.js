$(document).ready(function(){
	
	var __section = $("body>section"),
		__dashboard = $(">div.dashboard", __section);
		
	$("input#join", __dashboard).click(function(){
		$.post("/trainings/members/j_add_member", {
			training_id: $(this).attr("data-trainingId")
		}, function(response){
			if( ! response.success)
				return;
			
			$("<div data-uiBox=\"already_registred\" />").html("Ви вже зареєстровані")
					.insertBefore($("input#join", __dashboard));
			
			$("input#join", __dashboard).remove();
			
			var __uiLabel = $("span[data-uiLabel='count_training_members']", __dashboard);
			$(__uiLabel).html(parseInt($(__uiLabel).html()) + 1);
		}, "json");
	});
	
});