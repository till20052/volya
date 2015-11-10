<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="keywords" content="<?=$application->keywords?>">
		<meta name="description" content="<?=$application->description?>">
		<title><?=$application->title?></title>
		
		<script src="/jquery/js/jquery.min.js"></script>
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<? foreach(HeadClass::getJs() as $src){ ?>
			<script src="<?=$src?>"></script>
		<? } ?>
		
		<link rel="stylesheet" href="/css/tools.css" />
		<link rel='stylesheet' href="/css/fonts.css" />
		
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
		
		<section>
			
			<div>
				<div>
					
					<div class="tacenter fs16" style="color: #666; padding-top: 100px">
						<h3>Прямо зараз ми готуємо до відкриття наш оновлений сайт.</h3>
						<h3>Чекаємо на вас за цією ж адресою 30 вересня.</h3>
						<h3>До зустрічі!</h3>
						<div>
							<img src="/img/landing_page/image.png" />
						</div>
					</div>
					
				</div>
			</div>
			
		</section>
		
	</body>
</html>