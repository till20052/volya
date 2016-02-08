<div ui-window="inquirers.settings.moderators.form" style="width: 600px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Модератори")?></h2>
	</div>
	
	<div class="mt15 fs14" ui-box="location">
		
		<div class="mt5">
			<form action="/inquirers/settings/moderators/save_moderator" method="post">
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

						<tr data-block="geo" data-id="area"><td colspan="2" style="height: 15px"></td></tr>
						<tr data-block="geo"  data-id="area">
							<td class="taright pr15"><?=t("Район або місто")?></td>
							<td>
								<select data-ui-ddl="area" style="width: 100%">
									<option value="0">&mdash;</option>
								</select>
							</td>
						</tr>

						<tr data-block="geo" data-id="location"><td colspan="2" style="height: 15px"></td></tr>
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
						</tr>
						<tr data-block="geo" data-id="location">
							<td></td>
							<td>
								<span class="fsitalic cgray">(<?=t("Введіть назву міста, населеного пункта чи села")?>)</span>
							</td>
						</tr>

						<tr data-block="geo" data-id="city_district"><td colspan="2" style="height: 15px"></td></tr>
						<tr data-block="geo" data-id="city_district">
							<td class="taright pr15"><?=t("Район у місті")?></td>
							<td>
								<select data-ui-ddl="city_district" style="width: 100%">
									<option value="0">&mdash;</option>
								</select>
							</td>
						</tr>

						<tr>
							<td colspan="2" style="height: 15px"></td>
						</tr>

						<tr>
							<td width="100px" class="vacenter taright pr15"><?=t("Члени")?>:</td>
							<td>
								<input data-uiAutoComplete="q" style="width: 100%" class="textbox">
								<script type="text/x-kendo-template" id="input_template">
									<div class="avatar" style="background-image:url('http://volya.ua/s/img/thumb/ai/#=avatar#'); float: left"></div>
									<span style="vertical-align: -webkit-baseline-middle; margin-left: 10px;">#=first_name# #=last_name#</span>
								</script>
							</td>
						</tr>

						<tr>
							<td colspan="2" style="height: 15px"></td>
						</tr>

						<tr>
							<td class="taright" colspan="2">
								<a data-action="cancel" href="#" class="v-button"><?=t("Відміна")?></a>
								<a data-action="save" href="#" class="v-button v-button-blue"><?=t("Зберегти")?></a>
							</td>
						</tr>

					</tbody>
				</table>
			</form>
		</div>
		
	</div>
	
</div>