<div>
	<header><?=t("Населений пункт")?></header>
	<div ui-box="location" style="height: 250px">
		<table>
			<tr data-block="geo">
				<td>
					<select data-ui-ddl="region" style="width: 100%">
						<option value="0"><?=t("Оберіть область")?></option>
						<? foreach(GeoClass::i()->regions() as $__token){ ?>
							<option value="<?=$__token['id']?>"><?=$__token['title']?></option>
						<? } ?>
					</select>
				</td>
			</tr>

			<tr data-block="geo" data-id="area"><td style="height: 3px"></td></tr>
			<tr data-block="geo" data-id="area">
				<td>
					<select data-ui-ddl="area" style="width: 100%">
						<option value="0"><?=t("Район або місто")?></option>
					</select>
				</td>
			</tr>

			<tr data-block="geo" data-id="location"><td style="height: 3px"></td></tr>
			<tr data-block="geo" data-id="location">
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
			<tr data-block="geo" data-id="location">
				<td>
					<span class="fsitalic cgray">(<?=t("Введіть назву міста, населеного пункта чи села")?>)</span>
				</td>
			</tr>

			<tr data-block="geo" data-id="city_district"><td style="height: 3px"></td></tr>
			<tr data-block="geo" data-id="city_district">
				<td>
					<select data-ui-ddl="city_district" style="width: 100%">
						<option value="0"><?=t("Район у місті")?></option>
					</select>
				</td>
			</tr>
		</table>
	</div>
</div>