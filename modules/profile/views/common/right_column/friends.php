<div data-uibox="friends">
		
	<header>
		<? if($profile["id"] == UserClass::i()->getId()){ ?>
			<a href="/profile/friends"><?=t("Моє коло")?></a>
		<? } else { ?>
			<span><?=t("Коло")?></span>
		<? } ?>
	</header>

	<section>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<?foreach($common->friends as $friend){ ?>
					<tr>
						<td width="50px">
							<div class="avatar avatar-2x"<? if($friend["avatar"] != ""){ ?> style="background-image:url('/s/img/thumb/ai/<?=$friend["avatar"]?>')"<? } ?>>
								<? if($friend["avatar"] == ""){ ?>
									<i class="icon-user"></i>
								<? } ?>
							</div>
						</td>
						<td>
							<div>
								<a href="/profile/<?=$friend["id"]?>" class="fwbold"><?=$friend["name"]?></a>
							</div>
							<? if($friend["city_id"] > 0){ ?>
								<div><?=$friend["city_name"]?></div>
							<? } ?>
						</td>
					</tr>
				<? } ?>
			</tbody>
		</table>
	</section>

</div>