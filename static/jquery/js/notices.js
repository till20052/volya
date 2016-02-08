/*!
 * Notices v0.0.1
 * Notifications library
 * VOLYA License
 * by Aleschenko Rostilav
 */

(function( $ ){

	$.notices = (function(){

		console.log( $(".checkbox") );

		return "test";
	});

	$.fn.notices = (function(options){

		var icons = {
			success: "fa fa-check-circle",
			warning: "fa fa-exclamation-triangle",
			error: "fa fa-times-circle",
			info: "fa fa-info-circle"
		},
			box = this;

		return {
			show: function(type, title, message, e){
				var element = $("<div />");

				if(typeof e != "undefined"){
					var border = $(e).css("border");

					e.css({
						border: "1px solid red"
					});

					if(options.autoHide)
						setTimeout(function(){
							e.css("border", border);
						}, options.delay + (options.duration * 2));
				}

				element
					.prepend('<i class="' + icons[type] + '"></i>')
					.attr("data-notice-type", type)
					.append(
						$("<p />")
							.text(title + " : ")
							.append(
								$("<span />").text(message)
							)
					)
					.append(
						$("<div />").addClass("cboth")
					);

				box.prepend(element);

				element.show();
				element.animate({
					"opacity": "1"
				}, options.duration, function(){
					if(options.autoHide)
						setTimeout(function(){
							element.animate({
								"opacity": "0"
							}, options.duration, function(){
								element.hide();
							});
						}, options.delay);
				});
			},
			illuminate: function(e, optionsLocal){
				var border = $(e).css("border");

				if(typeof optionsLocal == "undefined")
					optionsLocal = options;

				e.css({
					border:
					(optionsLocal.borderWidth ? optionsLocal.borderWidth : "1px")
					+ " solid "
					+ (optionsLocal.borderColor ? optionsLocal.borderColor : "red")

				});

				if(optionsLocal.autoHide)
					setTimeout(function(){
						e.css("border", border);
					}, optionsLocal.delay);
			}
		}
	});

})( jQuery );