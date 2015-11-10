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
					<td class="taright pr15"><?=t("Призвище")?></td>
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
					<td class="taright pr15"><?=t("Область")?></td>
					<td>
						<select data-ui="rid" style="width: 75%">
							<option value="0">&mdash;</option>
							<? foreach ($geo["regions"] as $region) {?>
								<option value="<?=$region["id"]?>"><?=$region["title"]?></option>
							<? } ?>
						</select>
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>
				
				<tr data-ui="area">
					<td class="taright pr15"><?=t("Район")?></td>
					<td>
						<div data-uiCover="area" class="cover"></div>
						<select data-ui="area" style="width: 75%">
							<script type="text/x-kendo-template" id="valueTemplate">
								<div>
									# if(typeof data.area != "undefined"){ #
										#=data.area#
									# } else { #
										#=data.title#
									# } #
								</div>
							</script>
							<script type="text/x-kendo-template" id="template">
								<div>
									# if(typeof data.area != "undefined"){ #
										#=data.area#
									# } else { #
										#=data.title#
									# } #
								</div>
							</script>
						</select>
					</td>
				</tr>

				<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>
				
				<tr data-ui="city">
					<td class="taright pr15"><?=t("Місто")?></td>
					<td>
						<div data-uiCover="city" class="cover"></div>
						<select data-ui="city" style="width: 75%">
							<script type="text/x-kendo-template" id="template">
								<div class="fwbold">#=data.title#</div>
								# if(typeof data.area != "undefined"){ #
									<div>#=data.area#</div>
								# } #
							</script>
						</select>
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