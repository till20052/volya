<div class="header">
	<div>
		<span><?=$trainings->item["title"][Router::getLang()]?></span>
	</div>
</div>

<div class="dashboard">
	<div>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					
					<td class="pr30" style="width: 150px">
						<div class="preview" style="height: 100px; background-image:url('/s/img/thumb/ah/<?=$trainings->item["image"]?>')"></div>
					</td>
					
					<td class="fwbold">
						<div><?=OldGeoClass::i()->getRegionById($trainings->item["region_id"])["title"]?> / <?=OldGeoClass::i()->getCityById($trainings->item["city_id"])["title"]?></div>
						<div><?=$trainings->item["address"]?></div>
						
						<div class="mt15"><?=t("Дата проведення")?>: <?=$application->intlDateFormatter->format(strtotime($trainings->item["happen_at"]))?></div>
						
						<? $__count = TrainingClass::i()->countTrainingMembers($trainings->item["id"]); ?>
						<? if($__count > 0){ ?>
							<div class="mt15"><?=t("Кількість учасників")?>: <span data-uiLabel="count_training_members"><?=$__count?></span></div>
						<? } ?>
					</td>
					
					<td class="taright">
						<? if(UserClass::i()->isAuthorized()){ ?>
							<? if( ! TrainingClass::i()->isTrainingMember($trainings->item["id"], UserClass::i()->getId())){ ?>
								<input type="button" id="join" value="<?=t("Зареєструватися")?>" data-trainingId="<?=$trainings->item["id"]?>" class="button blue x2" />
							<? } else { ?>
								<div data-uiBox="already_registred"><?=t("Ви вже зареєстровані")?></div>
							<? } ?>
						<? } ?>
					</td>
					
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="section">
	<div>
		<span><?=$trainings->item["text"][Router::getLang()]?></span>
	</div>
</div>