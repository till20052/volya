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
						<label><?=t("Назва документу")?></label>
						<input required="" md-maxlength="30" name="title" id="docTitle" ng-model="title">
						<div ng-messages="documentInfo.title.$error">
							<div ng-message="required">Це поле обов'язкове</div>
							<div ng-message="md-maxlength">Назва документу не може бути довшою за 30 символів</div>
						</div>
					</md-input-container>

					<md-input-container class="md-block">
						<label><?=t("Опис")?></label>
						<input md-maxlength="150" md-no-asterisk name="description" ng-model="description">

						<div ng-messages="documentInfo.description.$error">
							<div ng-message="md-maxlength">Назва документу не може бути довшою за 150 символів</div>
						</div>
					</md-input-container>

					<md-input-container class="md-block">
						<label>Категорія</label>

						<md-select ng-model="category" ng-required="true">
							<md-option ng-repeat="category in documentsCategories" value="{{category.id}}">
								{{category.title}}
							</md-option>
						</md-select>
					</md-input-container>

				</form>

				<div data-block="documentsUploader">

					<div class="filesList" style="width: 350px; min-height: 70px; float: left;" ng-model="files">

						<div class="lock-size" layout="row" layout-align="left center" style="position: fixed">

							<div style="float: left; width: 70px;" ng-repeat="file in documents" ng-if="$index < 5">

								<md-fab-speed-dial
									ng-mouseenter="documents[file.hash].isOpen = true"
									ng-mouseleave="documents[file.hash].isOpen = false"

									md-open="documents[file.hash].isOpen"
									md-direction="down"

									class="md-scale"

									style="width: 70px"
								>

									<md-fab-trigger>
										<md-button aria-label="menu" class="md-fab md-warn" style="background: url('/s/img/thumb/ai/{{file.hash}}')">
										</md-button>
									</md-fab-trigger>

									<md-fab-actions>
										<md-button aria-label="view" class="md-fab md-raised md-mini">
											<md-tooltip md-direction="right">Переглянути</md-tooltip>
											<md-icon class="material-icons" aria-label="Переглянути">zoom_in</md-icon>
										</md-button>

										<md-button aria-label="delete" class="md-fab md-raised md-mini">
											<md-tooltip md-direction="left">Видалити</md-tooltip>
											<md-icon class="material-icons" aria-label="Insert Link">delete_forever</md-icon>
										</md-button>
									</md-fab-actions>
								</md-fab-speed-dial>

							</div>
						</div>
					</div>

					<div data-uiBox="uploader" class="mt5" layout-align="center">

						<md-button class="md-fab md-primary" aria-label="Profile" ng-click="openFileBrowser()">
							<md-icon class="material-icons" aria-label="Edit">get_app</md-icon>
						</md-button>

						<input id="fileInput" type="file" name="file" multiple="true" style="display: none" />
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



</div>

<?// $categories = $structure["documents"]["categories"]; unset($structure["documents"]["categories"]) ?>
<!---->
<?// foreach ($categories as $category) { ?>
<!---->
<!--	--><?// if(count($structure["documents"]) > 0){ ?>
<!--		<div class="categoty_title">-->
<!--			<h3>--><?//=$category["title"]?><!--</h3>-->
<!--		</div>-->
<!---->
<!--		--><?// foreach ($structure["documents"] as $document) { ?>
<!---->
<!--			<div data-ui="document" data-type="galery" data-src="/s/storage/--><?//=$document["hash"]?><!--">-->
<!--				<i class="icon icon-document"></i>-->
<!--				--><?//=$document["title"]?>
<!--			</div>-->
<!---->
<!--		--><?// } ?>
<!--	--><?// } else{ ?>
<!--		<h3>--><?//=t("Ще немає жодного рішення")?><!--</h3>-->
<!--	--><?// } ?>
<?// } ?>
<!---->
<!--<div class="cboth"></div>-->