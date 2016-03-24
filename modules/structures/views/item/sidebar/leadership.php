<div data-block="blockTitle"><?=t("Координатор")?></div>
<div class="cboth"></div>

<div data-block="blockContent">
	<div class="avatar avatar-2x" <? if($structure["coordinator"]["avatar"]){?>style="background-image: url('http://volya.ua/s/img/thumb/ac/<?=$structure["coordinator"]["avatar"]?>');"<?}?>>
		<? if( ! $structure["coordinator"]["avatar"]){ ?>
			<i class="icon icon-user"></i>
		<? } ?>
	</div>

	<a href="/profile/<?=$structure["coordinator"]["id"]?>" target="_blank">
		<div class="name" style="width: 210px">
			<?=$structure["coordinator"]["first_name"]?><br />
			<b><?=$structure["coordinator"]["last_name"]?></b>
		</div>
	</a>
	<div class="cboth"></div>

</div>