<div ui-window="register.structures.viewer" style="width: 650px">
	
	<div class="fright">
		<a class="closeButton"></a>
	</div>
	
	<div>
		<h3 data-header="title"></h3>
		<span data-header="location" style="color: #8c8c8c;"></span>
	</div>
	
	<div class="mt15 fs14">
		
		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Загальна")?></span>
		</div>
		
		<div class="mt5">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tbody>
					
					<tr>
						<td width="150px" class="vatop pt10 taright fwbold"><?=t("Рівень")?>:</td>
						<td class="pl15 pt10">
							<span id="level"></span>
						</td>
					</tr>
					
					<tr>
						<td class="vatop pt10 taright fwbold"><?=t("Населений пункт")?>:</td>
						<td class="pl15 pt10">
							<span id="location"></span>
						</td>
					</tr>

					<tr>
						<td class="vatop pt10 taright fwbold"><?=t("Адреса")?>:</td>
						<td class="pl15 pt10">
							<span id="address"></span>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		
		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Учасники")?></span> <span class="fs17 fwbold" id="mcount"></span>
		</div>
		
		<div class="mt5" id="members" style="max-height: 185px;overflow: hidden;">
			<div id="membersList" style="max-height: 185px; overflow-y: scroll; width: 630px"></div>
		</div>

		<div class="fleft mt10 member_template dnone" style="width: 50%;">
			<div class="avatar avatar-2x fleft"></div>
			<div class="fleft ml10">
				<div>
					<span id="name" class="fwbold fs14"></span>
				</div>
				<div>
					<span id="status"></span>
				</div>
			</div>
		</div>
		
		<div class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
			<span class="fs16 fwbold"><?=t("Сканкопії документів")?></span>
		</div>
		
		<div class="mt15">
			<div id="documents"></div>
		</div>
		
		<div data-uiBox="verification.header" class="mt15 p5" style="border-bottom: 1px solid #CCC; background-color: #EEE">
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

		<div class="mt15" style="border-bottom: 1px solid #CCC" data-type="notVerified"></div>

		<div class="mt15 pb10 tacenter" data-type="notVerified">
			<nav>
				<a class="v-button v-button-blue" id="save"><?=t("Зберегти")?></a>
			</nav>
		</div>
		
	</div>
	
</div>