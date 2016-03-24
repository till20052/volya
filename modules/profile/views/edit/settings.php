<div data-uiBox="settings" class="dnone">
	
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			
			<tr>
				<td width="<?=$leftColumnWidth?>"><?=t("Логін")?></td>
				<td>
					<input type="text" id="login" value="<?=$profile["login"]?>" class="k-textbox" style="width: 100%" />
				</td>
			</tr>
			
			<tr><td colspan="2" style="height: 15px;"></td></tr>
			
			<tr>
				<td width="<?=$leftColumnWidth?>"><?=t("Пароль")?></td>
				<td>
					<input type="password" id="password" class="k-textbox" style="width: 100%" />
				</td>
			</tr>
			
			<tr><td colspan="2" style="height: 15px;"></td></tr>
			
			<tr>
				<td width="<?=$leftColumnWidth?>"><?=t("Підтвердження")?></td>
				<td>
					<input type="password" id="confirm_password" class="k-textbox" style="width: 100%" />
				</td>
			</tr>
			
		</tbody>
	</table>

</div>