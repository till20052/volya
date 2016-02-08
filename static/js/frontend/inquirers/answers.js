$(document).ready(function(){

	var grid = $('.grid'),
		pinfo = $("[data-id='personal_info']"),
		notices = $("[data-role='notices']").notices({
			duration: 800,
			autoHide: true,
			delay: 4000
		});

	grid.masonry({
		itemSelector: '.grid-item',
		columnWidth: 480
	});

	$.each($("[data-block='answer']", grid), function(n, e){

		var props = {
			aid: $(e).attr("data-answer-id"),
			qid: $(e).attr("data-question-id"),
			bid: $(e).attr("data-block-id"),
			qtype: $(e).attr("data-question-type"),
			anum: $(e).attr("data-answer-num")
		},
			element = $(e),
			qblock = $("[data-question-id='" + props.qid + "']");

		$(element).click(function(){

			if( $(".checkbox", element).hasClass("disable") )
				return;

			if(props.qtype == 1){
				if($(".checkbox", element).hasClass("active")) {
					if($("textarea", element).length > 0)
						return;

					$(".checkbox", element).removeClass("active");
					return;
				}

				$("textarea", qblock).not($("textarea", element)).val("");

				$(".checkbox", qblock).removeClass("active");
				$(".checkbox", element).addClass("active");
			}

			if(props.qtype == 2){
				if($(".checkbox", element).hasClass("active")) {
					$(".checkbox", element).removeClass("active");
					$("textarea", element).removeClass("active");
				} else {
					$(".checkbox", element).addClass("active");
					$("textarea", element).addClass("active");
				}

				if( $(".checkbox.active", qblock).length == props.anum ) {
					$(".checkbox:not(.active)", qblock).addClass("disable");

					if($("textarea:not(.active)", qblock).length > 0)
						$("textarea:not(.active)", qblock)
							.css({
								opacity: ".3"
							})
							.val("")
							.prop("disabled", true);
				} else {
					$(".checkbox:not(.active)", qblock).removeClass("disable");

					if($("textarea:not(.active)", qblock).length > 0)
						$("textarea:not(.active)", qblock)
							.removeProp("disabled")
							.css("opacity", "1");
				}
			}
		});
	});

	$("[data-action='send']", pinfo).click(function(){
		var data = {};
		var success = true;

		data.answers = [];

		$.each($("[data-block='question']", grid), function(n, e){
			if(
				(
					$(".checkbox.active", e).length == 0
					&& $("textarea[data-question-type='text']", e).length > 0
					&& $("textarea[data-question-type='text']", e).val() == ""
				)
				|| (
					$(".checkbox.active", e).length == 0
					&& $("textarea[data-question-type='text']", e).length == 0
				)
			) {
				notices.illuminate($(".marker", e));
				success = false;
			}
		});

		$.each($(".checkbox.active", grid), function(n, e){
			var block = $(e).parent("[data-block='answer']");

			if( block.attr("data-answer-type") != "text" )
				data.answers.push({
					aid: block.attr("data-answer-id")
				});
			else {
				if( $("textarea", block).val() == "" ) {
					notices.illuminate($("textarea", block));
					success = false;
				}
				else
					data.answers.push({
						aid: block.attr("data-answer-id"),
						val: $("textarea", block).val()
					});
			}
		});

		data.fields = {};
		$.each($("[data-field-id]"), function(n, e){
			if( $(e).val() == "" ){
				notices.illuminate($(e));
				success = false;
			}
			else
				data.fields[$(e).attr("data-field-id")] = $(e).val();
		});

		if( ! success){
			notices.show("error", "Помилка", "Ви відповіли не на всі питання");
			return;
		}

		data.fid = grid.attr("data-form-id");

		$.post("/inquirers/admin/save_result", {
			data: data
		}, function(res){
			if( ! res.success ){
				notices.show("error", "Помилка", "При збереженні анкети виникла помилка. Будь ласка, зверніться до адміністрації сайту за допомогою.");
				return;
			}

			$.each($("[data-field-id]"), function(n, e){
				$(e).val("");
			});

			$("textarea", grid).val("");

			$(".checkbox.active", grid).removeClass("active");

			notices.show("success", "Вітаємо", "Анкета успішно відправлена !");
		}, "json");
	});

});