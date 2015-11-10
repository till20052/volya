<div data-uiFrame="subscriber" class="header">
	<div>
		<a href="javascript:void(0);" id="back"><?=t("Приєднатися")?></a>
	</div>
	<div>
		<h1><?=t("Отримувати інформацію та новини")?></h1>
	</div>
	<div data-uiBox="success" class="dnone">
		<h1><?=t("Дякуємо, що підписалися")?></h1>
		<h3><?=t("Ви будете отримувати новини на ел. пошту")?> <span data-uiText="email" class="fwbold">user@volya.ua</span>. <?=t("При бажанні ви завжди зможете відписатися, скориставшись посиланням у листі з новинами")?></h3>
	</div>
</div>

<div data-uiFrame="subscriber" class="section mt15">
	
	<div>
		<table class="layout" style="table-layout: fixed">
			<tbody>
				
				<tr>
					<td width="20%" style="vertical-align: middle"><?=t("Ваше ім'я")?></td>
					<td width="40%">
						<input type="text" id="name" class="textbox" style="width: 100%" />
					</td>
					<td></td>
				</tr>
				
				<tr><td colspan="3" style="height: 8px"></td></tr>
				
				<tr>
					<td style="vertical-align: middle"><?=t("Ел. пошта")?></td>
					<td>
						<input type="text" id="email" class="textbox" style="width: 100%" />
					</td>
					<td></td>
				</tr>
				
				<tr>
					<td></td>
					<td class="fs12 cgray fsitalic"><?=t("Буде використовуватися тільки для відправки новин")?></td>
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
							<a id="submit" href="javascript:void(0);" class="icon v-button v-button-blue"><span><?=t("Підписатися")?></span><i class="icon-circleright fs18"></i></a>
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
	
	<div data-uiBox="success" class="dnone">
		<div><?=t("Ви також можете долучитися до створення та діяльності партії,")?> <a href="#"><?=t("ставши її прихильником")?></a> <?=t("або")?> <a href="#"><?=t("подавши заявку на членство")?></a> <?=t("у партії")?></div>
	</div>
	
</div>