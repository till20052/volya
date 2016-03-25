/**
* quickBox 1.0 / Nazar Tokar / Ukraine
* www.dedushka.org / www.qbx.me
* Copyright 2012-2014
**/

function quickBox() {
	var data = {
		"folder": 			"/jquery/js/qb", // folder
		"template": 		"tpl.html" // template name
	}

	var body = document.getElementsByTagName("body")[0], bg, qb, insider, imgArea, txtArea, imgs=[];

	attachCSS();
	loadTemplate(data["folder"]+"/"+data["template"]);

	function changeImg (e) {
		var img = $(imgArea).find("img").attr("src"), ind, nextImg;
		for (var i=0; i<imgs.length; i++) {
			 if (imgs[i]["href"] == img) {
			 	ind = i;
			 }
		}
		if (e == "back") { // nav back
			nextImg = ind == 0 ? imgs.length-1 : ind-1;
		} else { // forward
			nextImg = ind == imgs.length-1 ? 0 : ind+1;
		}
		showIMG (imgs[nextImg]);
	}
	
	$("a.quickbox").each(function() { // save all imgs to array
		var item = {
			"href": 	getURL($(this).attr("href")),
			"title": $(this).attr("title")
		}
		imgs.push(item);
	});

	function showIMG (e) {
		qbToggle("show");
		var url = e["href"];
		var ttl = e["title"];

		var img = new Image();
		img.src = url;
		
		$(img).load(function(){
			var params = {
				"url": img.src,
				"width": img.width,
				"height": img.height,
				"title": ttl
			}
			qbResize(params);
		});
	}

	function qbResize (params) {
		var 
			navLeft = $(qb).find(".qb-navigate.qb-left"), // left
			navRight = $(qb).find(".qb-navigate.qb-right"), // right
			navClose = $(qb).find(".qb-close"), // close
			ww = $(window).width(), 
			wh = $(window).height(),
			dh = 1200//$(document).height();

			$(bg).width(ww).height(dh);

		if ( ! params) { // first run, before image loaded
		var 
			ileft = (ww - $(insider).width())/2,
			itop = (wh - $(insider).height())/2 + $(window).scrollTop();

			$(insider).css({"left": ileft});
			$(insider).css({"top": itop});
		} else {
			$(navClose).fadeOut("fast");
			$(navLeft).fadeOut("fast");
			$(navRight).fadeOut("fast");
		var 
			itop = (wh - params["height"])/2 + $(window).scrollTop();
			$(imgArea).css({
				width: params["width"], 
				height: params["height"]
			});
			$(insider).animate({
				"left": ($(window).width() - params["width"])/2,
				"top": itop,
				"width": params["width"], 
				"height": params["height"]+$(txtArea).outerHeight(true)
			}, 300);
			$(imgArea).fadeOut("fast", function(){
				$(imgArea).html('<img src="'+params["url"]+'" alt="'+params["title"]+'">');
				$(imgArea).fadeIn("fast");
			});
			$(txtArea).html(params["title"] ? params["title"] : " ");

			$(navClose).css({
				"top": itop,
				"right": (ww-params["width"])/2 - $(navClose).outerWidth(true)*2
			});
			$(navClose).fadeIn("fast");

			if (imgs.length > 1) { // show navigate controls?
				var navWidth = (ww - params["width"])/2;
				if (navWidth > 20) { // if it's enough place
					$(navLeft).css({ 
						"top": itop+params["height"]/2,
						"left": (ww-params["width"])/2 - $(navLeft).width()*2
					});
					$(navRight).css({ 
						"top": itop+params["height"]/2,
						"right": (ww-params["width"])/2 - $(navRight).width()*2
					});
					$(navLeft).fadeIn("fast");
					$(navRight).fadeIn("fast");
				}
			} // show buttons end
		}
	}

	function qbToggle (e) { // show/hide
		if (e == "hide") {
			$(qb).fadeOut("fast"); 
			$(imgArea).html("");
		} else {
			$(imgArea).html("");
			qbResize();
			$(qb).fadeIn("fast");
		}
	}

	function attachCSS() { // attach css
		var link = document.createElement("link");
		var head = document.getElementsByTagName("head")[0];
		link.rel  = "stylesheet";
		link.type = "text/css";
		link.href = data["folder"]+"/qb.css";
		link.media = "all";
		head.appendChild(link);
	}

	function loadTemplate(url) { // load html template
		$.get(url, function (e) {
			var keys = Object.keys(data);
			for (var i=0; i<keys.length; i++) {
				e = replaceData(e, keys[i], data[keys[i]]);
			}

			$("body").append(e);
			qb = $("div.quickbox");
			bg = $(qb).find(".qb-bg");
			imgArea = $(qb).find(".qb-img");
			txtArea = $(qb).find(".qb-txt");
			insider = $(qb).find(".qb-inside");
			qbResize();
		});
	}

	$(window).resize(function() {
		qbResize();
	});

	function replaceData (d, key, str) {  // replace template
		if (d && key && str) {
			d = d.replace((new RegExp("{{:"+key+"}}", "gi")), str);
			return d;
		} else { return ""; }
	}

	$(document).delegate("a.quickbox", "click", function() { // show img
		if (!$(this).attr("href")) { return; }
		var e = {
			"href": $(this).attr("href"),
			"title": $(this).attr("title") ? $(this).attr("title") : $(this).attr("alt")
		}
		showIMG(e);
		return false;
	});

	$(document).keydown(function(e) { // navigate
		if ($(qb).is(":visible")){
			if (e.keyCode == 37) { //left
				changeImg("back");
			}
		if (e.keyCode == 39) { //right
				changeImg("forward");
			}
		if (e.keyCode == 27) { //esc
				qbToggle("hide");
			}
		}
	});

	function getURL (url) {
		var img = document.createElement("img");
		img.src = url; 
		url = img.src; 
		//img.src = null; 
		return url;
	}

	$(document).delegate("div.quickbox .qb-bg, div.quickbox .qb-close", "click", function(e) { // show qb form
		qbToggle("hide");
	});

	$(document).delegate("div.quickbox .qb-left", "click", function() { // navigate
		changeImg("back");
	});

	$(document).delegate("div.quickbox .qb-right", "click", function() { // navigate
		changeImg("forward");
	});

	$(document).delegate("div.quickbox .qb-img img", "click", function() { // navigate
		changeImg("forward");
	});
}

window.onload = quickBox();