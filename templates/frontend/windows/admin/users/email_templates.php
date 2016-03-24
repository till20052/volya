<div ui-window="admin.users.email_templates" style="width: 400px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Вибір шаблону")?></h2>
	</div>
	
	<div class="mt30">
		
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				
				<tr>
					<td width="30%" class="taright pr15"><?=t("Шаблони")?></td>
					<td>
						<select data-ui="temapltes" style="width: 200px"></select>
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 30px"></td></tr>
				
				<tr>
					<td colspan="2">
						<div class="fright">
							<input type="button" id="cancel" value="<?=t("Відміна")?>" class="k-button" />
						</div>
						<div class="fright mr10">
							<input type="button" id="send" value="<?=t("Відправити")?>" class="k-button" />
						</div>
						<div class="cboth"></div>
					</td>
				</tr>
				
			</tbody>
		</table>
		
	</div>
	
</div>