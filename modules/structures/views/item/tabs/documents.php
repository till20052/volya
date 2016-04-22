<div ng-controller="documentsUploaderController" ng-cloak="">

	<div layout="row" layout-align="center">
		<md-content>
			<md-button class="md-primary md-raised" ng-click="openDocumentsUploadDialog($event)">
				Завантажити документ
			</md-button>
		</md-content>
	</div>

	<script type="text/ng-template" id="documentsUploaderTmpl">
		<md-dialog>

			<md-toolbar>
				<div class="md-toolbar-tools">
					<h2>Завантаження документу</h2>
					<span flex></span>

					<md-button class="md-icon-button" ng-click="cancel()">
						<md-icon aria-label="Закрити">close</md-icon>
					</md-button>
				</div>
			</md-toolbar>

			<md-dialog-content class="p20" style="width: 425px; min-height: 300px">

				<form name="documentInfo">

					<md-input-container class="md-block">
						<label><?= t("Назва документу") ?></label>
						<input required="" md-maxlength="50" name="title" id="docTitle" ng-model="title">
						<div ng-messages="documentInfo.title.$error">
							<div ng-message="required">Це поле обов'язкове</div>
							<div ng-message="md-maxlength">Назва документу не може бути довшою за 30 символів</div>
						</div>
					</md-input-container>

					<md-input-container class="md-block">
						<label><?= t("Опис") ?></label>
						<input md-maxlength="150" md-no-asterisk name="description" ng-model="description">

						<div ng-messages="documentInfo.description.$error">
							<div ng-message="md-maxlength">Назва документу не може бути довшою за 150 символів</div>
						</div>
					</md-input-container>

					<md-input-container class="md-block">
						<label>Категорія</label>

						<md-select ng-model="cid" ng-required="true">
							<md-option ng-repeat="category in documentsCategories" value="{{category.id}}">
								{{category.title}}
							</md-option>
						</md-select>
					</md-input-container>

				</form>

				<div data-block="documentsUploader">

					<div class="filesList" style="width: 350px; min-height: 70px; float: left;" ng-model="files">

						<div class="lock-size" layout="row" layout-align="left center" style="position: fixed">

							<div style="float: left; width: 70px;" ng-repeat="file in files" ng-if="$index < 5">

								<md-fab-speed-dial
									ng-mouseenter="files[file.hash].isOpen = true"
									ng-mouseleave="files[file.hash].isOpen = false"

									md-open="files[file.hash].isOpen"
									md-direction="down"

									class="md-scale"

									style="width: 70px"
								>

									<md-fab-trigger>
										<md-button aria-label="menu" class="md-fab md-warn"
										           style="background: url('/s/img/thumb/ai/{{file.hash}}')">
										</md-button>
									</md-fab-trigger>

									<md-fab-actions>
										<md-button aria-label="view" class="md-fab md-raised md-mini">
											<md-tooltip md-direction="right">Переглянути</md-tooltip>
											<md-icon class="material-icons" aria-label="Переглянути">zoom_in</md-icon>
										</md-button>

										<md-button aria-label="delete" class="md-fab md-raised md-mini">
											<md-tooltip md-direction="left">Видалити</md-tooltip>
											<md-icon class="material-icons" aria-label="Insert Link">delete_forever
											</md-icon>
										</md-button>
									</md-fab-actions>
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

<div ng-controller="documentsListController">

	<md-list class="md-dense" flex ng-repeat="category in documentsCategories">
		<md-subheader class="md-no-sticky">{{ category.title }}</md-subheader>

		<md-list-item class="md-2-line" ng-repeat="document in documentsList" ng-if="document.cid == category.id">

			<md-icon class="md-avatar-icon" style="font-size: 21px;" aria-label="Переглянути">description</md-icon>

			<div class="md-list-item-text" class="md-offset">
				<h3>{{ document.title }}</h3>
				<p>{{ document.description }}</p>
				<h4>
					<ng-pluralize count="document.files.length" when="filesForms"></ng-pluralize>
				</h4>
			</div>

			<md-button class="md-secondary md-icon-button md-accent" ng-click="viewDocument(document.did)">
				<md-icon class="material-icons" aria-label="Переглянути">visibility</md-icon>
			</md-button>

			<md-button class="md-secondary md-icon-button md-warn" ng-click="deleteDocument(document.did)">
				<md-icon class="material-icons" aria-label="Видалити">delete_forever</md-icon>
			</md-button>

		</md-list-item>

	</md-list>

	<script type="text/ng-template" id="documentsViewerTmpl">
		<md-dialog>

			<md-toolbar>
				<div class="md-toolbar-tools">
					<h2>Перегляд документу</h2>
					<span flex></span>

					<md-button class="md-icon-button" ng-click="cancel()">
						<md-icon aria-label="Закрити">close</md-icon>
					</md-button>
				</div>
			</md-toolbar>

			<md-dialog-content class="p20" style="width: 425px; min-height: 300px">

				<h3>{{ document.title }}</h3>
				<h4>{{ document.description }}</h4>

				<div ng-cloak="" class="virtualRepeatdemoHorizontalUsage">
					<md-content layout="column">

						<md-virtual-repeat-container id="horizontal-container" md-orient-horizontal="">
							<div md-virtual-repeat="file in document.files" class="repeated-item" flex="">

								<img ng-src="/s/img/thumb/ab/{{file.hash}}" img-onload="preloader[file.hash].active = false" style="height: 260px"/>
								<div layout="row" layout-sm="column" layout-align="space-around">
									<md-progress-circular ng-disabled=" ! preloader[file.hash].active" md-diameter="96"></md-progress-circular>
								</div>
							</div>
						</md-virtual-repeat-container>

					</md-content>
				</div>

			</md-dialog-content>

			<md-dialog-actions layout="row">
				<md-button ng-click="cancel()">
					Закрити
				</md-button>
			</md-dialog-actions>

		</md-dialog>
	</script>

	<style type="text/css">
		.virtualRepeatdemoHorizontalUsage #horizontal-container {
			height: 262px;
			width: 100%;
		}

		.virtualRepeatdemoHorizontalUsage .repeated-item {
			border-right: 1px solid #ddd;
			box-sizing: border-box;
			display: inline-block;
			height: 260px;
			text-align: center;
			width: 200px;
		}

		.virtualRepeatdemoHorizontalUsage md-content {
			margin-top: 15px;
		}

		.virtualRepeatdemoHorizontalUsage md-virtual-repeat-container {
			border: solid 1px grey;
		}
	</style>

</div>