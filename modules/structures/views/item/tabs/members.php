<div class="members">

	<? foreach ($structure["members"] as $member) { ?>
		<div onclick="window.location.href = '/profile/<?=$member["id"]?>'">
			<div class="avatar avatar-2x fleft" <? if($member["avatar"]){?>style="background-image: url('http://volya.ua/s/img/thumb/ac/<?=$member["avatar"]?>');"<?}?>>
				<? if( ! $member["avatar"]){ ?>
					<i class="icon icon-user"></i>
				<? } ?>
			</div>
			<div class="fleft ml10 fs16" style="width: 210px">
				<?=$member["name"]?>
			</div>
			<div class="fleft ml10 cgray">
				<?=$member["is_head"] ? t("Голова") : ""?>
				<?=$member["is_coordinator"] ? t("Координатор") : ""?>
			</div>
			<div class="cboth"></div>
		</div>
	<? } ?>

</div>