$(document).ready(function(){
	
	var __teamUiBox = $("div[ui-box='team']");
	
	var __i18n = new i18n({
		languages: $.map($("input[ui-lang]", __teamUiBox), function(item){return $(item).attr("ui-lang")}),
		fields: ["title", "text"]
	});
	
	$("input[ui-lang]", __teamUiBox).click(function(){
		var __lang = $(this).attr("ui-lang");

		$("input[ui='title']", __teamUiBox).val(__i18n.value("title."+__lang));
		__textUiTextarea.setData(__i18n.value("text."+__lang));
	});

	$("input[ui='title']", __teamUiBox).change(function(){
		var __lang = $("input[ui-lang]:checked", __teamUiBox).attr("ui-lang");
		
		__i18n.value("title."+__lang, $(this).val());
	});

	$("input[ui='translit_link']", __teamUiBox).click(function(){
		$("input[ui='title']", __teamUiBox).translit("send", $("input#symlink", __teamUiBox));
	});

	var __textUiTextarea = $("textarea[ui='text']", __teamUiBox).ckeditor({
		height: "400px",
		filebrowserBrowseUrl : "/ckfinder/ckfinder.html"
	}).editor;
	__textUiTextarea.on("change", function(e){
		var __lang = $("input[ui-lang]:checked", __teamUiBox).attr("ui-lang");
		__i18n.value("text."+__lang, e.editor.getData());
	});
	
	
	$("input#submit", __teamUiBox).click(function(){
		$("div[ui-message]", __teamUiBox).hide();
		
		$.post("/admin/pages/j_save",{
			id:$(__teamUiBox).attr("data-id"),
			title:__i18n.value("title"),
			text:__i18n.value("text"),
			symlink : "team"
		}, function(response){
			if( response.success)
				$("div[ui-message='success']", __teamUiBox).slideDown();
			else
				$("div[ui-message='error']", __teamUiBox).slideDown();
		}, "json");
	});
	
	$.post("/admin/team/j_get_team_page", function(response){
		if( ! response.success)
			return;
		
		$(__teamUiBox).attr("data-id", response.item.id);
		
		__i18n.value("title", response.item.title);
		$("span#symlink", __teamUiBox).text(response.item.symlink);
		__i18n.value("text", response.item.text);
		
		$("input#is_public", __teamUiBox).attr("checked", response.item.is_public != 0 ? true : false);
		
		$($("input[ui-lang]", __teamUiBox)[0]).click();
	}, "json");
});