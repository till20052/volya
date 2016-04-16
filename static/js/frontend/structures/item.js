$(document).ready(function(){

	var __section = $("body>section"),
		__contentUiBox = $("[data-id='content']", __section);

	$("a[data-action='join']", __section).click(function(){

		$.post("/structures/join_structure", {
			sid: $(this).attr("data-id"),
			geo: $(this).attr("data-geo")
		}, function(res){
			if( ! res.success){
				alert(res.msg);
				$(this).remove();
				return false;
			}
		}, "json");

	});

	var __imagesUiView = (function(element){
		var __listUiBox = $(">div[data-uiBox='list']", element),
			__imageTemplate = kendo.template($(">script", __listUiBox).html()),
			__uploaderUiBox = $(">div[data-uiBox='uploader']", element);

		console.log( __listUiBox, "Test" );

		$(__listUiBox).click(function(e){
			var __element = $(e.srcElement);
			if(typeof $(__element).attr("data-action") == "undefined")
				__element = $($(__element).parents("*[data-action]").eq(0));

			switch($(__element).attr("data-action")){
				case "delete":
					$($(__element).parents("div").eq(0)).remove();
					__refreshWidth();
					break;
			}
		});

		$(">a>input", __uploaderUiBox).css({
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

				__addImage(data.result.files[0]);
			})
		});

		var __refreshWidth = (function(){
			var __width = 502;
			if(($(">div", __listUiBox).length - 1) > 6)
				__width = 667;
			$(__listUiBox).css("width", __width+"px");
		});

		var __addImage = (function(hash){
			$(__imageTemplate({
				hash: hash
			})).insertBefore($(">div:last-child", __listUiBox));
			__refreshWidth();
		});

		var __cleanUp = (function(){
			$(">div:not(:last-child)", __listUiBox).remove();
		});

		var __setImages = (function(data){
			data.forEach(function(hash){
				__addImage(hash);
			});
		});

		return ({
			addImage: __addImage,
			cleanUp: __cleanUp,
			setImages: __setImages,
			getImages: (function(){
				return $.map($(">div[data-hash]", __listUiBox), function(element){
					return $(element).attr("data-hash");
				});
			})
		});
	})($("div[data-uiView='images']"));

	$("a#testbutton", $("div[data-uiView='images']")).click(function () {
		console.log( __imagesUiView.getImages(), "TEST" );
	});

});