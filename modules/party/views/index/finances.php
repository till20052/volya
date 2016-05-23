<div>
	<h1 class="fwbold"><?=t("Фінанси")?></h1>
</div>

<div class="mt5">
	<h3>Діяльність політичної партії &laquo;ВОЛЯ&raquo; фінансується у відкритий спосіб її прихильниками та членами. Будемо вдячні за вашу допомогу. Разом сформуємо чесну владу!</h3>
</div>

<div class="mt15">
	<table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				
				<td valign="top" class="pr30">
					
					<div>
						<h3 class="fwbold fs20 cblack">Профінансувати</h3>
					</div>
					
					<div class="mt15" style="background-color: white; padding: 30px 30px 30px 45px; box-sizing: border-box">
						<div style="margin-left: -18px">
							<h3 class="fwbold fs16 cblack">1. Платіжною карткою за допомогою платіжної системи ПриватБанк</h3>
						</div>
						<div class="mt15">
							<form id="privatbank" method="POST" accept-charset="utf-8" action="https://www.liqpay.com/api/pay">
								<input type="hidden" name="public_key" value="i4727938772">
								<input type="hidden" name="amount" value="5">
								<input type="hidden" name="currency" value="UAH">
								<input type="hidden" name="description" value="Мой товар">
								<input type="hidden" name="type" value="donate">
								<input type="hidden" name="pay_way" value="card,delayed">
								<input type="hidden" name="language" value="ru">
								<input type="image" name="btn_text" src="/img/privatbank.png" alt="ПриватБанк" style="width: 250px">
							</form>
							<a id="submit" href="javascript:void(0);" class="fs16">Перейти до оплати</a>
						</div>
					</div>
					
					<div class="mt15" style="background-color: white; padding: 30px 30px 30px 45px; box-sizing: border-box">
						<div style="margin-left: -18px">
							<h3 class="fwbold fs16 cblack">2. Банківським переказом</h3>
						</div>
						<div>
							<div>Перерахуйте благодійний внесок через касу банку.</div>
							<div class="mt15"><strong>Отримувач платежу:</strong> Політична партія &laquo;ВОЛЯ&raquo;</div>
							<div class="mt5"><strong>код ЄДРПОУ:</strong> 37413211</div>
							<div class="mt5"><strong>п/р:</strong> 26003052628485 в ПАТ КБ ПРИВАТБАНК Філія &laquo;Розрахунковий центр&raquo;</div>
							<div class="mt5"><strong>МФО:</strong> 320649</div>
							<div class="mt15">Увага! Під час здійснення благодійного внеску за допомогою платіжного доручення в банку необхідно мати оригінал паспорту та ідентифікаційного коду</div>
						</div>
					</div>
				</td>
				
				<td valign="top" width="350px">

					<div>
						<h3 class="fwbold fs20 cblack">Звіти</h3>
					</div>
					
					<div class="mt15" ng-controller="reportsViewController" ng-cloak="">
						<md-virtual-repeat-container id="reportsContainer">

							<md-list class="md-dense" flex ng-repeat="category in documentsCategories">
								<md-subheader class="md-no-sticky">{{ category.title }}</md-subheader>

								<md-list-item ng-click="viewDocument(document.files[0].hash)" class="md-2-line" ng-repeat="document in documentsList" ng-if="document.cid == category.id" style="padding: 0">

									<md-icon class="md-avatar-icon" style="font-size: 21px; margin-right: 5px;" aria-label="Переглянути">description</md-icon>

									<div class="md-list-item-text md-offset" style="margin-left: 5px">
										<p>{{ document.title }}</p>
									</div>
								</md-list-item>

							</md-list>

						</md-virtual-repeat-container>
					</div>
					
				</td>
			
			</tr>
		</tbody>
	</table>
</div>