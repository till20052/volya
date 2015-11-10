<div class="breadcrumbs">
	
	<div>
		
		<? $__counter = 0 ?>
		
		<? foreach($application->breadcrumbs as $__breadcrumb){ ?>
			
			<? if(count($application->breadcrumbs) - 1 != $__counter){ ?>
				
				<a href="<?=$__breadcrumb["href"]?>"><?=$__breadcrumb["text"]?></a> <span>/</span>
			
			<? } else { ?>
				
				<span><?=$__breadcrumb["text"]?></span>
				
			<? } ?>
			
			<? $__counter++ ?>
			
		<? } ?>
		
	</div>
	
</div>

<div class="header">
	
	<div>
		
		<h1 class="ttuppercase"><?=$indexNewsController->item["title"][Router::getLang()]?></h1>
		
	</div>
	
</div>

<div class="attributes">
	
	<div>
		
		<table>
			<tbody>
				
				<tr>
					
					<td>
						<div>
							<i class="icon-time"></i>
							<span><?=$application->intlDateFormatter->format(strtotime($indexNewsController->item["created_at"]))?></span>
						</div>
					</td>
					
					<td>
						<div>
							<i class="icon-eye-view"></i>
							<span><?=t("Переглядів")?>: <?=$indexNewsController->item["views_count"]?></span>
						</div>
					</td>
					
					<? if($indexNewsController->item["allow_comments"] == 1){ ?>
						<td>
							<div>
								<i class="icon-comment"></i>
								<span><?=t("Коментарів")?>: <?=$indexNewsController->item["comments_count"]?></span>
							</div>
						</td>
					<? } ?>
					
				</tr>
				
			</tbody>
		</table>
		
	</div>
	
</div>

<div>
	
	<div>
		<div>
			<?=$indexNewsController->item["text"][Router::getLang()]?>
		</div>
		<div class="cboth"></div>
	</div>
	
</div>

<? if($indexNewsController->item["allow_sharing"]){ ?>
	<? $__url = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>
	<!-- START SHARING -->
	<div ui-box="sharing" style="background-color: #F0EEE8">
		<div class="dtable">

			<div class="dtable-cell pl30">
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1&appId=195961530596800";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<div class="fb-share-button" data-href="<?=$__url?>" data-type="button_count"></div>
			</div>

			<div class="dtable-cell pl10">
				<script type="text/javascript"><!--
				document.write(VK.Share.button({url: "<?=$__url?>"},{type: "button", text: "Поділитися"}));
				--></script>
			</div>
			
			<div class="dtable-cell pl10">
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?=$__url?>" data-lang="uk">Твіт</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</div>
			
			<div class="dtable-cell pl10">
				<div class="g-plus" data-action="share" data-href="<?=$__url?>"></div>
				<script type="text/javascript">
				  window.___gcfg = {lang: 'uk'};

				  (function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/platform.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  })();
				</script>
			</div>

		</div>
	</div>
	<!-- END SHARING -->
<? } ?>

<div style="margin-top: 50px">
	<div>
		<? if($indexNewsController->item["allow_comments"] == 1){ ?>
			<div class="dtable" style="width: 100%">

				<div class="dtable-cell pr30" style="width: 650px">
					<? include "view_item/comments.php"; ?>
				</div>

				<div class="dtable-cell">&nbsp;</div>

			</div>
		<? } ?>
	</div>
</div>