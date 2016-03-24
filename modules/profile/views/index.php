<div class="header">
	<div>
		
		<div><?=t("Сторінка профілю людини")?></div>
		
	</div>
</div>

<div class="dashboard">
	<div>
		
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					
					<td style="width: 160px">
						<div class="avatarLoad" data-id="<?=$profile["id"]?>">
							<i class="icon-camera"></i>
						</div>
						<div id="avatar" class="avatar avatar-4x"<? if($profile["avatar"] != ""){ ?> style="background-image:url('/s/img/thumb/aa/<?=$profile["avatar"]?>'); cursor:pointer"<? } ?>></div>
					</td>
					
					<td>
						<div class="fs25 fwbold">
							<div><?=UserClass::getNameByItem($profile)?>, <span style="color: #666"><?=$profile["city_name"]?></span></div>
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
							<? } else { ?>
							<div class="fleft mr5">
								<input type="button" value="<?=t("Осередки")?>" class="button" onclick="window.location.href='/cells'" />
							</div>
							<div class="cboth"></div>
							<? } ?>
						</div>
					</td>
					
					<td class="taright">
						<? if(
								UserClass::i()->getId() == $profile["id"]
								|| UserClass::i()->hasCredential(777)
						){ ?>
						<div>
							<input type="button" value="<?=t("Редагувати профіль")?>" class="button x2" onclick="window.location.href='/profile/edit<? if(UserClass::i()->hasCredential(777) && UserClass::i()->getId() != $profile["id"]){ ?>/<?=$profile["id"]?><? } ?>'" />
						</div>
						<? } ?>
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
					
					<td valign="top">
						
						<? include "index/what_is_new.php" ?>
						
						<? if($profile["id"] == UserClass::i()->getId()){ ?>
							<? include "index/calendar.php" ?>
						<? } ?>
						
					</td>
					
					<td width="300px" valign="top" class="pl30">
						
						<? include "common/right_column.php"; ?>
						
					</td>
					
				</tr>
				
			</tbody>
		</table>
		
	</div>
	
</div>