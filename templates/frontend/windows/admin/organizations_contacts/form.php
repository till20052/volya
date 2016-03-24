<div ui-window="admin.organizations_contacts.form" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Редактор")?></h2>
	</div>
	
	<div class="mt10">
		
		<form action="/admin/organizations_contacts/j_save" method="post">
		
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>

					<tr>
						<td width="25%" align="right" class="pr30"><?=t("Назва організації")?>:</td>
						<td>
							<input type="text" id="title" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
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
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td align="right" class="pr30"><?=t("Адреса")?>:</td>
						<td>
							<input type="text" id="address" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td align="right" class="pr30"><?=t("ІФ відповідальної особи")?>:</td>
						<td>
							<input type="text" id="name" class="k-textbox" style="width: 100%" />
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td valign="top" align="right" class="pr30"><?=t("Email")?></td>
						<td>
							<table data-ui="email" width="100%" cellspacing="0" cellpadding="0">
								<script type="text/x-kendo-template">
									<tr data-ui="value">
										<td width="90%">
											<input type="text" placeholder="Введіть Email" class="k-textbox" style="width: 100%" />
										</td>
										<td align="center">
											<a href="javascript:void(0);" data-ui="remove" class="icon">
												<i class="icon-remove"></i>
											</a>
										</td>
									</tr>
									<tr data-ui="value"><td colspan="2" style="height: 15px"></td></tr>
								</script>
								<tbody>

								<tr>
									<td colspan="2">
										<input type="button" data-ui="add" value="<?=t("Додати")?>" class="k-button" />
									</td>
								</tr>

								</tbody>
							</table>
						</td>
					</tr>

					<tr><td colspan="2" style="height:10px"></td></tr>

					<tr>
						<td valign="top" align="right" class="pr30"><?=t("Телефон")?></td>
						<td>
							<table data-ui="phone" width="100%" cellspacing="0" cellpadding="0">
								<script type="text/x-kendo-template">
									<tr data-ui="value">
										<td width="90%">
											<input type="text" placeholder="Введіть телефон" class="k-textbox" style="width: 100%" />
										</td>
										<td align="center">
											<a href="javascript:void(0);" data-ui="remove" class="icon">
												<i class="icon-remove"></i>
											</a>
										</td>
									</tr>
									<tr data-ui="value"><td colspan="2" style="height: 15px"></td></tr>
								</script>
								<tbody>

								<tr>
									<td colspan="2">
										<input type="button" data-ui="add" value="<?=t("Додати")?>" class="k-button" />
									</td>
								</tr>

								</tbody>
							</table>
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