<div ui-window="register.admin.krk_manager.form" style="width: 600px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Менеджер КРК")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<div class="mt5">
			<form action="/register/admin/krk_manager/j_save_group" method="post">
				<table width="100%" cellspacing="0" cellpadding="0">
					<tbody>

						<tr>
							<td width="100px" class="vacenter taright"><?=t("Регіон")?>:</td>
							<td class="pl15">
								<select data-ui="geo" style="width: 100%;">
									<option value="0">&mdash;</option>
									<? foreach (GeoClass::i()->regions() as $region) { ?>
										<option value="<?=$region["id"]?>"><?=$region["title"]?></option>
									<? } ?>
								</select>
							</td>
						</tr>

						<tr>
							<td colspan="2" style="height: 15px"></td>
						</tr>

						<tr>
							<td width="100px" class="vacenter taright"><?=t("Члени")?>:</td>
							<td class="pl15">
								<select data-uiAutoComplete="q" style="width: 100%"></select>
								<script type="text/x-kendo-template" id="input_template">#=first_name# #=last_name#</script>
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