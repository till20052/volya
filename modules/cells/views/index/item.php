<div class="header">
	<div>
		
		<div><?=t("Сторінка осередку")?></div>
		
	</div>
</div>

<div class="dashboard">
	<div>
		
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					
					<td style="width: 160px">
						<div id="avatar" class="avatar avatar-4x">
							<span>№ <?=RoepPlotsModel::i()->getItem($cell["roep_plot_id"])["number"]?></span>
						</div>
					</td>
					
					<td>
						<div class="fs25 fwbold">
							<div><?=OGeoClass::i()->getCityById($cell["city_id"])["title"]?></div>
						</div>
						<div class="fwbold">
							<div><?=$cell["address"]?></div>
							<div><?=OGeoClass::i()->getRegionById($cell["region_id"])["title"]?></div>
							<div><?=t("Дата створення")?>: <?=date("d.m.Y", strtotime($cell["created_at"]))?></div>
							<div class="dnone">
								<div class="fleft mr5"><?=t("Контакти")?>:</div>
								<div class="fleft">
									<div>
										<a href="mailto:info@volya.ua">info@volya.ua</a>
									</div>
								</div>
								<div class="cboth"></div>
							</div>
						</div>
						<div>
							<? if(1 != 1){ ?>
								<div class="fleft mr5">
									<input type="button" value="<?=t("Створити осередок")?>" class="button" />
								</div>
								<div class="fleft">
									<input type="button" value="<?=t("Приєднатися до осередку")?>" class="button" />
								</div>
								<div class="cboth"></div>
							<? } ?>
						</div>
					</td>
					
					<td class="taright">
						
						<div>
							<input type="button" value="<?=t("Редагувати осередок")?>" class="button x2" onclick="window.location.href='/profile/edit<? if(UserClass::i()->hasCredential(777) && UserClass::i()->getId() != $profile["id"]){ ?>/<?=$profile["id"]?><? } ?>'" />
						</div>
						
					</td>
					
				</tr>
			</tbody>
		</table>
		
	</div>
</div>

<div>
	<div>
		
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				
				<tr>
					
					<td valign="top" data-uiBox="content" class="pt15">
						
						<div data-uiTabbar="main">
							<ul>
								<li>
									<a href="javascript:void(0);" data-boxId="documents"><?=t("Документи")?></a>
								</li>
								<li>
									<a href="javascript:void(0);" data-boxId="news"><?=t("Новини")?></a>
								</li>
<!--								<li>
									<a href="javascript:void(0);" data-boxId="photo"><?=t("Фото")?></a>
								</li>-->
							</ul>
							
							<? include "item/documents.php" ?>
							<? include "item/news.php" ?>
							<? // include "item/photo.php" ?>
							
						</div>
						
					</td>
					
					<td width="300px" valign="top" class="pl30">
						
						<? include "common/right_column.php"; ?>
						
					</td>
					
				</tr>
				
			</tbody>
		</table>
		
	</div>
	
</div>