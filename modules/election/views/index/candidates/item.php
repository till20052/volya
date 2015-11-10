<div>
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" width="300px">
					<div>
						<div class="avatar avatar-8x" style="width: 300px; height: 300px;<? if($candidate["symlink_avatar"] != ""){ ?> background-image: url('/s/img/thumb/as/<?=$candidate["symlink_avatar"]?>');<? } ?> border: 5px solid #FFE511; box-sizing: border-box"></div>
					</div>
					<div class="mt30 tacenter">
						<a data-action="support" href="javascript:void(0);" class="v-button v-button-blue icon">
							<i class="icon-fblike"></i>
							<span><?=t("Підтримати кандидата")?></span>
						</a>
						<div class="icon" style="color: #009771">
							<i class="icon-ok"></i>
							<span><?=t("Дякуємо за підтримку")?></span>
						</div>
					</div>
				</td>
				
				<td valign="top" class='pl30'>
					
					<div class="fs30" style="color: #0181C5">
						<div><?=$candidate["first_name"]." <b>".$candidate["last_name"]."</b>"?></div>
					</div>
					
					<div class="fs18" style="color: #0181C5">
						<span><?=OldGeoClass::i()->getRegion($candidate["geo_koatuu_code"])["title"]?>, виборчий округ № <?=$candidate["county_number"]?></span>
					</div>
					
					<div class="mt5">
						<span style="color: #666666">Межі округу: <?=RoepDistrictsModel::i()->getCompiledListByField("number", "Одномандатний виборчий округ №".$candidate["county_number"], [
							"fields" => ["description"]
						])[0]["description"]?></span>
					</div>
					
					<div class="mt15" style="color: #333333">
						<div class="fs18"><?=t("Біографія")?>:</div>
						<div><?=$candidate["biography"]?></div>
					</div>
					
					<div class="mt15">
						<table cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									
									<? if(isset($candidate["contacts"]["facebook"]) && isset($candidate["contacts"]["facebook"][0])){ ?>
										<td class="pr30">
											<a href="<?=$candidate["contacts"]["facebook"][0]?>" target="_blank" class="icon">
												<i class="icon-facebook fs18"></i>
												<span><?=t("Фейсбук")?></span>
											</a>
										</td>
									<? } ?>
										
									<? if(isset($candidate["contacts"]["twitter"]) && isset($candidate["contacts"]["twitter"][0])){ ?>
										<td class="pr30">
											<a href="<?=$candidate["contacts"]["twitter"][0]?>" target="_blank" class="icon">
												<i class="icon-twitter fs18"></i>
												<span><?=t("Твітер")?></span>
											</a>
										</td>
									<? } ?>
									
									<? if(isset($candidate["contacts"]["website"]) && isset($candidate["contacts"]["website"][0])){ ?>
										<td class="pr30">
											<a href="<?=$candidate["contacts"]["website"][0]?>" target="_blank" class="icon">
												<i class="icon-websitealt fs18"></i>
												<span><?=t("Особистий сайт")?></span>
											</a>
										</td>
									<? } ?>
									
								</tr>
							</tbody>
						</table>
					</div>
					
					<div class="mt15">
						<!--<span style="color: #666666">Щоб долучитися до компанії, скачайте <a href="/election/agitation#<?=$candidate["id"]?>">агітаційні матеріали</a> кандидата<? if(isset($candidate["contacts"]["phone"]) && count($candidate["contacts"]["phone"]) > 0){ ?> або звертайтеся до штабу: <strong><?=implode(", ", $candidate["contacts"]["phone"])?><? if(isset($candidate["contacts"]["email"]) && isset($candidate["contacts"]["email"][0])){ ?>, <a href="mailto:<?=$candidate["contacts"]["email"][0]?>" style="color: #666666"><?=$candidate["contacts"]["email"][0]?></a><? } ?></strong><? } ?></span>-->
						<? if(isset($candidate["contacts"]["phone"]) && count($candidate["contacts"]["phone"]) > 0){ ?><span style="color: #666666">Щоб долучитися до кампанії звертайтеся до передвиборчого штабу кандидата: <strong style="white-space: nowrap"><?=implode(", ", $candidate["contacts"]["phone"])?><? if(isset($candidate["contacts"]["email"]) && isset($candidate["contacts"]["email"][0])){ ?>, <a href="mailto:<?=$candidate["contacts"]["email"][0]?>" style="color: #666666"><?=$candidate["contacts"]["email"][0]?></a><? } ?></strong></span><? } ?>
					</div>
					
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<hr class="mt30 mb30" />


<div class="mt30">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" width="50%" class="pr30">
					<div>
						<div style="margin-left: -30px">
							<div class="icon fs20">
								<i class="icon-quoteup"></i>
								<span class="mark"><?=t("Пряма мова")?></span>
							</div>
						</div>

						<div class="mt15">
							<span><?=$candidate["quote"]?></span>
						</div>
					</div>
				</td>
				
				<td valign="top" class="pl30">
					<div style="margin-left: -30px">
						<div class="icon fs20">
							<i class="icon-target"></i>
							<span class="mark"><?=t("Програма")?></span>
						</div>
						
						<div class="mt15">
							<span><?=$candidate["program"]?></span>
						</div>
					</div>
					
<!--					<div class="mt15">
						<div data-uiBox="program">
							<div data-uiBox="bigText">
								<div class="fright">
									<a data-action="close" href="javascript:void(0);" class="icon fs20">
										<i class="icon-remove"></i>
									</a>
								</div>
								<div style="margin-left: -30px">
									<div class="icon fs20">
										<i class="icon-target"></i>
										<span><?//=t("Програма")?></span>
									</div>
								</div>
								<div class="mt15"><?//=$candidate["program"]?></div>
							</div>
							<div data-uiBox="text"><?//=$candidate["program"]?></div>
							<div data-uiBox="cover"></div>
							<div class="mt15">
								<a data-action="show" href="javascript:void(0);"><?//=t("Показати повністю")?></a>
							</div>
						</div>
					</div>-->
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<? if(count($candidate["opponents"][1]) > 0){ ?>
	<div class="mt30">
		<div style="margin-left: -30px">
			<div class="icon fs20">
				<i class="icon-cannon"></i>
				<span class="mark"><?=t("Конкуренти на окрузі")?></span>
			</div>
		</div>

		<div data-uiCarousel="opponents" class="mt15">
			<div data-uiArrow="left"></div>
			<div data-uiBox="content">
				<table cellspacing="0" cellpadding="0">
					<tbody>
						<tr>

							<td class="gag"></td>

							<? foreach($candidate["opponents"][1] as $__opponent){ ?>
								<td>
									<div>
										<div class="avatar" style="background-image: url('/s/img/thumb/at/<?=$__opponent["symlink_avatar"]?>')"></div>
										<div class="fwbold"><?=$__opponent["name"]?></div>
										<div class="mt5 cgray fsitalic"><?=$__opponent["appointment"]?></div>
										<div class="mt5"><?=$__opponent["description"]?></div>
									</div>
								</td>
							<? } ?>

							<td class="gag"></td>

						</tr>
					</tbody>
				</table>
			</div>
			<div data-uiArrow="right"></div>
		</div>
	</div>
<? } ?>

<? if(count($candidate["opponents"][2]) > 0){ ?>
	<div class="mt30">
		<div style="margin-left: -30px">
			<div class="icon fs20">
				<i class="icon-cannon"></i>
				<span class="mark"><?=t("Чиновники, які будуть люстровані")?></span>
			</div>
		</div>

		<div data-uiCarousel="punished" class="mt15">
			<div data-uiArrow="left"></div>
			<div data-uiBox="content">
				<table cellspacing="0" cellpadding="0">
					<tbody>
						<tr>

							<td class="gag"></td>

							<? foreach($candidate["opponents"][2] as $__opponent){ ?>
								<td>
									<div>
										<div class="avatar" style="background-image: url('/s/img/thumb/at/<?=$__opponent["symlink_avatar"]?>')"></div>
										<div class="fwbold"><?=$__opponent["name"]?></div>
										<div class="mt5 cgray fsitalic"><?=$__opponent["appointment"]?></div>
										<div class="mt5"><?=$__opponent["description"]?></div>
									</div>
								</td>
							<? } ?>

							<td class="gag"></td>

						</tr>
					</tbody>
				</table>
			</div>
			<div data-uiArrow="right"></div>
		</div>
	</div>
<? } ?>

<? $__showSharing = true ?>
<? if(isset($candidate["news"]) && count($candidate["news"]) > 0){ ?>
	<? $__showSharing = false ?>
	<div class="mt30">
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					
					<td valign="top" class="pr30">
						<div style="margin-left: -30px">
							<div class="icon fs20">
								<i class="icon-news"></i>
								<span class="mark"><?=t("Новини кандидата")?></span>
							</div>
						</div>
						
						<div class="mt15">
							<table width="100%" cellspacing="0" cellpadding="0">
								<tbody>

									<? $application->intlDateFormatter->setPattern("d MMMM") ?>

									<? foreach($candidate["news"] as $__i => $__item){ ?>
										<tr>
											<td valign="top" style="width: 150px">
												<div data-href="/news/<?=$__item["id"]?>" class="preview s150x120"<? if(count($__item["images"]) > 0){ ?> style="height: 150px; background-image: url('/s/img/thumb/150x100/<?=$__item["images"][0]?>')"<? } ?>></div>
											</td>
											<td valign="top" class="pl25">
												<div style="color: #666"><?=$application->intlDateFormatter->format(strtotime($__item["created_at"]))?></div>
												<div class="mt10">
													<a href="/news/<?=$__item["id"]?>" class="fs16"><?=$__item["title"]?></a>
												</div>
												<div class="mt10" style="color: #333">
													<span><?=$__item["announcement"]?></span>
												</div>
											</td>
										</tr>

										<? if(count($candidate["news"]) > $__i + 1){ ?>
											<tr>
												<td colspan="2" style="height: 30px">&nbsp;</td>
											</tr>
										<? } ?>
									<? } ?>

								</tbody>
							</table>
						</div>
					</td>
					
					<td valign="top" width="300px">
						<div style="margin-left: -30px">
							<div class="icon fs20">
								<i class="icon-share"></i>
								<span class="mark" style="text-align: left">Розкажіть друзям про кандидата</span>
							</div>
						</div>
						
						<div class="mt10">
							<table cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<td class="pt10" style="line-height: 0">
											<div class="fb-share-button" data-href="http://<?=Uri::getUrl()?><?=Uri::getUrn()?>">Поділитися</div>
										</td>
									</tr>
									<tr>
										<td class="pt10" style="line-height: 0">
											<div class="g-plus" data-action="share" data-annotation="bubble"></div>
										</td>
									</tr>
									<tr>
										<td class="pt10" style="line-height: 0">
											<div data-ui="vk_sharing"></div>
											<script type="text/javascript">
												$(document).ready(function(){
													$("body>section div[data-ui='vk_sharing']")
															.html(VK.Share.button({url: "http://<?=Uri::getUrl()?><?=Uri::getUrn()?>"},{type: "round", text: "Поділитися"}));
												});
											</script>
										</td>
									</tr>
									<tr>
										<td class="pt10" style="line-height: 0">
											<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://<?=Uri::getUrl()?><?=Uri::getUrn()?>" data-lang="ru">Поділитися</a>
											<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</td>
					
				</tr>
			</tbody>
		</table>
	</div>
<? } ?>

<? if($__showSharing){ ?>
	<div class="mt30">
		<div style="margin-left: -30px">
			<div class="icon fs20">
				<i class="icon-share"></i>
				<span class="mark">Розкажіть друзям про кандидата</span>
			</div>
		</div>

		<div class="mt15">
			<table cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td class="pl10" style="line-height: 0">
							<div class="fb-share-button" data-href="http://<?=Uri::getUrl()?><?=Uri::getUrn()?>">Поділитися</div>
						</td>
						<td class="pl10" style="line-height: 0">
							<div class="g-plus" data-action="share" data-annotation="bubble"></div>
						</td>
						<td class="pl10" style="line-height: 0">
							<div data-ui="vk_sharing"></div>
							<script type="text/javascript">
								$(document).ready(function(){
									$("body>section div[data-ui='vk_sharing']")
											.html(VK.Share.button({url: "http://<?=Uri::getUrl()?><?=Uri::getUrn()?>"},{type: "round", text: "Поділитися"}));
								});
							</script>
						</td>
						<td class="pl10" style="line-height: 0">
							<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://<?=Uri::getUrl()?><?=Uri::getUrn()?>" data-lang="ru">Поділитися</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
<? } ?>