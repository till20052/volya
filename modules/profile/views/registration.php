<script id="data">
	(<?=json_encode(array(
		"employment_scopes" => EmploymentScopesModel::i()->getCompiledList()
	))?>);
</script>

<div class="header">
	<div>
		
		<table width="100%" cellpadding="0" cellspacing="0">
			<td>
				<h1 class="ttuppercase"><?=t("реєстрація")?></h1>
			</td>
		</table>
		
	</div>
</div>

<div>
	
	<div ui-frame="first">
		
		<form action="/profile/registration/j_submit" method="post">
			
			<table width="625px" cellspacing="0" cellpadding="0">

				<tbody>
					
					<tr>
						<td colspan="2" class="pb15">
							<div id="required_fields" class="alert alert-error" style="display:none">
								<i class="icon-erroralt"></i>
								<div><?=t("Перевірте правильність заповнення обов'язкових полів")?></div>
							</div>
							<div id="user_already_exists" class="alert alert-error" style="display:none">
								<i class="icon-erroralt"></i>
								<div><?=t("Користувач з таким Email вже існує")?></div>
							</div>
						</td>
					</tr>
					
					<tr>
						<td colspan="2" style="height:15px"></td>
					</tr>
					
					<tr>
						<td colspan="3">
							<div>
								<label>
									<input type="radio" name="type" ui="type" checked="" id="volonteer" value="50" />
									<span><?=t("Я хочу стати прихильником партії ВОЛЯ")?></span>
								</label>
							</div>
							<div>
								<label>
									<input type="radio" name="type" ui="type" id="candidate" value="99" />
									<span><?=t("Я хочу вступити до партії ВОЛЯ")?></span>
								</label>
							</div>
						</td>
					</tr>
					
					<tr>
						<td colspan="3" style="height:15px"></td>
					</tr>
					
					<tr ui-group="volonteer">
						<td colspan="3">
							<p>Вступительный текст волонтеров</p>
						</td>
					</tr>
					<tr ui-group="candidate">
						<td colspan="3">
							<p>Вступительный текст кандидатов</p>
						</td>
					</tr>
					
					<tr>
						<td colspan="3" style="height:15px"></td>
					</tr>
					
					<tr>
						<td width="200px" class="pr20"><?=t("Email")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<input type="text" id="email" class="k-textbox" style="width:100%" />
						</td>
					</tr>

					<tr>
						<td colspan="3" style="height:15px"></td>
					</tr>

					<tr>
						<td class="pr20"><?=t("Пароль")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<input type="password" id="password" class="k-textbox" style="width:100%" />
						</td>
					</tr>
					
					<tr>
						<td colspan="3" style="height:15px"></td>
					</tr>

					<tr>
						<td class="pr20"><?=t("Підтвердження")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<input type="password" id="confirm_password" class="k-textbox" style="width:100%" />
						</td>
					</tr>
					
					<tr>
						<td colspan="3" style="padding:15px 0">
							<hr />
						</td>
					</tr>
					
					<tr>
						<td class="pr20"><?=t("Ім'я")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<input type="text" id="first_name" class="k-textbox" style="width:100%" />
						</td>
					</tr>

					<tr>
						<td colspan="3" style="height:15px"></td>
					</tr>

					<tr>
						<td class="pr20"><?=t("Прізвище")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<input type="text" id="last_name" class="k-textbox" style="width:100%" />
						</td>
					</tr>
					
					<tr ui-group="candidate">
						<td colspan="3" style="height:15px"></td>
					</tr>
					
					<tr ui-group="candidate">
						<td class="pr20"><?=t("По батькові")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<input type="text" id="middle_name" class="k-textbox" style="width:100%" />
						</td>
					</tr>
					
					<tr>
						<td colspan="3" style="height:15px"></td>
					</tr>

					<tr>
						<td class="pr20"><?=t("Дата народження")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<select id="birthday_day" class="mr15" style="width:100px"></select><!--
							--><select id="birthday_month" class="mr15" style="width:150px"></select><!--
							--><select id="birthday_year" style="width:125px"></select>
						</td>
					</tr>
					
					<tr>
						<td colspan="3" style="height:15px"></td>
					</tr>
					
					<tr>
						<td class="pr20"><?=t("Стать")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<div>
								<label><input type="radio" name="sex" value="1" checked="" /> <span><?=t("Чоловіча")?></span></label>
								<label class="ml10"><input type="radio" name="sex" value="1" /> <span><?=t("Жіноча")?></span></label>
							</div>
						</td>
					</tr>
					
					<tr>
						<td colspan="3" style="padding:15px 0">
							<hr />
						</td>
					</tr>

					<tr>
						<td class="pr20"><?=t("Область")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<select id="region_id" data-ui="rid" style="width: 100%">
								<option value="0">&mdash;</option>
								<? foreach ($geo["regions"] as $region) {?>
									<option value="<?=$region["id"]?>"><?=$region["title"]?></option>
								<? } ?>
							</select>
						</td>
					</tr>
				
					<tr>
						<td colspan="3" style="height:15px"></td>
					</tr>
				
					<tr data-ui="area">
						<td class="pr20"><?=t("Район")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<div data-uiCover="area" class="cover"></div>
							<select id="area_id" data-ui="area" style="width: 100%">
								<script type="text/x-kendo-template" id="valueTemplate"><div>#if(typeof data.area != "undefined"){##=data.area##}else{##=data.title##}#</div></script>
								<script type="text/x-kendo-template" id="template"><div>#if(typeof data.area != "undefined"){##=data.area##}else{##=data.title##}#</div></script>
							</select>
						</td>
					</tr>

					<tr>
						<td colspan="3" style="height:15px"></td>
					</tr>
				
					<tr data-ui="city">
						<td class="pr20"><?=t("Місто")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<div data-uiCover="city" class="cover"></div>
							<select id="city_id" data-ui="city" style="width: 100%">
								<script type="text/x-kendo-template" id="template">
									<div class="fwbold">#=data.title#</div>
									# if(typeof data.area != "undefined"){ #
										<div>#=data.area#</div>
									# } #
								</script>
							</select>
						</td>
					</tr>

					<tr ui-group="candidate">
						<td colspan="3" style="height:15px"></td>
					</tr>
					
					<tr ui-group="candidate">
						<td class="pr20"><?=t("Адреса")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<table width="100%" cellspacing="0" cellpadding="0">
								<td>
									<input type="text" id="street" class="k-textbox" style="width:100%" />
								</td>
								<td width="20%" class="pl15">
									<input type="text" id="house_number" placeholder="<?=t("буд")?>" class="k-textbox" style="width:100%" />
								</td>
								<td width="20%" class="pl15">
									<input type="text" id="apartment_number" placeholder="<?=t("кв")?>" class="k-textbox" style="width:100%" />
								</td>
							</table>
						</td>
					</tr>
					
					<tr>
						<td colspan="3" style="height:15px"></td>
					</tr>
					
					<tr>
						<td class="pr20"><?=t("Телефон")?> <span style="color:red">*</span></td>
						<td colspan="2">
							<input type="text" ui="phone" id="phone" class="k-textbox" style="width:50%" />
						</td>
					</tr>
					
					<tr>
						<td colspan="3" style="padding:15px 0">
							<hr />
						</td>
					</tr>
					
					<tr>
						<td class="pr20"><?=t("Освіта")?></td>
						<td colspan="2">
							<select id="education_level" style="width:100%">
								<option value="0">&mdash;</option>
								<option value="1">Вища</option>
								<option value="2">Середня / Спеціальна</option>
								<option value="3">Закордонна</option>
								<option value="4">Незакінчена вища</option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td colspan="3" style="height:15px"></td>
					</tr>
					
					<tr>
						<td class="pr20"><?=t("Який Ваш професійний статус")?> ?</td>
						<td colspan="2">
							<select id="professional_status" style="width:100%">
								<option value="0">&mdash;</option>
								<option value="1">Власник / Підприємець</option>
								<option value="2">Керівник вищої ланки </option>
								<option value="3">Керівник середньої ланки</option>
								<option value="4">Спеціаліст</option>
								<option value="5">Студент</option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td colspan="3" style="height:15px"></td>
					</tr>
					
					<tr>
						<td class="pr20"><?=t("Сфера роботи")?></td>
						<td colspan="2">
							<select id="employment_scope" style="width:100%"></select>
						</td>
					</tr>

					<tr ui-group="volonteer">
						<td colspan="3" style="padding:15px 0">
							<hr />
						</td>
					</tr>

					<tr ui-group="volonteer">
						<td class="pr20"><?=t("Оберіть групу волонтерів, до якої хочете долучитися")?></td>
						<td colspan="2">
							<? foreach(VolunteerGroupsModel::i()->getCompiledList() as $volunteerGroup){ ?>
								<div>	
									<label>
										<input type="checkbox" ui="volunteer_group" value="<?=$volunteerGroup["id"]?>" /><!--
										--><span> <?=$volunteerGroup["name"][Router::getLang()]?></span>
									</label>
								</div>
							<? } ?>
						</td>
					</tr>

					<tr ui-group="volonteer">
						<td colspan="3" style="padding:15px 0">
							<hr />
						</td>
					</tr>

					<tr ui-group="volonteer">
						<td class="pr20"><?=t("Про себе")?></td>
						<td colspan="2">
							<textarea id="about" class="k-textbox" style="width:100%;resize:vertical"></textarea>
						</td>
					</tr>

<!--					<tr ui-group="candidate">
						<td colspan="3" style="height:15px"></td>
					</tr>

					<tr ui-group="candidate">
						<td><?//=t("Освіта")?></td>
						<td colspan="2">
							<textarea id="education" class="k-textbox" style="width: 100%;resize:vertical"></textarea>
						</td>
					</tr>-->

					<tr ui-group="candidate">
						<td colspan="3" style="height:15px"></td>
					</tr>

					<tr ui-group="candidate">
						<td>
							<?=t("Професійна діяльність")?></br>
							<span style="color: gray" class="fs11"><?=t("(місця роботи, посади, які Ви займали)")?></span>
						</td>
						<td colspan="2">
							<textarea id="jobs" class="k-textbox" style="width: 100%;resize:vertical"></textarea>
						</td>
					</tr>

					<tr ui-group="candidate">
						<td colspan="3" style="height:15px"></td>
					</tr>

					<tr ui-group="candidate">
						<td>
							<?=t("Громадська діяльність")?></br>
							<span style="color: gray" class="fs11"><?=t("(участь в громадських рухах, проектах, організаціях)")?></span>
						</td>
						<td colspan="2">
							<textarea id="social_activity" class="k-textbox" style="width: 100%;resize:vertical"></textarea>
						</td>
					</tr>

					<tr ui-group="candidate">
						<td colspan="3" style="height:15px"></td>
					</tr>

					<tr ui-group="candidate">
						<td>
							<?=t("Політична діяльність")?></br>
							<span style="color: gray" class="fs11"><?=t("(участь в політичних партіях, виборні посади, які займали та від якої політичної сили)")?></span>
						</td>
						<td colspan="2">
							<textarea id="political_activity" class="k-textbox" style="width: 100%;resize:vertical"></textarea>
						</td>
					</tr>
					
					<tr>
						<td colspan="3" style="padding:15px 0">
							<hr />
						</td>
					</tr>
					
					<tr ui-group="candidate">
						<td colspan="3">
							<label><input type="checkbox" <? if($profile["was_allowed_to_use_pd"]){ echo 'disabled="" checked=""'; } ?> id="was_allowed_to_use_pd" class="k-checkbox" /> <?=t("Я дозволяю використовувати мої данні")?></label>
						</td>
					</tr>

					<tr ui-group="candidate">
						<td colspan="3" style="height:15px"></td>
					</tr>

					<tr ui="previews" ui-group="candidate">
						<td>
							<div id="uploadApplicationForMembership" class="scanPreview">
								<div class="scanMenu dnone">
									<div>
										<?=t("Скан заяви про набуття членства")?>
									</div>
									<div class="delete dnone">
										<a class="icon">
											<i class="icon-trash"></i>
											<span><?=t("Видалити")?></span>
										</a>
									</div>
									<input type="hidden" name="scan[ApplicationForMembership]">
								</div>
							</div>
						</td>
						<td>
							<div id="uploadLustrationDeclaration" class="scanPreview">
								<div class="scanMenu dnone">
									<div>
										<?=t("Скан люстраційної декларації")?>
									</div>
									<div class="delete dnone">
										<a class="icon">
											<i class="icon-trash"></i>
											<span><?=t("Видалити")?></span>
										</a>
									</div>
									<input type="hidden" name="scan[LustrationDeclaration]">
								</div>
							</div>
						</td>
						<td>
						</td>
					</tr>
					
					<tr>
						<td colspan="2" style="height:15px"></td>
					</tr>
					
					<tr>
						<td class="pr20"></td>
						<td>
							<a href="javascript:void(0);" id="submit" class="v-button v-button-blue"><?=t("Зареєструватися")?></a>
						</td>
					</tr>
					
				</tbody>
				
			</table>
			
		</form>
		
	</div>
	
	<div ui-frame="second" class="dnone">
		
		<div>
			<h1><?=t("Вітаємо! Ви успішно зареєстровані.")?></h1>
			<p><?=t("Перевірте свою електронну пошту щоб отримати подальші інструкції та підтвердити реєстрацію.")?></p>
		</div>
		
	</div>
	
</div>