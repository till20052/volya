<div ui-window="admin.users.finder" style="width: 600px">
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Пошук")?></h2>
	</div>
	
	<div class="mt10">
		
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				
				<tr>
					<td width="30%" class="taright pr15"><?=t("Ім'я")?></td>
					<td>
						<input type="text" id="first_name" class="k-textbox" style="width: 100%" />
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Прізвище")?></td>
					<td>
						<input type="text" id="last_name" class="k-textbox" style="width: 100%" />
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Статус")?></td>
					<td>
						<select data-ui="type" style="width:75%">
							<option value="0">&mdash;</option>
							<option value="1"><?=t("Користувач")?></option>
							<option value="50"><?=t("Прихильник")?></option>
							<option value="99"><?=t("Кандидат в Члени партії ВОЛЯ")?></option>
							<option value="100"><?=t("Член партії ВОЛЯ")?></option>
						</select>
					</td>
				</tr>

				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Сфера роботи")?></td>
					<td>
						<select data-ui="employment_scope" style="width: 75%">
							<option value="0">&mdash;</option>
							<? foreach ($employmentScopes as $scope) {?>
								<option value="<?=$scope["id"]?>"><?=$scope["name"]?></option>
							<? } ?>
						</select>
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Область")?></td>
					<td>
						<select data-ui="region" style="width: 75%"></select>
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>
				
				<tr data-ui="city">
					<td class="taright pr15"><?=t("Місто")?></td>
					<td>
						<div data-uiCover="city" class="cover"></div>
						<select data-ui="city" style="width: 75%"></select>
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>
				
				<tr data-ui="area">
					<td class="taright pr15"><?=t("Район")?></td>
					<td>
						<div data-uiCover="area" class="cover"></div>
						<select data-ui="area" style="width: 75%"></select>
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>
				
				<tr data-ui="area_city">
					<td class="taright pr15"><?=t("Населений пункт")?></td>
					<td>
						<select data-ui="area_city" style="width: 75%"></select>
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>
				
				<tr data-ui="city_area">
					<td class="taright pr15"><?=t("Район у місті")?></td>
					<td>
						<select data-ui="city_area" style="width: 75%"></select>
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>

				<tr>
					<td class="taright pr15"><?=t("Зареєстрований штучно?")?></td>
					<td>
						<div data-uiCover="is_artificial" class="cover"></div>
						<select data-ui="is_artificial" style="width: 75%">
							<option value="2">&mdash;</option>
							<option value="1"><?=t("Так")?></option>
							<option value="0"><?=t("Ні")?></option>
						</select>
					</td>
				</tr>

				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Усі поля заповнені")?></td>
					<td>
						<div data-uiCover="all_fields_are_filled" class="cover"></div>
						<select data-ui="all_fields_are_filled" style="width: 75%">
							<option value="0">&mdash;</option>
							<option value="1"><?=t("Так")?></option>
							<option value="2"><?=t("Користувач підтверджений")?></option>
						</select>
					</td>
				</tr>

				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>

				<tr>
					<td></td>
					<td>
						<div class="fleft mr5">
							<input type="button" data-ui="search" value="<?=t("Пошук")?>" class="k-button" />
						</div>
						<div class="fleft">
							<input type="button" data-ui="cancel" value="<?=t("Відміна")?>" class="k-button" />
						</div>
						<div class="clear"></div>
					</td>
				</tr>

			</tbody>
		</table>

	</div>
</div>