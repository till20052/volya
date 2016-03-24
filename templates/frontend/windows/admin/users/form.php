<div ui-window="admin.users.form" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Редактор")?></h2>
	</div>
	
	<div class="mt10">
		
		<form action="/admin/users/j_save" method="post">
		
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td align="right" class="pr30"><?=t("Прізвище")?>:</td>
						<td>
							<input type="text" id="last_name" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td width="25%" align="right" class="pr30"><?=t("Ім'я")?>:</td>
						<td>
							<input type="text" id="first_name" class="k-textbox" style="width: 100%" />
						</td>
					</tr>
					
					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td align="right" class="pr30"><?=t("По батькові")?>:</td>
						<td>
							<input type="text" id="middle_name" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30"><?=t("Логін")?>:</td>
						<td>
							<input type="text" id="login" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30"><?=t("Пароль")?>:</td>
						<td>
							<input type="password" id="password" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30"><?=t("Підтвердження")?>:</td>
						<td>
							<input type="password" id="confirm_password" class="k-textbox" style="width: 100%" />
						</td>
					</tr>
					
					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30"><?=t("Статус")?>:</td>
						<td>
							<select data-ui="type" style="width:50%">
								<option value="1"><?=t("Підписник")?></option>
								<option value="50"><?=t("Прихильник")?></option>
								<option value="99"><?=t("Кандидат в Члени партії ВОЛЯ")?></option>
								<option value="100"><?=t("Член партії ВОЛЯ")?></option>
							</select>
						</td>
					</tr>
					
					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30"><?=t("Рівень доступу")?>:</td>
						<td>
							<select data-ui="credential_level" style="width:50%">
								<? foreach ($credentials as $key => $name) {?>
									<option value="<?=$key?>"><?=$name?></option>
								<? } ?>
							</select>
						</td>
					</tr>
					
					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td colspan="2" align="right">
							<a id="save" href="javascript:void(0);" class="v-button v-button-yellow mr10"><?=t("Зберегти")?></a><!--
							--><a id="cancel" href="javascript:void(0);" class="v-button"><?=t("Відміна")?></a>
						</td>
					</tr>

				</tbody>
			</table>
			
		</form>
		
	</div>
	
</div>