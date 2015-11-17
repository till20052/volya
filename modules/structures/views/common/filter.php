<div data-ui="filter">

	<div class="fs14" ui-box="location">
		<table width="100%" cellspacing="0" cellpadding="0">

			<tr>
				<td>
					<select data-value="<?=$filter["geo"]["region"] ? $filter["geo"]["region"]["id"] : ""?>" data-ui-ddl="region" style="width: 100%">
						<option value="0"><?=t("Оберіть область")?></option>
						<? foreach(GeoClass::i()->regions() as $__token){ ?>
							<option value="<?=$__token['id']?>"><?=$__token['title']?></option>
						<? } ?>
					</select>
				</td>
			</tr>

			<?
			$city = [];

			if(
				isset($filter["geo"]["district"])
			)
				$area = $filter["geo"]["district"]["id"];
			elseif(
				isset($filter["geo"]["city"])
				&& ! isset($filter["geo"]["district"])
			)
				$area = $filter["geo"]["city"]["id"];

			?>

			<tr data-id="area"><td colspan="3" style="height: 15px"></td></tr>
			<tr data-id="area">
				<td>
					<select data-value="<?=$area ? $area : ""?>" data-ui-ddl="area" style="width: 100%">
						<option value="0"><?=t("Оберіть район або місто")?></option>
					</select>
				</td>
			</tr>

			<tr data-id="location"><td colspan="3" style="height: 15px"></td></tr>
			<tr data-id="location">
				<td>
					<select data-ui-cb="location" style="width: 100%">
						<script id="data">(<?=json_encode([])?>);</script>
						<script type="text/x-kendo-template">
							<div>#=(typeof html != 'undefined' ? html : title)#</div>
							#
							var tokens = [];
							if(typeof region != 'undefined')
							tokens.push(region);
							if(typeof city != "undefined")
							tokens.push(city);
							if(typeof district != "undefined")
							tokens.push(district);
							#
							# if(tokens.length > 0){ #
							<div class="mt5 fs11">#=tokens.join(' / ')#</div>
							# } #
						</script>
					</select>
				</td>
			</tr>
			<tr data-id="location">
				<td>
					<span class="fsitalic cgray">(<?=t("Введіть назву міста, населеного пункта чи села")?>)</span>
				</td>
			</tr>

			<tr data-id="city_district"><td colspan="3" style="height: 15px"></td></tr>
			<tr data-id="city_district">
				<td class="taright pr15"><?=t("Район у місті")?></td>
				<td>
					<select data-value="<?=isset($filter["geo"]["city_district"]) ? $filter["geo"]["city_district"]["id"] : ""?>" data-ui-ddl="city_district" style="width: 100%">
						<option value="0">&mdash;</option>
					</select>
				</td>
				<td></td>
			</tr>

			<tr><td colspan="3" style="height: 15px"></td></tr>
			<tr>
				<td colspan="3" class="tacenter">
					<a data-action="filter" href="javascript:void(0);" class="v-button v-button-blue"><?=t("Пошук")?></a>
				</td>
			</tr>

		</table>
	</div>

</div>