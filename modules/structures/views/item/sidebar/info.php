<div data-block="blockTitle"><?=t("Інформація")?></div>
<div class="cboth"></div>

<div data-block="blockContent">

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
			<? $user_verifier = $structure["verification"]["user_verifier"]; ?>

			<a href="/profile/<?=$user_verifier["id"] ?>" target="_blank">
				<div>

					<div class="avatar fleft" <? if($user_verifier["avatar"]){?>style="background-image: url('http://volya.ua/s/img/thumb/ac/<?=$user_verifier["avatar"]?>');"<?}?>>
						<? if( ! $user_verifier["avatar"]){ ?>
							<i class="icon icon-user"></i>
						<? } ?>
					</div>
					<div class="name" style="width: 210px">
						<?=$user_verifier["first_name"]?><br />
						<b><?=$user_verifier["last_name"]?></b>
					</div>
					<div class="fleft cgray pl30">
						<?=$structure["verification"]["created_at"] ?>
					</div>
					<div class="cboth"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="cboth"></div>


</div>