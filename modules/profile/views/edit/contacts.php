<div data-uiBox="contacts" class="dnone">
	
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>

			<tr>
				<td valign="top" class="pt10" width="<?=$leftColumnWidth?>"><?=t("Населений пункт")?></td>
				<td>
					<input data-uiAutoComplete="locality" data-id="<?=$locality["id"]?>" data-title="<?=$locality["title"]?><?=(isset($locality["area"]) ? ", ".$locality["area"] : "")?><?=(isset($locality["region"]) ? ", ".$locality["region"] : "")?>" class="textbox" style="width: 100%" />
					<script type="text/x-kendo-template" id="input_template">#=title## if(typeof area != "undefined"){ #, #=area## } ## if(typeof region != "undefined"){ #, #=region## } #</script>
					<script type="text/x-kendo-template" id="template">
						<div data-id="#=id#">#=title## if(typeof area != "undefined"){ #, #=area## } ## if(typeof region != "undefined"){ #, #=region## } #</div>
					</script>
				</td>
			</tr>

			<tr><td colspan="2" style="height: 30px;"></td></tr>

			<tr>
				<td valign="top" class="pt10" width="<?=$leftColumnWidth?>"><?=t("Адрес")?></td>
				<td>
					<table width="100%">
						<tbody>
							<tr>
								
								<td width="60%">
									вул. <input type="text" id="street" value="<?=$profile["street"]?>" class="textbox" style="width: 90%" />
								</td>
								
								<td width="20%" class="pl15">
									буд. <input type="text" id="house_number" value="<?=$profile["house_number"]?>" class="textbox" style="width: 70%" />
								</td>
								
								<td width="20%" class="pl15">
									кв. <input type="text" id="apartment_number" value="<?=$profile["apartment_number"]?>" class="textbox" style="width: 75%" />
								</td>
								
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			
			<tr><td colspan="2" style="height: 30px;"></td></tr>
			
			<tr>
				<td valign="top" class="pt10" width="<?=$leftColumnWidth?>"><?=t("Email")?></td>
				<td>
					<table data-ui="email" width="100%" cellspacing="0" cellpadding="0">
						<script type="text/x-kendo-template">
							<tr>
								<td width="90%">
									<input type="text" class="k-textbox" style="width: 100%" />
								</td>
								<td align="center">
									<a href="javascript:void(0);" data-ui="remove" class="icon">
										<i class="icon-remove"></i>
									</a>
								</td>
							</tr>
							<tr><td colspan="2" style="height: 15px"></td></tr>
						</script>
						<tbody>
							
							<tr>
								<td colspan="2">
									<input type="text" value="<?=(isset($profile["contacts"]["email"][0]) ? $profile["contacts"]["email"][0] : "")?>" class="k-textbox" style="width: 100%" />
								</td>
							</tr>
							
							<tr><td colspan="2" style="height: 15px"></td></tr>
							
							<? foreach($profile["contacts"]["email"] as $__index => $__email){ ?>
								<? if( ! ($__index > 0)){ continue; } ?>
								<tr>
									<td width="90%">
										<input type="text" value="<?=$__email?>" class="k-textbox" style="width: 100%" />
									</td>
									<td align="center">
										<a href="javascript:void(0);" data-ui="remove" class="icon">
											<i class="icon-remove"></i>
										</a>
									</td>
								</tr>
								
								<tr><td colspan="2" style="height: 15px"></td></tr>
							<? } ?>
							
							<tr>
								<td colspan="2">
									<input type="button" data-ui="add" value="<?=t("Додати")?>" class="k-button" />
								</td>
							</tr>
							
						</tbody>
					</table>
				</td>
			</tr>
			
			<tr><td colspan="2" style="height: 30px;"></td></tr>
			
			<tr>
				<td valign="top" class="pt10" width="<?=$leftColumnWidth?>"><?=t("Телефон")?></td>
				<td>
					<table data-ui="phone" width="100%" cellspacing="0" cellpadding="0">
						<script type="text/x-kendo-template">
							<tr>
								<td width="90%">
									<input type="text" class="k-textbox" style="width: 100%" />
								</td>
								<td align="center">
									<a href="javascript:void(0);" data-ui="remove" class="icon">
										<i class="icon-remove"></i>
									</a>
								</td>
							</tr>
							<tr><td colspan="2" style="height: 15px"></td></tr>
						</script>
						<tbody>
							
							<tr>
								<td colspan="2">
									<input type="text" value="<?=(isset($profile["contacts"]["phone"][0]) ? $profile["contacts"]["phone"][0] : "")?>" class="k-textbox" style="width: 100%" />
								</td>
							</tr>
							
							<tr><td colspan="2" style="height: 15px"></td></tr>
							
							<? foreach($profile["contacts"]["phone"] as $__index => $__phone){ ?>
								<? if( ! ($__index > 0)){ continue; } ?>
								<tr>
									<td width="90%">
										<input type="text" value="<?=$__phone?>" class="k-textbox" style="width: 100%" />
									</td>
									<td align="center">
										<a href="javascript:void(0);" data-ui="remove" class="icon">
											<i class="icon-remove"></i>
										</a>
									</td>
								</tr>
								
								<tr><td colspan="2" style="height: 15px"></td></tr>
							<? } ?>
							
							<tr>
								<td colspan="2">
									<input type="button" data-ui="add" value="<?=t("Додати")?>" class="k-button" />
								</td>
							</tr>
							
						</tbody>
					</table>
				</td>
			</tr>
			
		</tbody>
	</table>
	
</div>