<!DOCTYPE html>
<html ng-app="VolyaApp">
	<head>
		<meta charset="utf-8" />
		
		<meta name="keywords" content="<?=$application->keywords?>">
		<meta name="description" content="<?=$application->description?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<? if($application->isVisibleSharingButtons){ ?>
			<meta property="og:title" content="<?=(isset($application->sharing["title"]) && $application->sharing["title"] != "" ? $application->sharing["title"] : $application->title)?>" />
			<? if(isset($application->sharing["image"]) && $application->sharing["image"] != ""){ ?>
				<meta property="og:image" content="<?=$application->sharing["image"]?>" />
			<? } ?>
			<meta property="og:description" content="<?=(isset($application->sharing["description"]) && $application->sharing["description"] != "" ? $application->sharing["description"] : $application->description)?>" />
			<meta property="og:url" content="http://<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>" />
			<meta property="og:type" content="website" />
		<? } ?>
		
		<title><?=$application->title?></title>
		
		<? if($application->isVisibleSharingButtons){ ?>
			<script src="https://apis.google.com/js/platform.js" async defer>
				{lang: 'uk'}
			</script>
			<script type="text/javascript" src="http://vk.com/js/api/share.js?90" charset="windows-1251"></script>
		<? } ?>
		
		<script src="/jquery/js/jquery.min.js"></script>
		<script src="/jquery/js/notices.js"></script>
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<? if($loadFileupload){ ?>
			<script src="/jquery/js/vendor/jquery.ui.widget.js"></script>
			<script src="/jquery/js/jquery-fileupload.js"></script>
		<? } ?>

		<? if($loadGallery){ ?>
			<script src="/js/gallery.js"></script>
		<? } ?>

		<? if($loadAngular){ ?>
			<script src="/angular/js/angular.min.js"></script>
			<script src="/angular/js/angular-animate.min.js"></script>
			<script src="/angular/js/angular-messages.min.js"></script>
			<script src="/angular/js/angular-aria.min.js"></script>
			<script src="/angular/js/angular-material.min.js"></script>

			<script src="/angular/js/app/app.js"></script>

			<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<? } ?>
		
		<? if($loadKendo){ ?>
			<script src="/kendo/js/kendo.all.min.js"></script>
			<script src="/kendo/js/cultures/kendo.culture.uk-UA.min.js"></script>
			<script>kendo.culture("uk-UA");</script>
		<? } ?>
		
		<? if($loadCKEditor){ ?>
			<script src="/ckeditor/ckeditor.js"></script>
			<script src="/ckeditor/adapters/jquery.js"></script>
		<? } ?>
		
		<? if(count($windows) > 0){ ?>
			<script src="/js/window.js"></script>
			<? foreach($windows as $window){ ?>
				<? if( ! file_exists(dirname(__FILE__)."/../static/js/frontend/windows/".$window.".js")){ continue; } ?>
				<script src="/js/frontend/windows/<?=$window?>.js"></script>
			<? } ?>
		<? } ?>
		
		<? foreach(HeadClass::getJs() as $src){ ?>
			<script src="<?=$src?>"></script>
		<? } ?>
		
		<link rel="stylesheet" href="/css/tools.css" />
		<link rel="stylesheet" href="/css/fonts.css" />
<!--		<link rel="stylesheet" href="/css/font-awesome.css">-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<? if($loadKendo){ ?>
			<link rel="stylesheet" href="/kendo/styles/kendo.common.min.css" />
			<link rel="stylesheet" href="/kendo/styles/kendo.volya.min.css" />
		<? } ?>

		<? if($loadAngular){ ?>
			<link rel="stylesheet" href="/angular/css/angular-material.min.css">
			<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css">
		<? } ?>
		
		<? if(count($windows) > 0){ ?>
			<link rel="stylesheet" href="/css/windows.css" />
		<? } ?>
		
		<? foreach(HeadClass::getCss() as $href){ ?>
			<link rel="stylesheet" type="text/css" href="<?=$href?>" />
		<? } ?>

		<? if($loadGallery){ ?>
			<link rel="stylesheet/less" type="text/css" href="/less/gallery.less" />
		<? } ?>

		<link rel="stylesheet/less" type="text/css" href="/less/notices.less" />

		<? if(($lesses = HeadClass::getLess()) && count($lesses) > 0){ ?>
			<? foreach($lesses as $href){ ?>
				<link rel="stylesheet/less" type="text/css" href="<?=$href?>" />
			<? } ?>
			<script src="/js/less.min.js"></script>
		<? } ?>
		
		<link rel="icon" href="/favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	</head>
	<body>
		
		<? if($application->isVisibleSharingButtons){ ?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&appId=195961530596800&version=v2.0";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		<? } ?>
		
		<? if(count($windows) > 0){ ?>
			<!-- START WINDOWS -->
			<? include "frontend/windows.php" ?>
			<!-- END WINDOWS -->
		<? } ?>
		
		<!-- START HEADER -->
		<? include "frontend/header.php" ?>
		<!-- END HEADER -->
		
		<!-- START SECTION -->
		<? include "frontend/section.php" ?>
		<!-- END SECTION -->
		
		<!-- START FOOTER -->
		<? include "frontend/footer.php" ?>
		<!-- END FOOTER -->

		<? if(Uri::getUrl() == "volya.ua"){ ?>
			
			<a href="https://plus.google.com/110829414389342809017" rel="publisher"></a>
			
			<!-- Google Analytics -->
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
				ga('create', 'UA-53414587-1', 'auto');
				ga('send', 'pageview');
			</script>
			<!-- Google Analytics -->

			<!-- Yandex.Metrika counter -->
			<script type="text/javascript">
			(function (d, w, c) {
				(w[c] = w[c] || []).push(function() {
					try {
						w.yaCounter25559234 = new Ya.Metrika({id:25559234,
								webvisor:true,
								clickmap:true,
								trackLinks:true,
								accurateTrackBounce:true});
					} catch(e) { }
				});

				var n = d.getElementsByTagName("script")[0],
					s = d.createElement("script"),
					f = function () { n.parentNode.insertBefore(s, n); };
				s.type = "text/javascript";
				s.async = true;
				s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

				if (w.opera == "[object Opera]") {
					d.addEventListener("DOMContentLoaded", f, false);
				} else { f(); }
			})(document, window, "yandex_metrika_callbacks");
			</script>
			<noscript><div><img src="//mc.yandex.ru/watch/25559234" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
			<!-- /Yandex.Metrika counter -->

		<? } ?>
		
		<script>$(document).ready(function(){$(window).resize();});</script>
		
	</body>
</html>