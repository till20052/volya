<div data-uiFrame="volunteers" class="mt30">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					<div>Агітатор — це речник ВОЛІ, який на громадських засадах допомагає організувати передвиборчу кампанію. Саме від нього залежить спілкування з виборцями у період передвиборчої агітації.</div>
				</td>
				
				<td valign="top" width="<?=$GW[0]?>px">
					<div class="pr30" style="box-sizing: border-box">&nbsp;</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<div data-uiFrame="volunteers" class="mt15">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					<blockquote>Якщо ти не чекаєш, а дієш, маєш щирі наміри та ВОЛЮ змінити країну, тоді ти &mdash; людина ВОЛІ. Додай напис «Я людина ВОЛІ» на свій профіль в соцмережах, забирай собі на сторінку <a href="/election/agitation">одну з наших</a> крутих фірмових обкладинок чи постерів або просто приєднуйся до нас в соціальних мережах &mdash; підтримай людей ВОЛІ в боротьбі проти системи.</blockquote>
				</td>
				
				<td valign="top" width="<?=$GW[0]?>px">
					<div class="pr30" style="box-sizing: border-box">&nbsp;</div>
				</td>
				
			</tr>
		</tbody>
	</table>
</div>

<div data-uiFrame="volunteers" class="mt15">
	
	<div class="fwbold">Що робить агітатор:</div>
	
	<table cellspacing="0" cellpadding="0" class="mt15 fixed_table">
		<tbody>
			<tr>
				
				<td>
					<div>
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">розповсюджує агітаційні матеріали про людей «ВОЛІ» (листівки, буклети, плакати тощо) згідно вимог виборчого законодавства</span>
						</div>
					</div>
					
					<div class="mt15">
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">збирає інформацію до Люстраційного реєстру — списку одіозних чиновників, яким немає місця у владі</span>
						</div>
					</div>
				</td>
				
				<td></td>
				
				<td>
					<div>
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">інформує громадян про негідників зі старої влади на їхньому окрузі та про людей ВОЛІ, які змінять систему</span>
						</div>
					</div>
					
					<div class="mt15">
						<div class="icon">
							<i class="icon-ok" style="color: #0181C5; vertical-align: top"></i>
							<span style="text-align: left">мобілізує виборців, організовує та проводить зустрічі</span>
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

<div data-uiFrame="volunteers" class="mt30">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					<div>
						
						<div class="p30" style="background-color: white">
							
							<form action="/election/index/j_save_helper" method="post" data-helperType="2">
								
								<div data-uiBox="form">
								
									<div class="fwbold">Готові стати агітатором?</div>

									<div class="mt5" style="color: #666666">Уважно заповніть анкету. Протягом 24 годин з вами зв’яжеться координатор волонтерів у вашому регіоні.</div>

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