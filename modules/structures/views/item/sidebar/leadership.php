<h3><?=t("Керівництво")?></h3>
<hr />

<div class="member mt10 mb10">
	<div class="avatar avatar-2x fleft" <? if($structure["head"]["avatar"]){?>style="background-image: url('http://volya.ua/s/img/thumb/ac/<?=$structure["head"]["avatar"]?>');"<?}?>>
		<? if( ! $structure["head"]["avatar"]){ ?>
			<i class="icon icon-user"></i>
		<? } ?>
	</div>
	<div class="fleft ml10 fs16" style="width: 210px">
		<?=$structure["head"]["name"]?>
	</div>
	<div class="fleft ml10 cgray">
		<?=t("Голова")?>
	</div>
	<div class="cboth"></div>
</div>

<div class="member mt10 mb10">
	<div class="avatar avatar-2x fleft" <? if($structure["coordinator"]["avatar"]){?>style="background-image: url('http://volya.ua/s/img/thumb/ac/<?=$structure["coordinator"]["avatar"]?>');"<?}?>>
		<? if( ! $structure["coordinator"]["avatar"]){ ?>
			<i class="icon icon-user"></i>
		<? } ?>
	</div>
	<div class="fleft ml10 fs16" style="width: 210px">
		<?=$structure["coordinator"]["name"]?>
	</div>
	<div class="fleft ml10 cgray">
		<?=t("Координатор")?>
	</div>
	<div class="cboth"></div>
</div>