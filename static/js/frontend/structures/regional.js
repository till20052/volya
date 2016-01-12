$(document).ready(function(){
	var raphael = Raphael('map', 960, 670),
		attributes = {
			'stroke-width': 0.5,
			'stroke-linejoin': 'round',
			transform:"translate(623.5801, 201.2119)",
			transform:"matrix(1.25,0,0, -1.25,0,950)"
		},
		arr = new Array();

	$.getJSON("/js/frontend/structures/paths.json", function(regions){

		$.each(regions, function(id, region){
			var obj = raphael.path(region.path);
			var color = {};

			obj.attr(attributes);

			if( region.status == 1 ) {
				obj.attr({
					fill: '#0181C5',
					stroke: '#FFE515',
				});

				color.fill = '#0181C5';
				color.stroke = '#FFE515';
			}

			if( region.status == 0 ) {
				obj.attr({
					fill: 'rgb(209, 210, 212)',
					stroke: '#fff',
				});

				color.fill = 'rgb(209, 210, 212)';
				color.stroke = '#fff';
			}

			if( region.status == -1 ) {
				obj.attr({
					fill: 'rgba(255, 31, 31)',
					stroke: '#fff',
				});

				color.fill = 'rgba(255, 31, 31)';
				color.stroke = '#fff';
			}

			obj.name = region.name;

			obj
				.hover(function(){
					this.animate({
						fill: '#FFE515'
					}, 300);

					console.log( this.name );
				}, function(){
					this.animate({
						fill: color.fill
					}, 300);
				})
				.click(function(){
					alert(this.id);
				});
		});

	});
});