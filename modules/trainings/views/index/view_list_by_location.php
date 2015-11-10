<div class="header">
	<div>
		<div><?=t("Трeнінги")?></div>
	</div>
</div>

<div>
	<div>
		
		<div class="tabbar">
			<ul>
				<li<? if(strpos(Uri::getUrn(), "/trainings/1505578/314/314") !== false){ ?> class="selected"<? } ?>>
					<a href="/trainings/1505578/314/314"><?=t("Київ")?></a>
				</li>
				<li<? if(
						strpos(Uri::getUrn(), "/trainings") !== false
						&& strpos(Uri::getUrn(), "/trainings/1505578/314/314") === false
					){ ?> class="selected"<? } ?>>
					<a href="/trainings"><?=t("Регіони")?></a>
				</li>
			</ul>
		</div>
		
	</div>
</div>

<div class="section mt15">
	<div>
		
		<? if(count($trainings->list) > 0){ ?>
			<table class="list">
				<tbody>

					<? $__counter = 0; ?>
					<? $__rowsCounter = 0; ?>
					<? $__columnsCount = 4; ?>

					<? foreach($trainings->list as $__item){ ?>

						<? if($__counter == 0){ ?>
							<tr>
						<? } ?>

						<? $__symlink = "/trainings/".implode("/", array($__item["region_id"], $__item["area_id"], $__item["city_id"]))."/".$__item["id"] ?>

						<td>
							<div>

								<div>
									<div class="preview"<? if($__item["image"] != ""){ ?> style="background-image:url('/s/img/thumb/ah/<?=$__item["image"]?>')"<? } ?>></div>
								</div>

								<div>
									<a href="<?=$__symlink?>" class="fs16"><?=$__item["title"][Router::getLang()]?></a>
								</div>
								
								<div>
									<span><?=OldGeoClass::i()->getRegionById($__item["region_id"])["title"]?> / <?=OldGeoClass::i()->getCityById($__item["city_id"])["title"]?></span>
								</div>
								
								<div>
									<span><?=$application->intlDateFormatter->format(strtotime($__item["happen_at"]))?></span>
								</div>

							</div>
						</td>

						<? if($__counter < $__columnsCount - 1){ ?>
							<td>&nbsp;</td>
						<? } ?>

						<? if($__counter == $__columnsCount - 1){ ?>
							</tr>
							<? $__rowsCounter++ ?>
							<? $__counter = 0; ?>
						<? } else { ?>
							<? $__counter++ ?>
						<? } ?>

					<? } ?>

					<? if($__counter != 0 && $__counter != $__columnsCount){ ?>
						<? for($i = $__counter; $i < $__columnsCount; $i++){ ?>
							<td>&nbsp;</td>
							<? if($i < $__columnsCount - 1){ ?>
								<td>&nbsp;</td>
							<? } ?>
						<? } ?>
						</tr>
					<? } ?>

				</tbody>
			</table>
		<? } else { ?>
			<div data-uiBox="empty_list"><?=t("Ще немає тренінгів")?></div>
		<? } ?>
		
	</div>
</div>