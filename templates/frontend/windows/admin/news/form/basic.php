<table width="100%" cellspacing="0" cellpadding="0">
	<tbody>
		
		<? $__tdIndentAttr = " colspan=\"3\" style=\"height: 15px\"" ?>
		
		<tr>
			<td width="25%" class="taright pr15">
				<span><?=t("Заголовок")?></span>
			</td>
			<td width="50%">
				<input type="text" id="title" class="textbox" style="width: 100%" />
			</td>
			<td width="25%">&nbsp;</td>
		</tr>
		
		<tr>
			<td<?=$__tdIndentAttr?>>&nbsp;</td>
		</tr>
		
		<tr>
			<td width="25%" class="taright pr15">
				<span><?=t("Категорія")?></span>
			</td>
			<td width="50%">
				<select data-ui="categories" style="width: 100%">
					<script>(<?=json_encode($categories)?>);</script>
				</select>
			</td>
			<td width="25%" class="pl15">
				<a data-action="manage_categories" href="javascript:void(0);" class="v-button">...</a>
			</td>
		</tr>

		<tr data-uiGroupBox="by_regions">
			<td<?=$__tdIndentAttr?>>&nbsp;</td>
		</tr>

		<tr data-uiGroupBox="by_regions">
			<td width="25%" class="taright pr15">
				<span><?=t("Область")?></span>
			</td>
			<td width="50%">
				<select data-ui="region" style="width: 100%">
					<option value="0">&mdash;</option>
					<? foreach(OldGeoClass::i()->getRegions() as $__region){ ?>
						<option value="<?=$__region["id"]?>"><?=$__region["title"]?></option>
					<? } ?>
				</select>
			</td>
			<td width="25%" class="pl15">&nbsp;</td>
		</tr>

		<tr data-uiGroupBox="by_regions">
			<td<?=$__tdIndentAttr?>>&nbsp;</td>
		</tr>

		<tr data-uiGroupBox="by_regions">
			<td width="25%" class="taright pr15">
				<span><?=t("Місто")?></span>
			</td>
			<td width="50%">
				<input data-uiAutoComplete="city" class="textbox" style="width: 100%" />
				<script type="text/x-kendo-template" id="input_template">#=title## if(typeof area != "undefined"){ #, #=area## } #</script>
				<script type="text/x-kendo-template" id="template">
					<div data-id="#=id#">#=title## if(typeof area != "undefined"){ #<!--
					-->, #=area## } #</div>
				</script>
			</td>
			<td width="25%" class="pl15">&nbsp;</td>
		</tr>

		<tr data-uiGroupBox="by_regions">
			<td<?=$__tdIndentAttr?>>&nbsp;</td>
		</tr>

		<tr data-uiGroupBox="by_regions">
			<td class="taright pr15">&nbsp;</td>
			<td>
				<label>
					<input data-ui="in_main_block" type="checkbox" /><span> <?=t("Виводити на головний блок")?></span>
				</label>
				<label class="ml15">
					<input data-ui="in_volya_people" type="checkbox" /><span> <?=t("Люди ВОЛІ")?></span>
				</label>
				<label class="ml15 dnone">
					<input data-ui="in_top" type="checkbox" /><span> <?=t("ТОП")?></span>
				</label>
			</td>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<td<?=$__tdIndentAttr?>>&nbsp;</td>
		</tr>
		
		<tr>
			<td width="25%" class="taright pr15">
				<span><?=t("Тегі")?></span>
			</td>
			<td width="50%">
				<select data-ui="tags" style="width: 100%">
					<script>(<?=json_encode($tags)?>);</script>
				</select>
			</td>
			<td width="25%" class="pl15">
				<a data-action="manage_tags" href="javascript:void(0);" class="v-button">...</a>
			</td>
		</tr>
		
		<tr>
			<td<?=$__tdIndentAttr?>>&nbsp;</td>
		</tr>
		
		<tr>
			<td width="25%" class="taright pr15">
				<span><?=t("Дата публікації")?></span>
			</td>
			<td width="50%">
				<input data-ui="created_at" type="text" style="width: 75%" />
			</td>
			<td width="25%">&nbsp;</td>
		</tr>
		
		<tr>
			<td<?=$__tdIndentAttr?>>&nbsp;</td>
		</tr>
		
		<tr>
			<td width="25%" class="taright pr15">
				<span><?=t("Анонс")?></span>
			</td>
			<td width="50%">
				<textarea id="announcement" class="textbox" style="width: 100%; height: 100px; resize: vertical"></textarea>
			</td>
			<td width="25%">&nbsp;</td>
		</tr>

		<tr>
			<td<?=$__tdIndentAttr?>>&nbsp;</td>
		</tr>
		
		<tr>
			<td colspan="3">
				<textarea data-ui="text" data-label="<?=t("Текст")?>" style="height: 300px"></textarea>
			</td>
		</tr>
		
		<tr>
			<td<?=$__tdIndentAttr?>>&nbsp;</td>
		</tr>
		
		<tr>
			<td colspan="3" class="tacenter">
				<div data-uiView="images">
					<div data-uiBox="list">
						<script type="text/x-kendo-template">
							<div data-hash="#=hash#" style="background-image: url('/s/img/thumb/160x120/#=hash#')">
								<a data-action="delete" href="javascript:void(0);" class="icon">
									<i class="icon-remove"></i>
								</a>
							</div>
						</script>
						<div></div>
					</div>
					<div data-uiBox="uploader" class="mt5">
						<a href="javascript:void(0);" class="v-button v-button-blue">
							<input type="file" name="file" multiple="true" />
							<?=t("Завантажити фото")?>
						</a>
					</div>
				</div>
			</td>
		</tr>
		
	</tbody>
</table>