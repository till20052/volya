var gallery = {
	window: $("<div />").addClass("qalery-window"),
	prev: $("<div />").addClass("prev-img").append('<i class="icon-chevron-left"></i>'),
	img: $("<img />").addClass("gallery-img"),
	props: {
		height: "600px"
	},
	init: function(){
		$(this.window).css(this.props);
		$("body")
			.append(
				$("<div />")
					.addClass("gallery-body")
					.append(
						$(this.prev),
						$(this.window)
							.append(
								this.img
							)
					)
			);

		$("[data-type='galery']").each(function(n, e){
			$(e).click(function(){
				gallery.show($(e).attr("data-src"));
			});
		});

		$(".gallery-body").click(function(e){
			if(
				$(e.target).closest(".qalery-window").length
				|| $(e.target).closest(".prev-img").length
				|| $(e.target).closest(".next-img").length
			)
				return;

			gallery.hide();
		});
	},
	checkPosition: function(){
		var wh = $(window).height();
		var ww = $(window).width();

		// WINDOW
		var wtop = (wh - this.window.height()) / 2;

		//PREV BUTTON
		var ptop = (wh - this.prev.height()) / 2;
		var pleft = ((ww - gallery.window.width()) / 2)// - this.prev.width();

		console.log(gallery.img.width());

		gallery.window.css({
			top: wtop + "px"
		});

		gallery.prev.css({
			top: ptop + "px",
			left: pleft + "px"
		});
	},
	show: function(src){

		$(gallery.img)
			.attr("src", src)
			.load(function(){
				$(this)
					.css({
						height: (gallery.window.height()) + "px"
					});

				gallery.window.css({
					width: gallery.img.width() + "px"
				});
			});

		$(gallery.window).show();
		$(gallery.window).parent().show();

		gallery.checkPosition();
	},
	hide: function(){
		$(gallery.window).hide();
		$(gallery.window).parent().hide();
	},
};


$(document).ready(function(){

	gallery.init();

});