<div data-uibox="users">
	
	<header>
		<table width="100%" cellspacing="0" cellpadding="0">
			<? if($is_member){ ?>
<!--				<td class="taright">
					<input type="button" id="invite" value="<?=t("Запросити")?>" class="button" />
				</td>-->
			<? } ?>
		</table>
	</header>

	<section>
		<table class="members" width="100%" cellspacing="0" cellpadding="0">
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
				
				<? $__counter = 0; ?>
				<? $__columnsCount = 2; ?>

				<? foreach ($cell["members"] as $member) {
				?>
					<? if($__counter == 0){ ?>
						<tr>
					<? } ?>

					<td>
						<div class="avatar avatar-2x fleft" style="background-image:url('/s/img/thumb/aa/<?=$member["avatar"]?>');"></div>
						<div class="pt10 name">
							<a href="/profile/<?=$member["id"]?>"><?=$member["last_name"]." ".$member["first_name"]?></a>
						</div>
					</td>

					<? if($__counter == $__columnsCount - 1){ ?>
						</tr>
						<? $__counter = 0; ?>
					<? } else { ?>
						<? $__counter++ ?>
					<? } ?>

				<? } ?>
			</tbody>
		</table>
	</section>

</div>