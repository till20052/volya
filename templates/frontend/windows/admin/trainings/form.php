<div ui-window="admin.trainings.form" style="width: 700px">
	
	
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Редактор")?></h2>
	</div>
	
	<div class="mt10">
		
		<form action="/admin/trainings/j_save" method="post">
		
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>

					<? $langs = Router::getLangs() ?>

					<tr<? if( ! (count($langs) > 1)){ ?> class="dnone"<? } ?>>
						<td width="25%" align="right" class="pr30"><?=t("Мова")?>:</td>
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
						<td class="taright pr15"><?=t("Область")?></td>
						<td>
							<select data-ui="rid" style="width: 100%">
								<option value="0">&mdash;</option>
								<? foreach ($regions as $region) {?>
									<option value="<?=$region["id"]?>"><?=$region["title"]?></option>
								<? } ?>
							</select>
						</td>
						<td width="30%" rowspan="5" valign="top" class="pl10 tacenter">
							<div class="p5" style="background-color:white;box-shadow:0 0 10px rgba(0,0,0,.25)">
								<div id="preview" style="background:url('/img/no_image.jpg') no-repeat center;background-size:cover;height:100px"></div>
							</div>
							<div class='mt10'>
								<input type="button" id="upload_image" value="<?=t("Завантажити")?>" class="k-button" />
							</div>
						</td>
					</tr>

					<tr><td colspan="2" style="height: 10px"></td></tr>

					<tr data-ui="area">
						<td class="taright pr15"><?=t("Район")?></td>
						<td>
							<div data-uiCover="area" class="cover"></div>
							<select data-ui="area" style="width: 100%">
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
							<select data-ui="city" style="width: 100%">
								<script type="text/x-kendo-template" id="template">
									<div class="fwbold">#=data.title#</div>
									# if(typeof data.area != "undefined"){ #
										<div>#=data.area#</div>
									# } #
								</script>
							</select>
						</td>
					</tr>
					
					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td align="right" class="pr30"><?=t("Адреса")?>:</td>
						<td>
							<input type="text" ui="address" class="textbox" style="width: 100%" />
						</td>
					</tr>
					
					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td align="right" class="pr30"><?=t("Назва")?>:</td>
						<td>
							<input type="text" ui="title" class="textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30 vatop pt10">Title:</td>
						<td>
							<textarea ui="meta_title" class="textbox" style="width: 100%; resize: vertical"></textarea>
						</td>
					</tr>
					
					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30 vatop pt10">Description:</td>
						<td>
							<textarea ui="meta_description" class="textbox" style="width: 100%; resize: vertical"></textarea>
						</td>
					</tr>
					
					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30 vatop pt10">Keywords:</td>
						<td>
							<textarea ui="meta_keywords" class="textbox" style="width: 100%; resize: vertical"></textarea>
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>
					
					<tr>
						<td align="right" class="pr30"><?=t("Дата початку")?>:</td>
						<td>
							<input ui="happen_at" style="width:224px" />
						</td>
					</tr>
					
					<tr><td colspan="3" style="height:10px"></td></tr>
					
					<tr>
						<td colspan="3">
							<textarea ui="text"></textarea>
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