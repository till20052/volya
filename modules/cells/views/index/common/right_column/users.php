<div data-uibox="users">
	
	<header>
		<table width="100%" cellspacing="0" cellpadding="0">
			<td>
				<span><?=t("Члени осередку")?></span>
			</td>
			<? if(CellsModel::i()->isMember(UserClass::i()->getId())){ ?>
				<td class="taright">
					<input type="button" id="invite" value="<?=t("Запросити")?>" class="button" />
				</td>
			<? } ?>
		</table>
	</header>

	<section>
		<table width="100%" cellspacing="0" cellpadding="0">
			<script type="text/x-kendo-template">
				<tr data-userId="#=id#">
					<td width="50px">
						<div class="avatar avatar-2x"# if($user["avatar"] != ""){ # style="background-image:url('/s/img/thumb/ai/#=avatar#')"# } #>
							# if($user["avatar"] == ""){ #
								<i class="icon-user"></i>
							# } #
						</div>
					</td>
					<td>
						<div>
							<a href="/profile/<?=$user["id"]?>" class="fwbold"><?=$user["name"]?></a>
							<a href="javascript:void(0)" class="fright" id="delete_user" data-userId="<?=$user["id"]?>">	
								<i class="icon-trash fs11"></i>
								Видалити
							</a>
						</div>
						<? if($user["city_id"] > 0){ ?>
							<div><?=$user["city_name"]?></div>
						<? } ?>

					</td>
				</tr>
			</script>
			<tbody>
				<?foreach($common as $user){ ?>
					<tr data-userId="<?=$user["id"]?>">
						<td width="50px">
							<div class="avatar avatar-2x"<? if($user["avatar"] != ""){ ?> style="background-image:url('/s/img/thumb/ai/<?=$user["avatar"]?>')"<? } ?>>
								<? if($user["avatar"] == ""){ ?>
									<i class="icon-user"></i>
								<? } ?>
							</div>
						</td>
						<td>
							<div>
								<a href="/profile/<?=$user["id"]?>" class="fwbold"><?=$user["name"]?></a>
								<? if(CellsModel::i()->isMember(UserClass::i()->getId(), $cell["id"])) {?>
									<a href="javascript:void(0)" class="fright" id="delete_user" data-userId="<?=$user["id"]?>" data-cellId="<?=$cell["id"]?>">
										<i class="icon-trash fs11"></i>
										Видалити
									</a>
								<? } ?>
							</div>
							<? if($user["city_id"] > 0){ ?>
								<div><?=$user["city_name"]?></div>
							<? } ?>
							
						</td>
					</tr>
				<? } ?>
			</tbody>
		</table>
	</section>

</div>