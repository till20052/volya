<div data-uiFrame="candidate" class="header">
	<div>
		<a href="javascript:void(0);" id="back"><?=t("Приєднатися")?></a>
	</div>
	<div>
		<h1><?=t("Подати заявку на членство у партії ")?>&laquo;<?=t("ВОЛЯ")?>&raquo;</h1>
	</div>
</div>

<div data-uiFrame="candidate" class="section">
	<div>
		
		<div style="padding: 15px 0; padding-top: 0"><hr /></div>
		
		<div><?=t("Для подання заявки на членство у партії необхідно завантажити та заповнити форму заявки, а також підписати люстраційну декларацію")?></div>
		
		<div class="mt15">
			<table class="layout" style="table-layout: fixed">
				<tbody>
					<tr>
						
						<td class="taleft">
							<div class="p15 fs18" style="border: 1px solid #E7E7E7">
								<div class="icon" style="color: #0181C5">
									<i class="icon-download-alt" style="vertical-align: top"></i>
									<span style="text-align: left">
										<a href="/pdf/party/index/documents/statement_0503151302.doc" target="_blank" class="fs20"><?=t("Скачати бланк заяви пронабуття членства")?></a>
									</span>
								</div>
							</div>
						</td>
						
						<td style="width: 15px"></td>
						
						<td>
							<div class="p15 fs18" style="border: 1px solid #E7E7E7">
								<div class="icon" style="color: #0181C5">
									<i class="icon-download-alt" style="vertical-align: top"></i>
									<span style="text-align: left">
										<a href="/pdf/profile/registration/declaration.pdf" target="_blank" class="fs20"><?=t("Скачати люстраційну декларацію")?></a>
									</span>
								</div>
							</div>
						</td>
						
						<td style="width: 20%"></td>
						
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="mt15">
			<span class="fwbold"><?=t("Що потрібно робити з цими бланками")?>:</span>
		</div>
		
		<div class="mt15">
			<ul class="numeric">
				<li><?=t("Скачайте та роздрукуйте обидва бланки.")?></li>
				<li><?=t("Внесіть у них всю необхідну інформацію та підпишіть.")?></li>
				<li><?=t("Відскануйте заповнені документи (збережіть у форматі PDF, PNG або JPG).")?></li>
				<li><?=t("Завантажте файли сканів, а також заповніть інші поля форми, що наведена нижче.")?></li>
			</ul>
		</div>
		
		<div style="padding: 15px 0"><hr /></div>
		
	</div>
	<div>
		<form action="/profile/registration/j_submit" method="post">
			<div class="p15" data-uiBox="documents">
				<table class="layout" style="table-layout: fixed">
					<tbody>

						<tr>
							<td width="20%" style="vertical-align: top"><?=t("Заповнені бланки")?></td>
							<td width="50%">
								<div>
									<div><?=t("Заява про набуття членства")?></div>
									<div>
										<div>
											<input type="file" name="statement" />
											<a href="javascript:void(0);"><?=t("Завантажити")?></a>
										</div>
										<div class="mt5">
											<span data-label="name" style="color: #0181C5; text-decoration: underline"></span><!--
											--><a href="javascript:void(0);" data-action="remove" class="icon" style="padding: 0; color: red">
												<i class="icon-remove fs10"></i>
											</a>
										</div>
									</div>
								</div>
								<div class="mt15">
									<div><?=t("Люстраційна декларація")?></div>
									<div>
										<div>
											<input type="file" name="declaration" />
											<a href="javascript:void(0);"><?=t("Завантажити")?></a>
										</div>
										<div class="mt5">
											<span data-label="name" style="color: #0181C5; text-decoration: underline"></span><!--
											--><a href="javascript:void(0);" data-action="remove" class="icon" style="padding: 0; color: red">
												<i class="icon-remove fs10"></i>
											</a>
										</div>
									</div>
								</div>
							</td>
							<td></td>
						</tr>

					</tbody>
				</table>
			</div>
			
			<div class="mt5 p15" style="background-color: #FEF6C1">
				<table class="layout" style="table-layout: fixed">
					<tbody>

						<tr>
							<td width="20%" style="vertical-align: middle"><?=t("Ел. пошта")?></td>
							<td width="50%">
								<input type="text" id="email" class="textbox" style="width: 100%" />
							</td>
							<td></td>
						</tr>

						<tr><td colspan="3" style="height: 8px"></td></tr>

						<tr>
							<td style="vertical-align: middle"><?=t("Пароль")?></td>
							<td>
								<input type="password" id="password" class="textbox" style="width: 100%" />
							</td>
							<td></td>
						</tr>

						<tr><td colspan="3" style="height: 8px"></td></tr>

						<tr>
							<td style="vertical-align: middle"><?=t("Пароль ще раз")?></td>
							<td>
								<input type="password" id="confirm_password" class="textbox" style="width: 100%" />
							</td>
							<td></td>
						</tr>

					</tbody>
				</table>
			</div>
			
			<div class="p15">
				<table class="layout" style="table-layout: fixed">
					<tbody>

						<tr>
							<td width="20%" style="vertical-align: middle"><?=t("Прізвище")?></td>
							<td width="50%">
								<input type="text" id="last_name" class="textbox" style="width: 100%" />
							</td>
							<td></td>
						</tr>

						<tr><td colspan="3" style="height: 8px"></td></tr>

						<tr>
							<td style="vertical-align: middle"><?=t("ім'я")?></td>
							<td>
								<input type="text" id="first_name" class="textbox" style="width: 100%" />
							</td>
							<td></td>
						</tr>

						<tr><td colspan="3" style="height: 8px"></td></tr>

						<tr>
							<td style="vertical-align: middle"><?=t("По батькові")?></td>
							<td>
								<input type="text" id="middle_name" class="textbox" style="width: 100%" />
							</td>
							<td></td>
						</tr>

						<tr><td colspan="3" style="height: 8px"></td></tr>

						<tr>
							<td style="vertical-align: middle"><?=t("Стать")?></td>
							<td>
								<select data-ui="sex" style="width: 50%">
									<option value="0"><?=t("Чоловіча")?></option>
									<option value="1"><?=t("Жіноча")?></option>
								</select>
							</td>
							<td></td>
						</tr>

						<tr><td colspan="3" style="height: 8px"></td></tr>

						<tr>
							<td style="vertical-align: middle"><?=t("Рік народження")?></td>
							<td>
								<table class="layout">
									<tbody>
										<tr>
											
											<td style="width: 25%">
												<input type="text" id="birthday_day" class="textbox" style="width: 100%; text-align: center" />
											</td>
											
											<td class="pl10 pr10" style="width: 45%">
												<select data-ui="birthday_month" style="width: 100%%"></select>
											</td>
											
											<td>
												<select data-ui="birthday_year" style="width: 100%">
													<option value="0">&mdash;</option>
													<? for($__i = (date("Y") - 18); $__i > (date("Y") - 100); $__i--){ ?>
														<option value="<?=$__i?>"><?=$__i?></option>
													<? } ?>
												</select>
											</td>
											
										</tr>
									</tbody>
								</table>
							</td>
							<td></td>
						</tr>

						<tr>
							<td colspan="3" style="padding: 10px 0">
								<hr />
							</td>
						</tr>

						<tr>
							<td style="vertical-align: middle"><?=t("Телефон")?></td>
							<td>
								<div class="tx-phone" style="width: 55%">
									<span>+38</span>
									<span>
										<input type="text" data-ui="phone" />
									</span>
								</div>
							</td>
							<td></td>
						</tr>

						<tr><td colspan="3" style="height: 8px"></td></tr>

						<tr>
							<td style="vertical-align: middle"><?=t("Населений пункт")?></td>
							<td>
								<input data-ui="geo_koatuu_code" class="textbox" style="width: 100%" />
								<script type="text/x-kendo-template" id="template">
									<div data-id="#=id#"><!--
										-->#=title#<!--
										# if(typeof area != "undefined"){ #--><span>, #=area#</span><!--# } #
										# if(typeof region != "undefined"){ #--><span>, #=region#</span><!--# } #
									--></div>
								</script>
							</td>
							<td></td>
						</tr>
						
						<tr><td colspan="3" style="height: 8px"></td></tr>
						
						<tr>
							<td style="vertical-align: middle"><?=t("Адреса")?></td>
							<td>
								<input type="text" id="address" class="textbox" style="width: 100%" />
							</td>
							<td></td>
						</tr>
						
						<tr>
							<td colspan="3" style="padding: 10px 0">
								<hr />
							</td>
						</tr>

						<tr>
							<td style="vertical-align: middle"><?=t("Освіта")?></td>
							<td>
								<select data-ui="education" style="width: 50%">
									<option value="0">&mdash;</option>
									<? foreach(UserClass::getEducationTypes() as $__educationType){ ?>
										<option value="<?=$__educationType["id"]?>"><?=$__educationType["text"]?></option>
									<? } ?>
								</select>
							</td>
							<td></td>
						</tr>

						<tr><td colspan="3" style="height: 8px"></td></tr>

						<tr>
							<td style="vertical-align: middle"><?=t("Професійний статус")?></td>
							<td>
								<select data-ui="professional_status" style="width: 100%">
									<option value="0">&mdash;</option>
									<? foreach(UserClass::getProfessionalStatusTypes() as $__professionalStatusType){ ?>
										<option value="<?=$__professionalStatusType["id"]?>"><?=$__professionalStatusType["text"]?></option>
									<? } ?>
								</select>
							</td>
							<td></td>
						</tr>

						<tr>
							<td colspan="3" style="padding: 10px 0">
								<hr />
							</td>
						</tr>
						
						<tr>
							<td style="vertical-align: middle">
								<div><?=t("Професійна діяльність")?></div>
								<div class="cgray fs12 fsitalic">(<?=t("місця роботи, посади, які ви займали")?>)</div>
							</td>
							<td>
								<textarea id="jobs" class="textbox" style="width: 100%; min-height: 100px; resize: vertical"></textarea>
							</td>
							<td></td>
						</tr>
						
						<tr><td colspan="3" style="height: 8px"></td></tr>
						
						<tr>
							<td style="vertical-align: middle">
								<div><?=t("Громадська діяльність")?></div>
								<div class="cgray fs12 fsitalic">(<?=t("участь в громадських рухах, проектах, організаціях")?>)</div>
							</td>
							<td>
								<textarea id="social_activity" class="textbox" style="width: 100%; min-height: 100px; resize: vertical"></textarea>
							</td>
							<td></td>
						</tr>
						
						<tr><td colspan="3" style="height: 8px"></td></tr>
						
						<tr>
							<td style="vertical-align: middle">
								<div><?=t("Політична діяльність")?></div>
								<div class="cgray fs12 fsitalic">(<?=t("участь в політичних партіях, виборні посади, які займали та від якої політичної сили")?>)</div>
							</td>
							<td>
								<textarea id="political_activity" class="textbox" style="width: 100%; min-height: 100px; resize: vertical"></textarea>
							</td>
							<td></td>
						</tr>
						
						<tr><td colspan="3" style="height: 8px"></td></tr>
						
						<tr>
							<td style="vertical-align: middle"><?=t("Додаткова інформація, яку ви бажаєте повідомити")?></td>
							<td>
								<textarea id="addtional_info" class="textbox" style="width: 100%; min-height: 100px; resize: vertical"></textarea>
							</td>
							<td></td>
						</tr>

						<tr>
							<td colspan="3" style="padding: 10px 0">
								<hr />
							</td>
						</tr>

						<tr>
							<td></td>
							<td colspan="2" style="vertical-align: middle">
								<div class="fleft">
									<a id="submit" href="javascript:void(0);" class="icon v-button v-button-blue"><span><?=t("Зареєструватися")?></span><i class="icon-circleright fs18"></i></a>
								</div>
								<div class="fleft fsitalic" style="padding: 13px 0; padding-left: 15px; color: red">
									<div data-uiError="not_all_fields_are_filled"><?=t("Будь ласка, заповніть усі поля")?></div>
									<div data-uiError="not_correct_values_in_fields"><?=t("Будь ласка, перевірте правельність заповнення виділених полів")?></div>
									<div data-uiError="user_already_exists"><?=t("Користувач з такою ел. поштою вже існує")?></div>
								</div>
								<div class="cboth"></div>
							</td>
						</tr>

					</tbody>
				</table>
			</div>
		</form>
	</div>
</div>