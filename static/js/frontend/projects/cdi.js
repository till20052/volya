$(document).ready(function(){

	var __section = $('body>section');
	var __windows = $('body>div[ui-box="windows"]');

	(function(){
		var __googleFormUiWindow = (function(ui){
			return new Window(ui);
		})($('>div[ui-window="projects.cdi.google_form"]', __windows));

		$("a[data-action='open_form']", __section).click(function(){
			__googleFormUiWindow.open();
		});
	})();

});