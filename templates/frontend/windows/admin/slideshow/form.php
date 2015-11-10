<div ui-window="admin.slideshow.form" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Редактор")?></h2>
	</div>
	
	<div class="mt10">
		
		<form action="/admin/slideshow/j_save" method="post">
		
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>

					<? $langs = Router::getLangs() ?>

					<tr<? if( ! (count($langs) > 1)){ ?> class="dnone"<? } ?>>
						<td width="25%" align="right" class="pr30"><?=t("Мова")?>:</td>
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
						<td width="25%" align="right" class="pr30"><?=t("Посилання")?>:</td>
						<td>
							<input type="text" id="href" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td align="right" class="pr30"><?=t("Заголовок")?>:</td>
						<td>
							<input type="text" ui="title" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td align="right" class="pr30"><?=t("Опис")?>:</td>
						<td>
							<textarea ui="description" class="k-textbox" style="width: 100%; height: 100px; resize: vertical"></textarea>
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td colspan="2">
							<div class="p5" style="background-color:white;box-shadow:0 0 10px rgba(0,0,0,.25)">
								<div id="preview" style="background:url('/img/no_image.jpg') no-repeat center;background-size:cover;height:200px"></div>
							</div>
							<div class='mt10 tacenter'>
								<input type="button" id="upload_image" value="<?=t("Завантажити")?>" class="k-button" />
							</div>
						</td>
					</tr>
					
					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td colspan="2" align="right">
							<a id="save" href="javascript:void(0);" class="v-button v-button-blue mr10"><?=t("Зберегти")?></a><!--
							--><a id="cancel" href="javascript:void(0);" class="v-button"><?=t("Відміна")?></a>
						</td>
					</tr>

				</tbody>
			</table>
			
		</form>
		
	</div>
	
</div>