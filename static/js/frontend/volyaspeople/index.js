$(document).ready(function(){
	
	var __section = $("body>section"),
		__headerUiBox = $(">div.header", __section),
		__sectionUiBox = $(">div.section", __section);
	
	var __formUiWIndow = (function(element){
		var __uiWindow = (new Window(element)).beforeOpen(function(){
			__avatarUiElement.clear();
		});
		
		var __avatarUiElement = (function(element){
			var __i = $(">i", element).clone(),
				__cover = $(">div.avatar", element).css({
				opacity: 0
			}).hover(function(){
				$(this).animate({
					opacity: 1
				}, 100);
			}, function(){
				$(this).animate({
					opacity: 0
				}, 100);
			});
			
			$(">input", __cover).css({
				opacity: 0
			}).fileupload({
				dataType: "json",
				url: "/s/storage/j_save?extension[]=jpg&extension[]=png",
				sequentialUploads: true,
				done: (function(event, data){
					if( ! data.result.files[0]){
						alert("Файл, який ви завантажуєте, не підтримується");
						return;
					}
					
					$(">i", element).remove();
					
					$(element).attr({
						"data-hash": data.result.files[0]
					}).css({
						backgroundImage: "url('/s/img/thumb/ag/"+data.result.files[0]+"')"
					});
				})
			});
			
			var __clear = (function(){
				if( ! ($(">i", element).length > 0))
					$(element).append(__i);
				
				$(element).attr({
					"data-hash": ""
				}).css({
					backgroundImage: ""
				});
			});
			
			return ({
				getHash: (function(){
					return (typeof $(element).attr("data-hash") != undefined ? $(element).attr("data-hash") : "");
				}),
				clear: __clear
			});
		}($("div[data-ui='avatar']", __uiWindow.element)));
		
		$("a[data-action='upload_video']", __uiWindow.element).click(function(){
			__videoUploaderUiWindow.open();
		});
		
		$("a[data-action='submit']", __uiWindow.element).click(function(){
			$.post("/volyaspeople/index/j_add_volya_man", {
				symlink_avatar: __avatarUiElement.getHash(),
				name: $("input#name", __uiWindow.element).val(),
				description: $("textarea#description", __uiWindow.element).val()
			}, function(response){
				if( ! response.success)
					return;
				
			}, "json");
			__uiWindow.close();
		});
		
		return __uiWindow;
	}($("div[ui-window='volyaspeople.form']")));
	
	var __videoUploaderUiWindow = (function(element){
		var __uiWindow = new Window(element);
		
		$("input#link", __uiWindow.element).bind("keyup", function(){
			var __p = $(this).val(),
				__v = "";
			__p = __p.substr(__p.indexOf("?") + 1);
			__p.split("&").forEach(function(item){
				var __t = item.split("=");
				if(__t[0] != "v")
					return;
				__v = __t[1];
			});
			if(__v == "")
				return;
			__previewUiElement.showLoading();
			$.get("http://gdata.youtube.com/feeds/api/videos/"+__v, {
				alt: "json"
			}, function(response){
				var __preview = response.entry["media$group"]["media$thumbnail"][0];
				__previewUiElement.showImage(__preview.url, __preview.height);
			}, "json");
		});
		
		var __previewUiElement = (function(element){
			var __imageBox = $(">div.preview", element).clone();
			
			var __fn = new Object();
			
			__fn["showLoading"] = (function(){
				$(element).show();
				$(">div.preview", element).remove();
				$(element).append(__imageBox);
			});
			
			__fn["showImage"] = (function(link, height){
				$(">div.preview", element).css({
					backgroundImage: "url('"+link+"')",
					backgroundSize: "cover",
					height: height + "px"
				});
			});
			
			__fn["hide"] = (function(){
				$(element).hide();
			});
			
			return __fn;
		}($("div[data-uiBox='preview']", __uiWindow.element)));
		
		return __uiWindow;
	}($("div[ui-window='volyaspeople.video_uploader']")));
	
	$("a[data-action='add_volya_man']", __headerUiBox).click(function(){
		__formUiWIndow.open();
	});
	
});