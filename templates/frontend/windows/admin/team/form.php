<div ui-window="admin.team.form" style="width: 800px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Редактор")?></h2>
	</div>
	
	<div class="mt10">
		
		<form action="/admin/team/j_save" method="post">
		
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>

					<? $langs = Router::getLangs() ?>

					<tr<? if( ! (count($langs) > 1)){ ?> class="dnone"<? } ?>>
						<td width="15%" align="right" class="pr30"><?=t("Мова")?>:</td>
						<td colspan="2">
							<? foreach($langs as $lang){ ?>
								<div>
									<label><input type="radio" ui-lang="<?=$lang?>" name="lang[]"> <?=LanguagesClass::getLang($lang)?></label>
								</div>
							<? } ?>
						</td>
					</tr>

					<tr<? if( ! (count($langs) > 1)){ ?> class="dnone"<? } ?>><td colspan="3" style="height:10px"></td></tr>

					<tr>
						<td align="right" class="pr30"><?=t("Ім'я")?>:</td>
						<td>
							<input type="text" ui="name" class="k-textbox" style="width: 100%" />
						</td>
						<td width="30%" rowspan="7" valign="top" class="pl10 tacenter">
							<div class="p5" style="background-color:white;box-shadow:0 0 10px rgba(0,0,0,.25)">
								<div id="preview" style="background:url('/img/no_image.jpg') no-repeat center;background-size:cover;height:100px"></div>
							</div>
							<div class='mt10'>
								<input type="button" id="upload_image" value="<?=t("Завантажити")?>" class="k-button" />
							</div>
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30"><?=t("Посада")?>:</td>
						<td>
							<input type="text" ui="job" class="k-textbox" style="width: 100%" />
						</td>
					</tr>
					
					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30"><?=t("Слоган")?>:</td>
						<td>
							<input type="text" ui="slogan" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30"><?=t("Дата народження")?>:</td>
						<td>
							<input ui="age" style="width:224px" />
						</td>
					</tr>

					<tr><td colspan="3" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30"><?=t("Посилання (Через кому)")?>:</td>
						<td colspan="3">
							<textarea ui="links" class="k-textbox" style="width: 100%"></textarea>
						</td>
					</tr>
					
					<tr><td colspan="3" style="height:10px"></td></tr>
					
					<tr>
						<td colspan="3">
							<textarea ui="bio"></textarea>
						</td>
					</tr>

					<tr><td colspan="3" style="height:10px"></td></tr>

					<tr>
						<td colspan="3" align="right">
							<a id="save" href="javascript:void(0);" class="v-button v-button-yellow mr10"><?=t("Зберегти")?></a><!--
							--><a id="cancel" href="javascript:void(0);" class="v-button"><?=t("Відміна")?></a>
						</td>
					</tr>

				</tbody>
			</table>
			
		</form>
		
	</div>
	
</div>