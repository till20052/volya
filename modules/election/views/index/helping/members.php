<div data-uiFrame="members" class="mt30">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					<div>Члени дільничної виборчої комісії — розпорядники чесного виборчого процесу. Вони беруть участь у підготовці і проведенні виборів, а також у завершенні роботи у період після виборів. Протягом дня виборів члени ДВК допомагають в організації процесу голосування та не допускають фальсифікацій. Членом виборчої комісії може стати виборець, який проживає на території України.</div>
				</td>
				
				<td valign="top" width="<?=$GW[0]?>px">
					<div class="pr30" style="box-sizing: border-box">&nbsp;</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<div data-uiFrame="members" class="mt30">
	
	<div class="fwbold">Що робить член виборчої комісії:</div>
	
	<table cellspacing="0" cellpadding="0" class="mt15 fixed_table">
		<tbody>
			<tr>
				
				<td>
					<div>
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">бере участь у засіданнях дільничної виборчої комісії перед та після виборів</span>
						</div>
					</div>
					
					<div class="mt15">
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">видає бюлетені та реєструє виборців за списками на окрузі у день виборів</span>
						</div>
					</div>
				</td>
				
				<td></td>
				
				<td>
					<div>
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">знайомиться з усіма документами комісії, членом якої він є</span>
						</div>
					</div>
					
					<div class="mt15">
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">підбиває підсумки виборів — встановлює кількість тих, хто прийшов на вибори, невикористаних бюлетенів, складає та підписує протоколи підрахунку голосів</span>
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

<div data-uiFrame="members" class="mt30">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					<div>Члену дільничної виборчої комісії під час виконання своїх обов'язків забороняється агітувати за чи проти кандидатів, а також публічно оцінювати діяльність кандидатів та партій — суб'єктів виборчого процесу.</div>
				</td>
				
				<td valign="top" width="<?=$GW[0]?>px">
					<div class="pr30" style="box-sizing: border-box">&nbsp;</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<div data-uiFrame="members" class="mt30">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					<div>
						
						<div class="p30" style="background-color: white">
							
							<form action="/election/index/j_save_helper" method="post" data-helperType="3">
								
								<div data-uiBox="form">
								
									<div class="fwbold">Готові стати членом виборчої комісії?</div>

									<div class="mt5" style="color: #666666">Уважно заповніть анкету. Протягом 24 годин з вами зв’яжеться координатор членів виборчої комісії у вашому регіоні.</div>

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