<div data-uiFrame="supporter" class="header">
	<div>
		<a href="javascript:void(0);" id="back"><?=t("Приєднатися")?></a>
	</div>
	<div>
		<h1><?=t("Стати прихильником політичної партії ")?>&laquo;<?=t("ВОЛЯ")?>&raquo;</h1>
	</div>
</div>

<div data-uiFrame="supporter" class="section mt15">
	<div>
		<form action="/profile/registration/j_submit" method="post">
			<div class="p15" style="background-color: #FEF6C1">
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
								<select data-ui="birthday_year" style="width: 50%">
									<option value="0">&mdash;</option>
									<? for($__i = (date("Y") - 18); $__i > (date("Y") - 100); $__i--){ ?>
										<option value="<?=$__i?>"><?=$__i?></option>
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
							<td style="vertical-align: middle"><?=t("Сфера роботи")?></td>
							<td>
								<select data-ui="work_scope" style="width: 100%">
									<option value="0">&mdash;</option>
									<? foreach(UserClass::getWorkScopeTypes() as $__workScopeType){ ?>
										<option value="<?=$__workScopeType["id"]?>"><?=$__workScopeType["text"]?></option>
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
							<td style="vertical-align: middle"><?=t("Додаткова інформація, яку ви бажаєте повідомити")?></td>
							<td>
								<textarea id="addtional_info" class="textbox" style="width: 100%; min-height: 100px; resize: vertical"></textarea>
							</td>
							<td></td>
						</tr>

						<tr><td colspan="3" style="height: 8px"></td></tr>

						<tr>
							<td></td>
							<td>
								<div data-uiBox="volunteer_groups">
									<div>
										<label><input type="checkbox" data-ui="i_want_to_be_a_volunteer" /><span class="fwbold"> <?=t("Я хочу бути волонтером")?></span></label>
									</div>
									<div>
										<div class="mb15"><?=t("Оберіть групу волонтерів, до якої хочете долучитися")?></div>
										<? foreach(UserClass::getVolunteerGroups() as $__volunteerGroup){ ?>
											<div>
												<label><input type="checkbox" value="<?=$__volunteerGroup["id"]?>" /><span> <?=$__volunteerGroup["text"]?></span></label>
											</div>
										<? } ?>
									</div>
								</div>
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