<div ui-window="admin.register.members.viewer" style="width: 700px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h2><?=t("Переглядач")?></h2>
	</div>
	
	<div class="mt15 fs14">
		
		<div>
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td width="200px" class="taright">
							<div id="avatar" class="avatar avatar-4x fright"></div>
						</td>
						<td class="pl15 vatop">
							<div>
								<span id="name" class="fwbold fs18"></span>
							</div>
							<div>
								<span id="birthday"></span>
							</div>
							<div>
								<span id="professional_status">
									<script type="text/x-kendo-template">
										<div>#=(function(id){
											var __text = "";
											(<?=json_encode(UserClass::getProfessionalStatusTypes())?>).forEach(function(item){
												if(item.id != id)
													return;
												__text = item.text;
											});
											return __text;
										}(id))#</div>
									</script>
								</span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Контакти")?></span>
		</div>
		
		<div class="mt5">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td width="200px" class="vatop taright">Єл. пошта:</td>
						<td class="pl15">
							<span id="email"></span>
						</td>
					</tr>
					
					<tr>
						<td class="vatop taright"><?=t("Телефон")?>:</td>
						<td class="pl15">
							<span id="phone"></span>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Місцепроживання")?></span>
		</div>
		
		<div class="mt5">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td width="200px" class="vatop taright"><?=t("Населений пункт")?>:</td>
						<td class="pl15">
							<span id="locality"></span>
						</td>
					</tr>
					
					<tr>
						<td class="vatop taright"><?=t("Адреса")?>:</td>
						<td class="pl15">
							<span id="address"></span>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Освіта / профдіяльність")?></span>
		</div>
		
		<div class="mt5">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td width="200px" class="vatop taright"><?=t("Освіта")?>:</td>
						<td class="pl15">
							<span id="education">
								<script type="text/x-kendo-template">
									<div>#=(function(id){
										var __text = "";
										(<?=json_encode(UserClass::getEducationTypes())?>).forEach(function(item){
											if(item.id != id)
												return;
											__text = item.text;
										});
										return __text;
									}(id))#</div>
								</script>
							</span>
						</td>
					</tr>
					
					<tr>
						<td class="vatop taright"><?=t("Професійна діяльність")?>:</td>
						<td class="pl15">
							<span id="jobs"></span>
						</td>
					</tr>
					
					<tr>
						<td class="vatop taright"><?=t("Громадська діяльність")?>:</td>
						<td class="pl15">
							<span id="social_activity"></span>
						</td>
					</tr>
					
					<tr>
						<td class="vatop taright"><?=t("Політична діяльність")?>:</td>
						<td class="pl15">
							<span id="political_activity"></span>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Сканкопії документів")?></span>
		</div>
		
		<div class="mt15">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td width="200px" class="taright"><?=t("Документи")?>:</td>
						<td class="pl15">
							<div id="documents"></div>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
		<div data-uiBox="verification.header" class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Останє прийняте рішення")?></span>
		</div>
		
		<div data-uiBox="verification.section" class="mt15">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td width="200px" class="taright"><?=t("Перевірив")?>:</td>
						<td class="pl15">
							<div id="user_verifier-name"></div>
						</td>
					</tr>
					
					<tr>
						<td width="200px" class="taright"><?=t("Номер рішення")?>:</td>
						<td class="pl15">
							<div id="decision_number"></div>
						</td>
					</tr>
					
					<tr>
						<td width="200px" class="taright"><?=t("Дата операції")?>:</td>
						<td class="pl15">
							<div id="created_at"></div>
						</td>
					</tr>
					
					<tr>
						<td width="200px" class="taright"><?=t("Тип рішення")?>:</td>
						<td class="pl15">
							<div id="type">
								<script type="text/x-kendo-tempalate">
									#=(function(t){
										return ({
											"-10": "<?=t("Виключений з членства партії")?>",
											"-1": "<?=t("Відхилена рекомендація")?>",
											"0": "\u2014",
											"1": "<?=t("Попередня рекомендація")?>",
											"2": "<?=t("Рекомендовано")?>",
											"9": "<?=t("Призупинено членство")?>",
											"10": "<?=t("Підтверджено")?>"
										})[t];
									}(type))#
								</script>
							</div>
						</td>
					</tr>
					
					<tr>
						<td width="200px" class="taright"><?=t("Коментар")?>:</td>
						<td class="pl15">
							<div id="comment"></div>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
		<div class="mt15" style="border-bottom: 1px solid #CCC"></div>
		
		<div class="mt15 pb10 tacenter">
			<nav>
				<script>(<?=json_encode([
					[
						"type" => [-10, -1],
						"buttons" => []
					],
					[
						"type" => -1,
						"buttons" => [
							["type" => 1, "need" => ["comment"], "html" => t("Рекомендувати")]
						]
					],
					[
						"type" => 0,
						"buttons" => ($registerUser["credential_level_id"] >= 775) ? [
//							["type" => 1, "need" => ["comment"], "html" => t("Зробити попередню рекомендацію")],
							["type" => 10, "need" => ["decision_number", "comment"], "html" => t("Підтвердити")],
							["type" => -1, "need" => ["comment"], "html" => t("Не рекомендувати")]
						] : []
					],
					[
						"type" => 1,
						"buttons" => ($registerUser["credential_level_id"] >= 776) ? [
							["type" => 2, "need" => ["comment"], "html" => t("Рекомендувати")],
							["type" => -1, "need" => ["comment"], "html" => t("Не рекомендувати")]
						] : []
					],
					[
						"type" => 2,
						"buttons" => ($registerUser["credential_level_id"] == 777) ? [
							["type" => 10, "need" => ["decision_number", "comment"], "html" => t("Підтвердити")],
							["type" => -1, "need" => ["comment"], "html" => t("Відхилити рекомендацію")]
						] : []
					],
					[
						"type" => 9,
						"buttons" => ($registerUser["credential_level_id"] == 777) ? [
							["type" => 10, "need" => ["comment"], "html" => t("Поновити")],
							["type" => -10, "need" => ["decision_number", "comment"], "html" => t("Виключити з членства партії")]
						] : []
					],
					[
						"type" => 10,
						"buttons" => ($registerUser["credential_level_id"] == 777) ? [
							["type" => 9, "need" => ["comment"], "html" => t("Призупинити членство")],
							["type" => -10, "need" => ["decision_number", "comment"], "html" => t("Виключити з членства партії")]
						] : []
					],
				])?>);</script>
			</nav>
		</div>
		
	</div>
	
</div>