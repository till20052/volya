<div ui-window="inquirers.admin.inquirer" style="width: 700px">

		<div class="fright">
			<a class="closeButton"></a>
		</div>

		<div>
			<h2><?=t("Редактор")?></h2>
		</div>

		<div class="mt10" ui-box="location">

			<form action="/inquirers/admin/save_form" method="post">

				<table width="100%" cellspacing="0" cellpadding="0">
					<tbody>

					<tr data-block="geo">
						<td style="width: 115px" class="taright pr15"><?=t("Область")?><span style="padding-left: 5px; color: red">*</span></td>
						<td>
							<select data-ui-ddl="region" style="width: 100%">
								<option value="0">&mdash;</option>
								<? foreach(GeoClass::i()->regions() as $__token){ ?>
									<option value="<?=$__token['id']?>"><?=$__token['title']?></option>
								<? } ?>
							</select>
						</td>
					</tr>

					<tr data-block="geo" data-id="area"><td colspan="3" style="height: 15px"></td></tr>
					<tr data-block="geo"  data-id="area">
						<td class="taright pr15"><?=t("Район або місто")?></td>
						<td>
							<select data-ui-ddl="area" style="width: 100%">
								<option value="0">&mdash;</option>
							</select>
						</td>
						<td></td>
					</tr>

					<tr data-block="geo" data-id="location"><td colspan="3" style="height: 15px"></td></tr>
					<tr data-block="geo" data-id="location">
						<td class="taright pr15"><?=t("Місто")?></td>
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
						<td></td>
					</tr>
					<tr data-block="geo" data-id="location">
						<td></td>
						<td colspan="2">
							<span class="fsitalic cgray">(<?=t("Введіть назву міста, населеного пункта чи села")?>)</span>
						</td>
					</tr>

					<tr data-block="geo" data-id="city_district"><td colspan="3" style="height: 15px"></td></tr>
					<tr data-block="geo" data-id="city_district">
						<td class="taright pr15"><?=t("Район у місті")?></td>
						<td>
							<select data-ui-ddl="city_district" style="width: 100%">
								<option value="0">&mdash;</option>
							</select>
						</td>
						<td></td>
					</tr>

					<tr data-block="location_name">
						<td style="width: 115px" class="taright pr15"><?=t("Регіон")?></td>
						<td>
							<span style="color: #868686"></span>
						</td>
						<td></td>
					</tr

					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td style="width: 115px" class="taright pr15"><?=t("Вступний текст")?></td>
						<td>
							<textarea
									data-ui="form_start_text"
									class="textbox"
									placeholder="Введіть вступний текст. Він буде відображатись в горі анкети перед запитаннями."
									style="resize: none"></textarea>
						</td>
						<td></td>
					</tr>

					<tr>
						<td colspan="3">
							<? include "blocks/blocks.php"; ?>
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td colspan="2" align="right">
							<a data-action="save" href="javascript:void(0);" class="v-button button-yellow mr10">
								<i class="icon icon-ok"></i>
								<?=t("Готово")?>
							</a>
						</td>
					</tr>

					</tbody>
				</table>
				<div class="cboth"></div>

			</form>

		</div>

	</div>