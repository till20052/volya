<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?=$application->title?></title>
		
		<script src="/jquery/js/jquery.min.js"></script>
		
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
		
		<div style="height: 127px;"></div>
		
		<section>
			<? include $view ?>
		</section>
		
	</body>
</html>