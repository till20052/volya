<? foreach($list as $__structure){ ?>

	<? $__structure = \libs\services\StructuresService::i()->getStructure($__structure); ?>

	<div data-ui="structure" onclick="window.location.href = '/structures/<?=$__structure["id"]?>'">
		<div class="header">
			<div class="title">Осередок № <?=substr("0000", 0 , 4 - strlen($__structure["id"])).$__structure["id"]?></div>
			<div class="count icon"><i class="icon-user"></i><?=$__structure["mcount"]?></div>

			<div class="cboth"></div>

			<div class="status">
				<? if(
					$__structure["status"] == 1
					&& is_array($__structure["verification"])
				){ ?>
					<span class="registered"><?=t("Зареєстрована")?></span>
				<? } else { ?>
					<span class="unregistered"><?=t("Не зареєстрована")?></span>
				<? } ?>
			</div>
		</div>
		<div class="info">
			<b><?=\libs\services\StructuresService::i()->getLevel($__structure["level"])["long"]?></b></br>
			<?=GeoClass::i()->location($__structure["geo"])["location"]?>
		</div>
	</div>

<? } ?>
