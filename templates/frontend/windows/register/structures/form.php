<div ui-window="register.structures.form" style="width: 550px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Осередок")?></h2>
	</div>
	
	<div class="mt15 fs14" ui-box="location">

		<form action="/register/structures/save_structure" method="post">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>

				<tr>
					<td class="taright pr15"><?=t("Рівень")?></td>
					<td>
						<span id="structure_level"><?=t("Не обрано")?></span>
					</td>
					<td></td>
				</tr>

				<tr><td colspan="3" style="height: 15px"></td></tr>

				<tr>
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

				<tr data-id="area"><td colspan="3" style="height: 15px"></td></tr>
				<tr data-id="area">
					<td class="taright pr15"><?=t("Район або місто")?></td>
					<td>
						<select data-ui-ddl="area" style="width: 100%">
							<option value="0">&mdash;</option>
						</select>
					</td>
					<td></td>
				</tr>

				<tr data-id="location"><td colspan="3" style="height: 15px"></td></tr>
				<tr data-id="location">
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
				<tr data-id="location">
					<td></td>
					<td colspan="2">
						<span class="fsitalic cgray">(<?=t("Введіть назву міста, населеного пункта чи села")?>)</span>
					</td>
				</tr>

				<tr data-id="city_district"><td colspan="3" style="height: 15px"></td></tr>
				<tr data-id="city_district">
					<td class="taright pr15"><?=t("Район у місті")?></td>
					<td>
						<select data-ui-ddl="city_district" style="width: 100%">
							<option value="0">&mdash;</option>
						</select>
					</td>
					<td></td>
				</tr>

				<tr data-id="is_primary" class="dnone"><td colspan="3" style="height: 15px"></td></tr>
				<tr data-id="is_primary" class="dnone">
					<td class="taright pr15"></td>
					<td>
						<label>
							<input id="is_primary" type="checkbox" /> <?=t("Первинна партійна огранізація")?>
						</label>
					</td>
					<td></td>
				</tr>

				<tr data-id="address"><td colspan="3" style="height: 15px"></td></tr>
				<tr data-id="address">
					<td class="taright pr15"><?=t("Адреса")?><span style="padding-left: 5px; color: red">*</span></td>
					<td>
						<input data-ui-tb="address" type="text" class="k-textbox" style="width: 100%" />
					</td>
					<td></td>
				</tr>
				<tr data-id="address">
					<td></td>
					<td colspan="2">
						<span class="fsitalic cgray">(<?=t("назва вулиці, номер будинку, номер квартири")?>)</span>
					</td>
				</tr>

				<tr data-id="members" class="dnone">
					<td colspan="3" style="height: 15px"></td>
				</tr>

				<tr data-id="members" class="dnone">
					<td class="taright pr15"><?=t("Члени")?><span style="padding-left: 5px; color: red">*</span></td>
					<td colspan="2">
						<select data-uiAutoComplete="q" style="width: 100%"></select>
						<script type="text/x-kendo-template" data-ui="input_template">#=first_name# #=last_name#</script>
					</td>
				</tr>

				<tr data-id="members" class="dnone">
					<td></td>
					<td colspan="2">
						<span class="fsitalic cred o5">(<?=t("Увага! При зміні георгафічної прив'язки організації, всі члени видаляються")?>)</span>
					</td>
				</tr>

				<tr data-id="head" class="dnone">
					<td colspan="3" style="height: 15px"></td>
				</tr>

				<tr data-id="head" class="dnone">
					<td class="taright pr15"><?=t("Голова")?><span style="padding-left: 5px; color: red">*</span></td>
					<td colspan="2">
						<select data-ui="head" style="width: 100%"></select>
						<script type="text/x-kendo-template" data-ui="input_template">#=first_name# #=last_name#</script>
					</td>
				</tr>

				<tr data-id="coordinator" class="dnone">
					<td colspan="3" style="height: 15px"></td>
				</tr>

				<tr data-id="coordinator" class="dnone">
					<td class="taright pr15"><?=t("Координатор")?></td>
					<td colspan="2">
						<select data-ui="coordinator" style="width: 100%"></select>
						<script type="text/x-kendo-template" data-ui="input_template">#=first_name# #=last_name#</script>
					</td>
				</tr>

				<tr data-id="scans" class="dnone">
					<td colspan="3" style="height: 15px"></td>
				</tr>

				<tr data-id="scans" class="dnone">
					<td colspan="3" class="tacenter">
						<div data-uiView="images">
							<div data-uiBox="list">
								<script type="text/x-kendo-template">
									<div data-hash="#=hash#" style="background-image: url('/s/img/thumb/160x120/#=hash#')">
										<a data-action="delete" href="javascript:void(0);" class="icon">
											<i class="icon-remove"></i>
										</a>
									</div>
								</script>
								<div></div>
							</div>
							<div data-uiBox="uploader" class="mt5">
								<a href="javascript:void(0);" class="v-button v-button-blue">
									<input type="file" name="file" multiple="true" />
									<?=t("Завантажити скан")?>
								</a>
							</div>
						</div>
					</td>
				</tr>

				</tbody>
			</table>
		</form>

		<div data-ui="errors" class="mt15">
			<div data-error="region" class="dnone">
				<?=t("Оберіть регіон")?>
			</div>
			<div data-error="members" class="dnone mt10">
				<?=t("На обрано членів осередку")?>
			</div>
			<div data-error="address" class="dnone mt10">
				<?=t("Введіть адресу")?>
			</div>
			<div data-error="images" class="dnone mt10">
				<?=t("Завантажен не всі скани")?>
			</div>
			<div data-error="duplicate" class="dnone mt10">
				<?=t("Такий осередок вже існує")?>
			</div>
			<div data-error="head" class="dnone mt10">
				<?=t("Оберіть голову осередку")?>
			</div>
		</div>
		
		<div class="mt15 pb10 tacenter">
			<a data-action="send" href="javascript:void(0);" class="v-button v-button-blue"><?=t("Створити")?></a>
			<a data-action="cancel" href="javascript:void(0);" class="v-button"><?=t("Відміна")?></a>
		</div>
		
	</div>
	
</div>