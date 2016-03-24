$(document).ready(function(){

	var __section = $('body>section');

	(function(ui){
		var __step = 1;

		$('a[data-action="load_next_news"]', ui).click(function(){
			$.post('/load_next_news', {
				step: __step
			}, function(response){
				if( ! response.success)
					return;

				if(response.list.length < 9)
					$('>div', ui)[0].remove();

				response.list.forEach(function(item){
					var __li = $('<li />');

					$(__li).append($('<div data-ui="preview" />').css({
						backgroundImage: "url('http://volya.ua/s/img/thumb/200x/"+item.images[0]+"')"
					}));

					$(__li).append($('<div />').append(
						$('<a href="http://volya.ua/news/'+item.id+'" />').html(item.title.ua)
					));

					$(__li).append($('<div data-ui="datetime" />').html(item.created_at));

					__li.insertBefore($('>ul>li:last-child', ui));
				});

				__step++;
			}, 'json');
		});
	})($('div[data-ui-block="news"]>section', __section));

	(function(ui){
		var __videoViewerUiWindow = (function(ui){
			var __uiWindow = new Window(ui);
			$(__uiWindow.element).css({
				position: 'relative',
				background: 'rgba(0,0,0,0)'
			});
			return __uiWindow;
		})($($("div[ui-window='cells1.index.video_viewer']")));

		$('>ul>li', ui).click(function(){
			__videoViewerUiWindow.open();
			$(__videoViewerUiWindow.element).empty()
				.append($("<a href='javascript:void(0);' class='icon' />").css({
					position: 'absolute',
					right: '-10px',
					color: 'white'
				}).click(function(){
					__videoViewerUiWindow.close();
				}).append($('<i class="icon-remove" />')))
				.append($("<iframe />").attr({
					width: 853,
					height: 480,
					src: "https://www.youtube.com/embed/"+$(this).attr("data-vid"),
					frameborder: 0,
					allowfullscreen: true
				}));
		});
	})($('div[data-ui-block="video"]>section', __section));

});