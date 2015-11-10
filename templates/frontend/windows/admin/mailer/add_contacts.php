<div ui-window="admin.mailer.add_contacts" style="width: 500px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Імпорт контактів")?></h2>
	</div>
	
	<div class="mt10" id="contactsAddBox">
		
		<form action="/admin/mailer/j_add_contacts" method="post">
		
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
									
					<tr>
						<td width="100%">
							<textarea ui="contscts" style="width:100%; height: 100px;"></textarea>
						</td>
					</tr>
					
					<tr><td style="height:10px" class="cboth"></td></tr>
					
					<tr>
						<td align="right">
							<a id="save" href="javascript:void(0);" class="v-button v-button-yellow mr10"><?=t("Додати")?></a><!--
							--><a id="cancel" href="javascript:void(0);" class="v-button"><?=t("Відміна")?></a>
						</td>
					</tr>

				</tbody>
			</table>
			
		</form>
		
	</div>
	
	<div class="mt10 dnone" id="messageBox">
		
		<div data-uiBox="success" class="p5 dnone" style="border: 1px solid yellowgreen; color: green">
			<i class="icon-ok"></i>
			<span><?=t("Контакти успішно збережено")?></span>
		</div>
		
		<div data-uiBox="error" class="p5 dnone mt10" style="border: 1px solid #e67272; color: red">
			<i class="icon-erroralt"></i>
			<span><?=t("Дані емейли не пройшли перевірку")?> :</span>
			<ul></ul>
		</div>
		
		<div class="taright">
			<a id="close" href="javascript:void(0);" class="v-button v-button-yellow mt10"><?=t("Зарити")?></a>
		</div>
		
	</div>
	
</div>