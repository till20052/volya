$(document).ready(function(){
	
	var __section = $("body>section>div.section");
	
	$("a#submit", __section).click(function(){
		$("form#privatbank", __section).submit();
	});
	
});