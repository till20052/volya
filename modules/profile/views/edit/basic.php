<div data-uiBox="basic">
	
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			
			<tr>
				<td width="<?=$leftColumnWidth?>"><?=t("Прізвище")?></td>
				<td>
					<input type="text" id="last_name" disabled="" value="<?=$profile["last_name"]?>" class="textbox" style="width: 100%" />
				</td>
				<td width="<?=$leftColumnWidth?>"></td>
			</tr>
			
			<tr><td colspan="3" style="height: 15px;"></td></tr>
			
			<tr>
				<td><?=t("Ім'я")?></td>
				<td>
					<input type="text" id="first_name" disabled="" value="<?=$profile["first_name"]?>" class="textbox" style="width: 100%" />
				</td>
				<td></td>
			</tr>
			
			<tr><td colspan="3" style="height: 15px;"></td></tr>
			
			<tr>
				<td><?=t("По батькові")?></td>
				<td>
					<input type="text" id="middle_name" disabled="" value="<?=$profile["middle_name"]?>" class="textbox" style="width: 100%" />
				</td>
				<td></td>
			</tr>
			
			<tr><td colspan="3" style="height: 15px;"></td></tr>
			
			<tr>
				<td><?=t("Стать")?></td>
				<td>
					<select data-ui="sex" data-value="<?=(is_null($profile["sex"]) ? -1 : $profile["sex"])?>">
						<option value="-1">&mdash;</option>
						<? foreach(UserClass::i()->getSex() as $__sex){ ?>
							<option value="<?=$__sex["id"]?>"><?=$__sex["text"]?></option>
						<? } ?>
					</select>
				</td>
				<td></td>
			</tr>
			
			<tr><td colspan="3" style="height: 15px;"></td></tr>
			
			<tr>
				<td><?=t("Дата народження")?></td>
				<td>
					<table width="100%" cellspacing="0" cellpadding="0">
						<td width="25%" class="pr15">
							<select data-ui="birthday_day" disabled="" style="width: 100%"></select>
						</td>
						<td width="45%">
							<select data-ui="birthday_month" disabled="" style="width: 100%"></select>
						</td>
						<td class="pl15">
							<select data-ui="birthday_year" disabled="" style="width: 100%"></select>
						</td>
					</table>
				</td>
				<td></td>
			</tr>
			
		</tbody>
	</table>
	
</div>