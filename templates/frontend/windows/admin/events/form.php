<div ui-window="admin.events.form" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Редактор")?></h2>
	</div>
	
	<div class="mt10">
		
		<form action="/admin/events/j_save" method="post">
		
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
						<td align="right" class="pr30"><?=t("Назва")?>:</td>
						<td>
							<input type="text" ui="title" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>
					
					<tr>
						<td class="taright pr15"><?=t("Область")?></td>
						<td>
							<select data-ui="rid" style="width: 75%">
								<option value="0">&mdash;</option>
								<? foreach ($geo["regions"] as $region) {?>
									<option value="<?=$region["id"]?>"><?=$region["title"]?></option>
								<? } ?>
							</select>
						</td>
					</tr>

					<tr><td colspan="2" style="height: 15px">&nbsp;</td></tr>

					<tr data-ui="area">
						<td class="taright pr15"><?=t("Район")?></td>
						<td>
							<div data-uiCover="area" class="cover"></div>
							<select data-ui="area" style="width: 75%">
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
							<select data-ui="city" style="width: 75%">
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
						<td align="right" class="pr30"><?=t("Коли відбудется")?>:</td>
						<td>
							<input ui="happen_at" style="width:224px" />
						</td>
					</tr>
					
					<tr><td colspan="3" style="height:10px"></td></tr>
					
					<tr>
						<td colspan="3">
							<textarea ui="description"></textarea>
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