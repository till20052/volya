<div ui-window="admin.register.settings.form" style="width: 500px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2 data-id="title"></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<div data-uiFrame="finder" data-title="<?=t("Пошук")?>">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td width="25%" class="taright pr15">Ел. пошта</td>
						<td>
							<input data-uiAutoComplete="q" class="textbox" style="width: 100%" />
							<script type="text/x-kendo-template" id="input_template">#=first_name# #=last_name#</script>
							<script type="text/x-kendo-template" id="template">
								<table data-id="#=id#" data-avatar="#=avatar#" data-name="#=first_name# #=last_name#" width="100%" cellspacing="0" cellpadding="0">
									<tbody>
										<tr>
											<td width="50px">
												<div class="avatar avatar-2x"# if(avatar != ""){ # style="background-image: url('/s/img/thumb/ai/#=avatar#')"# } #>
													# if(avatar == ""){ #
														<i class="icon-user"></i>
													# } #
												</div>
											</td>
											<td class="pl10">
												<div>#=first_name# #=last_name#</div>
											</td>
										</tr>
									</tbody>
								</table>
							</script>
						</td>
						<td width="15%">&nbsp;</td>
					</tr>
					
					<tr>
						<td colspan="3" style="height: 15px"></td>
					</tr>
					
					<tr>
						<td colspan="3" class="tacenter">
							<a data-action="next" href="#" class="v-button v-button-blue"><?=t("Далі")?></a>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
		<div data-uiFrame="access_level_editor" data-title="<?=t("Рівень доступу")?>">
			<script type="text/x-kendo-template" id="profile_template">
				<table data-id="#=id#" width="100%" cellspacing="0" cellpadding="0">
					<tbody>
					<tr>
						<td width="50px">
							<div class="avatar avatar-2x"# if(avatar != ""){ # style="background-image: url('/s/img/thumb/ai/#=avatar#')"# } #>
								# if(avatar == ""){ #
									<i class="icon-user"></i>
								# } #
							</div>
						</td>
						<td class="pl10">
							<div>#=name#</div>
						</td>
					</tr>
					</tbody>
				</table>
			</script>

			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>

					<tr>
						<td width="25%"></td>
						<td colspan="2">
							<div data-uiBox="profile"></div>
						</td>
					</tr>

					<tr><td colspan="3" style="height: 15px"></td></tr>

					<tr>
						<td class="taright pr15"><?=t("Група")?></td>
						<td>
							<select data-ui="credential_levels" style="width: 100%">
								<? foreach(RegisterUsersModel::i()->getCredentialLevels() as $__id => $__credentialLevel){ ?>
									<option value="<?=$__id?>"><?=t($__credentialLevel["title"])?></option>
								<? } ?>
							</select>
						</td>
						<td></td>
					</tr>

					<tr><td colspan="3" style="height: 15px"></td></tr>

					<tr>
						<td width="25%" class="taright pr15"><?=t("Регіон")?></td>
						<td>
							<select data-ui="regions" style="width: 100%">
								<? foreach(OldGeoClass::i()->getRegions() as $__region){ ?>
									<option value="<?=$__region["id"]?>"><?=$__region["title"]?></option>
								<? } ?>
							</select>
						</td>
						<td width="25%"></td>
					</tr>

					<tr><td style="height: 15px"></td></tr>

					<tr>
						<td colspan="3" class="tacenter">
							<a data-action="save" href="javascript:void(0);" class="v-button v-button-blue mr10"><?=t("Зберегти")?></a><!--
							--><a data-action="cancel" href="javascript:void(0);" class="v-button"><?=t("Відміна")?></a>
						</td>
					</tr>

				</tbody>
			</table>
		</div>
		
	</div>
	
</div>