<h3><?=t("Інформація")?></h3>
<hr />

<div class="mt10 mb10">
	<div class="title">
		<?=t("Локація")?> :
	</div>
	<div class="value">
		<?=$structure["locality"]?>
	</div>
</div>
<div class="cboth"></div>

<div class="mt10 mb10">
	<div class="title">
		<?=t("Адреса")?> :
	</div>
	<div class="value">
		<?=$structure["address"]?>
	</div>
</div>
<div class="cboth"></div>

<div class="mt10 mb10">
	<div class="title">
		<?=t("Рівень")?> :
	</div>
	<div class="value">
		<?=$structure["level"]?>
	</div>
</div>
<div class="cboth"></div>

<div class="mt10 mb10">
	<div class="title">
		<?=t("Створено")?> :
	</div>
	<div class="value">
		<?=$structure["created_at"]?>
	</div>
</div>
<div class="cboth"></div>

<div class="mt10 mb10">
	<div class="title">
		<?=t("Перевірено")?> :
	</div>
	<div class="value">
		<div>

			<? $user_verifier = $structure["verification"]["user_verifier"]; ?>

			<div class="avatar fleft" <? if($user_verifier["avatar"]){?>style="background-image: url('http://volya.ua/s/img/thumb/ac/<?=$user_verifier["avatar"]?>');"<?}?>>
				<? if( ! $user_verifier["avatar"]){ ?>
					<i class="icon icon-user"></i>
				<? } ?>
			</div>
			<div class="fleft ml5 fs13">
				<?=$user_verifier["name"]?>
			</div>
			<div class="fleft ml5 cgray">
				<?=$structure["verification"]["created_at"] ?>
			</div>
			<div class="cboth"></div>
		</div>
	</div>
</div>
<div class="cboth"></div>