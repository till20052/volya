<div ui-window="cells.index.list.new_cell" style="width: 500px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Новий осередок")?></h2>
	</div>

	<div class="mt30">

		
		<table width="100%" cellspacing="0" cellpadding="0">
			<tbody>
				
				<tr>
					<td width="25%" class="taright pr15"><?=t("Область")?></td>
					<td>
						<select data-ui="region" style="width: 75%"></select>
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px"></td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Район")?></td>
					<td>
						<div data-uiCover="loading" style="position: absolute; width: 259px; height: 38px; background: rgba(255,255,255,.75) center no-repeat; background-image: url('/kendo/styles/Volya/loading_2x.gif'); z-index: 999"></div>
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
				
				<tr><td colspan="2" style="height: 15px"></td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Місто")?></td>
					<td>
						<div data-uiCover="loading" style="position: absolute; width: 259px; height: 38px; background: rgba(255,255,255,.75) center no-repeat; background-image: url('/kendo/styles/Volya/loading_2x.gif'); z-index: 999"></div>
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
				
				<tr><td colspan="2" style="height: 15px"></td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Район в місті")?></td>
					<td>
						<input type="text" id="area_in_city" class="k-textbox" style="width: 75%" />
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px"></td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Адреса")?></td>
					<td>
						<input type="text" id="address" class="k-textbox" style="width: 75%" />
						<div style="font-size: 10px;color: #555;text-align: justify">В полі Адреса необхідно ввести адресу місцезнаходження первинної партійної організації. Адреса місцезнаходження первинної партійної організації забезпечується її членами</div>
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px"></td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Дільниця")?></td>
					<td>
						<table width="100%" cellspacing="0" cellpadding="0">
							<td width="1%" class="pr15 fwbold dnone" data-ui="plot_number"></td>
							<td>
								<input type="button" id="select_roep" value="<?=t("Обрати")?>" class="k-button" />
							</td>
						</table>
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px"></td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Дата проведення установчих зборів")?></td>
					<td>
						<input data-uiDatePicker="started_at" />
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px"></td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Засновники осередку")?></td>
					<td>
						<table width="100%" cellspacing="0" cellpadding="0">
							<td width="80%" data-uiBox="selected_users" class="dnone">
								<div data-uiList="selected_users">
									<script type="text/x-kendo-template">
										<div data-item="#=id#" class="fleft mt5 mr5 p5" style="background: \#efefef">
											<div class="fleft">
												<div class="fwbold">#=name#</div>
											</div>
											<div class="fright">
												<a href="javascript:void(0);" data-event="remove" class="icon"><i class="icon-remove"></i></a>
											</div>
											<div class="cboth"></div>
										</div>
									</script>
									<div class="cboth"></div>
								</div>
							</td>
							<td>
								<input type="button" id="select_users" value="<?=t("Обрати")?>" class="k-button" />
							</td>
						</table>
					</td>
				</tr>
				
				<tr><td colspan="2" style="height: 15px"></td></tr>
				
				<tr>
					<td class="taright pr15"><?=t("Скан-копія Протоколу Установчих зборів")?></td>
					<td>
						<table width="100%" cellspacing="0" cellpadding="0">
							<td width="80%" data-uiBox="scans">
								<div data-uiList="scans">
									<script type="text/x-kendo-template">
										<div data-item="#=image#" class="fleft mt5 mr5 p5">
											<div style="width: 100px; height: 150px; background: url('/s/img/thumb/ao/#=image#') center no-repeat; background-size: cover"></div>
										</div>
									</script>
									<div class="cboth"></div>
								</div>
							</td>
							<td>
								<input type="button" id="upload_scan" value="<?=t("Завантажити")?>" class="k-button" />
							</td>
						</table>
					</td>
				</tr>
				
			</tbody>
		</table>
		
	</div>
	
	<div data-uiBox="error" class="mt30 p5 fwbold dnone" style="border: 1px solid #A00; background-color: rgba(255,0,0,.1); color: #A00">
		<div id="invalid_members_count"><?=t("Кількість учасників має бути не менше 3х осіб")?></div>
	</div>
	
	<div class="mt30 tacenter">
		<a href="javascript:void(0);" id="save" class="v-button v-button-blue"><?=t("Створити")?></a>
	</div>
	
</div>