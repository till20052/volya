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
				
				<td valign="top" width="300px">

					<? if( UserClass::i()->isAuthorized() && UserClass::i()->getId() == 18 ) { ?>
						<div ng-controller="reportsUploaderController" ng-cloak>

						<div layout="row" layout-align="center">
							<md-content>
								<md-button class="md-primary md-raised" ng-click="openReportsDialog($event)">
									Завантажити документ
								</md-button>
							</md-content>
						</div>

						<script type="text/ng-template" id="reportsDialogTmpl">
							<md-dialog>

								<md-toolbar>
									<div class="md-toolbar-tools">
										<h2>Завантаження звіту</h2>
										<span flex></span>

										<md-button class="md-icon-button" ng-click="cancel()">
											<md-icon aria-label="Закрити">close</md-icon>
										</md-button>
									</div>
								</md-toolbar>

								<md-dialog-content class="p20" style="width: 425px; min-height: 200px">

									<form name="documentInfo">

										<md-input-container class="md-block">
											<label><?= t("Назва звіту") ?></label>
											<input required="" md-maxlength="50" name="title" id="reportTitle" ng-model="title">
											<div ng-messages="documentInfo.title.$error">
												<div ng-message="required">Це поле обов'язкове</div>
												<div ng-message="md-maxlength">Назва звіту не може бути довшою за 30 символів</div>
											</div>
										</md-input-container>

										<md-input-container class="md-block">
											<label>Категорія</label>

											<md-select ng-model="cid" ng-required="true">
												<md-option ng-repeat="category in reportsCategories" value="{{category.id}}">
													{{category.title}}
												</md-option>
											</md-select>
										</md-input-container>

									</form>

									<div data-block="documentsUploader">

										<div class="filesList" style="width: 350px; min-height: 70px; float: left;" ng-model="files">

											<div class="lock-size" layout="row" layout-align="left center" style="position: fixed">

												<div style="float: left; width: 70px;" ng-repeat="file in files" ng-if="$index < 5">

													<md-fab-speed-dial class="md-scale" style="width: 70px">
														<md-fab-trigger>
															<md-button aria-label="menu" class="md-fab md-warn">
																<md-icon class="material-icons">description</md-icon>
															</md-button>
														</md-fab-trigger>
													</md-fab-speed-dial>

												</div>
											</div>
										</div>

										<div data-uiBox="uploader" class="mt5" layout-align="center">

											<md-button class="md-fab md-primary" aria-label="Завантаження" ng-click="openFileBrowser()">
												<md-icon class="material-icons" aria-label="Edit">get_app</md-icon>
											</md-button>

											<input id="fileInput" type="file" name="file" multiple="true" style="display: none"/>
										</div>
									</div>

								</md-dialog-content>

								<md-dialog-actions layout="row">
									<md-button class="md-raised md-primary" ng-click="save()" ng-disabled="documentInfo.$invalid">
										Зберегти
									</md-button>
									<md-button ng-click="cancel()">
										Відміна
									</md-button>
								</md-dialog-actions>

							</md-dialog>
						</script>

					</div>
					<? } ?>

					<div ng-controller="reportsListController" style="width: 340px;" ng-cloak>

						<md-list class="md-dense" flex ng-repeat="category in documentsCategories">
							<md-subheader class="md-no-sticky">{{ category.title }}</md-subheader>

							<md-list-item ng-click="viewDocument(document.id)" class="md-2-line" ng-repeat="document in documentsList" ng-if="document.cid == category.id" style="padding: 0">

								<md-icon class="md-avatar-icon" style="font-size: 21px; margin-right: 5px;" aria-label="Переглянути">description</md-icon>

								<div class="md-list-item-text" class="md-offset">
									<h3>{{ document.title }}</h3>
								</div>

								<? if( UserClass::i()->isAuthorized() && UserClass::i()->getId() == 18 ) { ?>
									<md-button class="md-secondary md-icon-button md-warn" style="margin-left: 0; padding-left: 0; padding-right: 0; width: 20px;" ng-click="deleteDocument(document.id)">
										<md-icon class="material-icons" aria-label="Видалити">delete_forever</md-icon>
									</md-button>
								<? } ?>

							</md-list-item>

						</md-list>

						<script type="text/ng-template" id="reportViewerTmpl">
							<md-dialog style="width: 90%">

								<md-toolbar>
									<div class="md-toolbar-tools">
										<h2>Перегляд документу</h2>
										<span flex></span>

										<md-button class="md-icon-button" ng-click="cancel()">
											<md-icon aria-label="Закрити">close</md-icon>
										</md-button>
									</div>
								</md-toolbar>

								<md-dialog-content class="p20" style="min-height: 600px;">

									<h3>{{ document.title }}</h3>

									<div ng-repeat="file in document.files">
										<iframe ng-src="{{ '/s/storage/' + file.hash }}" style="width: 100%; height: 550px;"></iframe>
									</div>

								</md-dialog-content>

								<md-dialog-actions layout="row">
									<md-button ng-click="cancel()">
										Закрити
									</md-button>
								</md-dialog-actions>

							</md-dialog>
						</script>

					</div>

					<div>
						<h3 class="fwbold fs20 cblack">Фінансові звіти партії</h3>
					</div>
					
					<div class="mt15">
						<div>
							<a href="/pdf/party/index/finances/CF_10_2015.pdf" target="_blank" class="icon">
								<i class="icon-document fs30"></i>
								<span style="text-align: left">Звіт про рух грошових коштів (поточний місяць)</span>
							</a>
						</div>
						<div class="mt15">
							<a href="/pdf/party/index/finances/charitable_support_report_24_07_2014.pdf" target="_blank" class="icon">
								<i class="icon-document fs30"></i>
								<span style="text-align: left">Звіт про благодійну підтримку</span>
							</a>
						</div>
						<div class="mt15">
							<a href="/pdf/party/index/finances/CF_2014.pdf" target="_blank" class="icon">
								<i class="icon-document fs30"></i>
								<span style="text-align: left">Звіт про рух грошових коштів за 2014 рік</span>
							</a>
						</div>
					</div>
					
				</td>
			
			</tr>
		</tbody>
	</table>
</div>