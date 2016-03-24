<div data-ui-block="members">

	<? if(count($structure["members"]) > 0){ ?>

		<? foreach ($structure["members"] as $member) { ?>

			<div data-ui-block="member" onclick="window.location.href = '/profile/<?=$member["id"]?>'">

				<div class="avatar avatar-2x" <? if($member["avatar"]){?>style="background-image: url('http://volya.ua/s/img/thumb/ac/<?=$member["avatar"]?>');"<?}?>>
					<? if( ! $member["avatar"]){ ?>
						<i class="icon icon-user"></i>
					<? } ?>
				</div>

				<div class="name" style="width: 210px">
					<?=$member["first_name"]?><br />
					<b><?=$member["last_name"]?></b>
				</div>

				<div class="fleft ml10 cgray">
					<?=$member["is_coordinator"] ? t("Координатор") : ""?>
				</div>
				<div class="cboth"></div>

			</div>

		<? } ?>

	<? } else{ ?>
		<h3><?=t("Ще немає жодного члена партії в даній організації")?></h3>
	<? } ?>

	<div class="cboth"></div>
</div>