<div class="headerNew">

	<div>
		<ul class="breadcrumb">
			<li><a href="/admin">Адмін панель</a></li>
			<li class="current">Фінансові звіти</li>
		</ul>
	</div>

</div>

<div class="section">
	<div ng-controller="reportsUploaderController as ctrl" ng-cloak>

		<div layout="row" layout-align="end">
			<md-content>
				<md-button class="md-primary md-raised" ng-click="openReportsCategoriesDialog($event)">
					Категорії
				</md-button>
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

		<script type="text/ng-template" id="reportCategoriesTmpl">
			<md-dialog id="reportCategories">

				<md-toolbar>
					<div class="md-toolbar-tools">
						<h2>Категорії звітів</h2>
						<span flex></span>

						<md-button class="md-icon-button" ng-click="cancel()">
							<md-icon aria-label="Закрити">close</md-icon>
						</md-button>
					</div>
				</md-toolbar>

				<md-dialog-content class="p20">

					<div class="md-list-item-text" class="md-offset">
						<md-input-container class="md-block newCategoryTitle" style="margin: 0">
							<label><?= t("Назва нової категорії") ?></label>
							<input ng-model="newCategoryTitle">
							
							<md-button class="md-secondary md-icon-button md-primary" ng-click="add()">
								<md-icon class="material-icons" aria-label="Додати">add</md-icon>
							</md-button>
						</md-input-container>
					</div>

					<md-virtual-repeat-container>

						<md-list-item class="md-dense" flex ng-repeat="category in reportsCategories">

							<div class="md-list-item-text" class="md-offset">
								<h4 ng-if=" ! editFlag[category.id]" ng-click="edit(category.id)">{{ category.title }}</h4>

								<md-input-container class="md-block" ng-if="editFlag[category.id]" style="margin: 0">
									<input id="cid{{ category.id }}" name="catTitle" ng-model="category.newTitle" value="{{ category.title }}">
								</md-input-container>
							</div>

							<md-button ng-if="editFlag[category.id]" class="md-secondary md-icon-button md-primary" ng-click="edit(category.id)">
								<md-icon class="material-icons" aria-label="Зберегти">done</md-icon>
							</md-button>

							<md-button ng-if="editFlag[category.id]" class="md-secondary md-icon-button md-warn" ng-click="editFlag[category.id] = false">
								<md-icon class="material-icons" aria-label="Відміна">clear</md-icon>
							</md-button>

							<md-button ng-if=" ! editFlag[category.id]" class="md-secondary md-icon-button md-warn" ng-click="deleteCategory(category.id)">
								<md-icon class="material-icons" aria-label="Видалити">delete_forever</md-icon>
							</md-button>

						</md-list-item>

					</md-virtual-repeat-container>

				</md-dialog-content>

				<md-dialog-actions layout="row">
					<md-button ng-click="cancel()">
						Закрити
					</md-button>
				</md-dialog-actions>

			</md-dialog>
		</script>

	</div>

	<div ng-controller="reportsListController" ng-cloak>

		<md-virtual-repeat-container id="reportsContainer">

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

		</md-virtual-repeat-container>

		<script type="text/ng-template" id="reportViewerTmpl">
			<md-dialog style="width: 70%">

				<md-toolbar>
					<div class="md-toolbar-tools">
						<h2>Перегляд документу</h2>
						<span flex></span>

						<md-button class="md-icon-button" ng-click="cancel()">
							<md-icon aria-label="Закрити">close</md-icon>
						</md-button>
					</div>
				</md-toolbar>

				<md-dialog-content class="p20" style="min-height: 365px;">

					<h3>{{ document.title }}</h3>

					<div ng-repeat="file in document.files">
						<iframe ng-src="{{ '/s/storage/' + file.hash }}" style="width: 100%; height: 335px;"></iframe>
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
</div>