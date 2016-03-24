<div ui-window="admin.mailer.form" style="width: 500px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Планувальник")?></h2>
	</div>
	
	<div class="mt10">
		
		<form action="/admin/mailer/j_save" method="post">
		
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
										
					<tr>
						<td width="35%" align="right" class="pr30"><?=t("Шаблон повидомлення")?>:</td>
						<td>
							<select data-ui="email_templates" style="width: 100%"></select>
						</td>						
					</tr>
					
					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30"><?=t("Дата публікації")?>:</td>
						<td>
							<input ui="sending_date" style="width:70%" />
						</td>
					</tr>
					
					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30 vatop"><?=t("Відправити")?>:</td>
						<td>
							<div>
								<input ui="send_to_all" name="send_to" checked="" type="radio" /> Всім
							</div>
							<div>
								<input ui="send_to_selected" name="send_to" type="radio" /> Вибрати
							</div>
						</td>
					</tr>
					
					<tr class="dnone"><td colspan="2" style="height:10px" class="cboth"></td></tr>
					
					<tr id="contacts_table" class="dnone">
						<td colspan="2">
							<table id="contacts_selector_table">
								<script type="text/x-kendo-template">
									<div class="tacenter">
										<input type="checkbox" value="#=data.id#">
									</div>
								</script>
								<script type="text/x-kendo-template">
									<div style="padding: 5px">#=data.value#</div>
								</script>
							</table>
						</td>
					</tr>
					
					<tr><td colspan="2" style="height:10px" class="cboth"></td></tr>
					
					<tr>
						<td colspan="2" align="right">
							<a id="save" href="javascript:void(0);" class="v-button v-button-yellow mr10"><?=t("Запланувати")?></a><!--
							--><a id="cancel" href="javascript:void(0);" class="v-button"><?=t("Відміна")?></a>
						</td>
					</tr>

				</tbody>
			</table>
			
		</form>
		
	</div>
	
</div>