<div data-uiFrame="observers" class="mt30">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					<div>Офіційний спостерігач — захисник прав громадян України на чесні вибори. Протягом дня виборів спостерігачі знаходяться на дільниці та контролюють виборчий процес, щоби не допустити порушень під час голосування та підрахунку голосів. Офіційним спостерігачем не може бути член виборчої комісії, посадовець виконавчої влади або суду, правоохоронних органів та військовослужбовець.</div>
				</td>
				
				<td valign="top" width="<?=$GW[0]?>px">
					<div class="pr30" style="box-sizing: border-box">&nbsp;</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<div data-uiFrame="observers" class="mt30">
	
	<div class="fwbold">Що робить офіційний спостерігач:</div>
	
	<table cellspacing="0" cellpadding="0" class="mt15 fixed_table">
		<tbody>
			<tr>
				
				<td>
					<div>
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">Спостерігає за агітацією кандидатів та голосуванням, в тому числі під час видачі бюлетенів виборцям та підрахунку голосів</span>
						</div>
					</div>
					
					<div class="mt15">
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">Реагує на порушення виборчого законодавства — складає акт про порушення виборчого закону та подає його до виборчої комісії або суду</span>
						</div>
					</div>
					
					<div class="mt15">
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">Отримує копії протоколів про передачу виборчих бюлетенів, підрахунок голосів та встановлення підсумків голосування</span>
						</div>
					</div>
				</td>
				
				<td></td>
				
				<td>
					<div>
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">Проводить фото-, відео- та аудіофіксацію виборчого процесу, не порушуючи таємницю голосування</span>
						</div>
					</div>
					
					<div class="mt15">
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">Відвідує засідання виборчих комісій, в тому числі під час підрахунку голосів та встановленні підсумків голосування</span>
						</div>
					</div>
				</td>
				
				<td></td>
				
				<td>
					&nbsp;
				</td>
				
			</tr>
		</tbody>
	</table>
	
</div>

<div data-uiFrame="observers" class="mt30">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					<div>Перешкоджання діяльності офіційного спостерігача при виконанні ним своїх повноважень, поєднане з підкупом, обманом або примушуванням, карається статтею 157 КК України.</div>
				</td>
				
				<td valign="top" width="<?=$GW[0]?>px">
					<div class="pr30" style="box-sizing: border-box">&nbsp;</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<div data-uiFrame="observers" class="mt30">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					<div>
						
						<div class="p30" style="background-color: white">
							
							<form action="/election/index/j_save_helper" method="post" data-helperType="4">
								
								<div data-uiBox="form">
								
									<div class="fwbold">Готові стати cпостерігачем?</div>

									<div class="mt5" style="color: #666666">Уважно заповніть анкету. Протягом 24 годин з вами зв’яжеться координатор cпостерігачів у вашому регіоні.</div>

									<div class="mt15">
										<div>Ім'я та прізвище</div>
										<div class='mt5'>
											<input id="name" type="text" class="textbox" style="width: 50%" />
										</div>
									</div>

									<div class="mt15">
										<div>Ел. пошта</div>
										<div class='mt5'>
											<input id="email" type="text" class="textbox" style="width: 50%" />
										</div>
									</div>

									<div class="mt15">
										<div>Телефон <span class="cgray fsitalic">(за бажанням)</span></div>
										<div class='mt5'>
											<div class="textbox-phone" style="width: 50%">
												<span>+38</span>
												<span>
													<input type="text" data-ui="phone" />
												</span>
											</div>
										</div>
									</div>

									<div class="mt15">
										<div>Ваш населений пункт</div>
										<div class='mt5'>
											<input data-ui="locality" type="text" class="textbox" style="width: 100%" />
											<script type="text/x-kendo-template" id="template">
												<div data-id="#=id#"><!--
													-->#=title#<!--
													# if(typeof area != "undefined"){ #--><span>, #=area#</span><!--# } #
													# if(typeof region != "undefined"){ #--><span>, #=region#</span><!--# } #
												--></div>
											</script>
										</div>
									</div>

									<div class="mt15">
										<table width="100%" cellspacing="0" cellpadding="0" style="table-layout: fixed">
											<tbody>
												<tr>

													<td width="50%" class="pr5">
														<div>Номер округу <span class="cgray fsitalic">(якщо знаєте)</span></div>
														<div class='mt5'>
															<select data-ui="county_numbers" style="width: 100%"></select>
														</div>
													</td>

													<td width="50%" class="pl5">
														<div>Номер дільниці <span class="cgray fsitalic">(якщо знаєте)</span></div>
														<div class='mt5'>
															<select data-ui="polling_places" style="width: 100%">
																<script id="template" type="text/x-kendo-template">
																	# if(id > 0){ #
																		<div>#=number#</div>
																		<div class="fs12 cgray fwitalic">#=address#</div>
																	# } else { #
																		<div>#=text#</div>
																	# } #
																</script>
																<script id="valueTemplate" type="text/x-kendo-template">
																	# if(id > 0){ #
																		<div>#=number# <span class="fs12 cgray fwitalic">(#=address#)</span></div>
																	# } else { #
																		<div>#=text#</div>
																	# } #
																</script>
															</select>
														</div>
													</td>

												</tr>
											</tbody>
										</table>
									</div>

									<div class="mt15">
										<div>Додаткова інформація, яку ви бажаєте повідомити</div>
										<div class='mt5'>
											<textarea id="additional_info" class="textbox" style="width: 100%; height: 150px; resize: vertical"></textarea>
										</div>
									</div>

									<div class="mt15">
										<a data-action="submit" href="javascript:void(0);" class="v-button v-button-blue icon">
											<span><?=t("Відправити")?></span>
											<i class="icon-circleright"></i>
										</a>
									</div>
								
								</div>
								
								<div data-uiBox="success" class="dnone">
									<h2 class="fwbold" style="color: #333">Дякуємо за бажання допомогти «ВОЛІ» на виборах</h2>
									<h3 class="mt15">Очікуйте на лист або смс від координатора волонтерів «ВОЛІ» у вашому регіоні. У разі виникнення запитань звертайтеся до центрального штабу за телефоном <strong>0 800 30 78 77</strong></h3>
								</div>
								
							</form>
							
						</div>
						
					</div>
				</td>
				
				<td valign="top" width="<?=$GW[0]?>px">
					<div class="pr30" style="box-sizing: border-box">&nbsp;</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>