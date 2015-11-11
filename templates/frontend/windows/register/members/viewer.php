<div ui-window="register.members.viewer" style="width: 700px">
	
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

		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Перевірка")?></span>
		</div>

		<div class="mt15">
			<table width="100%" cellspacing="0" cellpadding="0" data-type="notVerified">
				<tbody>
					<tr>
						<td width="200px" class="taright"></td>
						<td class="pl15">
							<label>
								<input type="radio" name="varification" id="verified" value="1"> - <?=t("Дані коректні")?>
							</label>
						</td>
					</tr>
					<tr>
						<td width="200px" class="taright"></td>
						<td class="pl15 pt10">
							<label>
								<input type="radio" name="varification" id="notVerified" value="-1"> - <?=t("Дані не коректні")?>
							</label>
						</td>
					</tr>
					<tr>
						<td class="tacenter pt10" colspan="2">
							<textarea style="width: 440px; height: 100px" class="dnone" id="comment"></textarea>
						</td>
					</tr>
				</tbody>
			</table>

			<table width="100%" cellspacing="0" cellpadding="0" data-type="verified">
				<tbody>
					<tr>
						<td width="200px" class="taright"><?=t("Перевірив")?> :</td>
						<td class="pl15">
							<div id="verifierAvatar" class="avatar avatar-2x fleft"></div>
							<div class="fleft ml10">
								<div>
									<span id="verifierName" class="fwbold fs14"></span>
								</div>
								<div>
									<span id="verificationDate"></span>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE" data-type="verified">
			<span class="fs16 fwbold"><?=t("Прийняття до членів")?></span>
		</div>

		<div class="mt15" data-type="verified">
			<table width="100%" cellspacing="0" cellpadding="0" data-type="approveForm">
				<tbody class="<?=( ! $cred->approver) ? "dnone" : "" ?>">
					<tr>
						<td class="pl15">
							<div><?=t("Номер рішення")?></div>
							<div>
								<select data-uiAutoComplete="q" style="width: 100%"></select>
								<script type="text/x-kendo-template" id="input_template">#=title#</script>
							</div>
						</td>
					</tr>
					<tr>
						<td class="pl15 pt10">
							<div><?=t("Коментар")?></div>
							<div>
								<textarea id="approveComment" class="textbox" style="height: 100px; resize: vertical"></textarea>
							</div>
						</td>
					</tr>
					<tr>
						<td class="tacenter pt10">
							<a class="v-button v-button-green" data-action="approve"><?=t("Перевести до членів")?></a>
							<a class="v-button v-button-red" data-action="dismiss"><?=t("Відхилити")?></a>
						</td>
					</tr>
				</tbody>
			</table>
			<table width="100%" cellspacing="0" cellpadding="0" data-type="approved" class="dnone">
				<tbody>
				<tr>
					<td width="200px" class="taright"><?=t("Перевів в члени")?> :</td>
					<td class="pl15">
						<div id="approverAvatar" class="avatar avatar-2x fleft"></div>
						<div class="fleft ml10">
							<div>
								<span id="approverName" class="fwbo
							</div>
							<div>
								<span id="approveDate"></span>
							</div>
						</div>
					</td>
				</tr>
				</tbody>
			</table>
		</div>

		<div class="mt15" style="border-bottom: 1px solid #CCC" data-type="notVerified"></div>
		
		<div class="mt15 pb10 tacenter" data-type="notVerified">
			<nav>
				<a class="v-button v-button-blue" id="save"><?=t("Зберегти")?></a>
			</nav>
		</div>
		
	</div>
	
</div>