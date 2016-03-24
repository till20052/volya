<? foreach($list as $__item){ ?>
	<tr>

		<td><?=$__item["id"]?></td>

		<td>
			<div class="fwbold"><a href="/cells/<?=$__item["id"]?>"><?=$__item["city_name"]?>, <?=$__item["region_name"]?></a></div>
			<div><?=t("Номер дільниці")?>: <?=$__item["plot"]["number"]?></div>
			<div><?=t("Кількість учасників")?>: <?=count($__item["users"])?></div>
		</td>
		
	</tr>
<? } ?>