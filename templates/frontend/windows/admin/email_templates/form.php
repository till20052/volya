<div ui-window="admin.email_templates.form" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Редактор")?></h2>
	</div>
	
	<div class="mt10">
		
		<form action="/admin/email_templates/j_save" method="post">
		
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>

					<? $langs = Router::getLangs() ?>

					<tr<? if( ! (count($langs) > 1)){ ?> class="dnone"<? } ?>>
						<td width="30%" align="right" class="pr30"><?=t("Мова")?>:</td>
						<td>
							<? foreach($langs as $lang){ ?>
								<div>
									<label><input type="radio" ui-lang="<?=$lang?>" name="lang[]"> <?=LanguagesClass::getLang($lang)?></label>
								</div>
							<? } ?>
						</td>
					</tr>

					<tr<? if( ! (count($langs) > 1)){ ?> class="dnone"<? } ?>><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td width="30%" align="right" class="pr30"><?=t("Символьне посилання")?>:</td>
						<td>
							<input type="text" id="symlink" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30"><?=t("Від кого")?>:</td>
						<td>
							<input type="text" ui="from" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td align="right" class="pr30"><?=t("Тема")?>:</td>
						<td>
							<input type="text" ui="subject" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td colspan="2">
							<textarea ui="message"></textarea>
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