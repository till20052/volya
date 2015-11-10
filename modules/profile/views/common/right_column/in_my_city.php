<div data-uibox="in_my_city">
		
	<header>
		<a href="/people?rid=<?=$profile["region_id"]?>&cid=<?=$profile["city_id"]?>"><?=t("Хто поруч?")?></a>
	</header>

	<section>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				<?foreach($common->peopleInMyCity as $item){ ?>
					<tr>
						<td width="50px">
							<div class="avatar avatar-2x"<? if($item["avatar"] != ""){ ?> style="background-image:url('/s/img/thumb/ai/<?=$item["avatar"]?>')"<? } ?>>
								<? if($item["avatar"] == ""){ ?>
									<i class="icon-user"></i>
								<? } ?>
							</div>
						</td>
						<td>
							<div>
								<a href="/profile/<?=$item["id"]?>" class="fwbold"><?=$item["name"]?></a>
							</div>
							<? if($item["city_id"] > 0){ ?>
								<div><?=$item["city_name"]?></div>
							<? } ?>
						</td>
					</tr>
				<? } ?>
			</tbody>
		</table>
	</section>

</div>