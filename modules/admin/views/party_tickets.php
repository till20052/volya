<div class="headerNew">

	<div>
		<ul class="breadcrumb">
			<li><a href="/admin">Адмін панель</a></li>
			<li class="current">Партійні квитки</li>
		</ul>
	</div>

</div>


<div class="section">
	<div ng-controller="partyTicketsIndexController" ng-cloak="">

		<div class="filter">
			<div layout-gt-sm="row">
				<md-input-container class="md-block" flex-gt-sm>
					<label>Статус</label>
					<md-select ng-model="status">
						<md-option value="custom">Сформувати вручну</md-option>
						<md-option value="new">Тільки нові</md-option>
						<md-option value="generated">Вже згенеровані</md-option>
						<md-option value="all">Всі</md-option>
					</md-select>
				</md-input-container>
			</div>

			<div layout-gt-sm="row" ng-if="status.length > 0" class="mb15">
				<md-autocomplete
					md-no-cache="true"
					md-search-text="searchText"
					md-items="item in autocomplete(searchText)"
					md-item-text="item.first_name + ' ' + item.last_name"
					md-min-length="3"
					placeholder="Почніть вводити ім`я користувача"
					md-selected-item-change="selectItem(item); searchText = ''"
					md-selected-item="selectedItem"
				>

					<md-item-template>
						<span md-highlight-text="searchText" md-highlight-flags="^i">{{ item.first_name + " " + item.last_name }}</span>
					</md-item-template>

					<md-not-found>
						Користувача "{{searchText}}" не знайдено
					</md-not-found>
				</md-autocomplete>
			</div>

			<div layout-gt-sm="row" ng-class="status.length > 0 ? '' : 'hidden'">
				<md-input-container class="md-block m0" flex-gt-sm>
					<md-checkbox class="md-secondary" ng-model="withPhoto">Тільки з фото</md-checkbox>
				</md-input-container>
			</div>

			<div layout-gt-sm="row" ng-class="status.length > 0 ? '' : 'hidden'">
				<md-input-container class="md-block m0" flex-gt-sm>
					<md-checkbox class="md-secondary" ng-model="withGeo">Тільки з вказаним населеним пунктом</md-checkbox>
				</md-input-container>
			</div>

			<div layout-gt-sm="row" class="description" ng-if="status.length > 0">
				<b class="cred">Червоним кольором</b> відмічені користувачи, у яких не вказано население пункт. Для них партквитки будуть згенеровані некоректно
			</div>
		</div>

		<div class="toolbar">
			<md-button ng-disabled="checkedUsers.length == 0" class="md-raised md-warn" ng-click="deleteChecked()" style="margin-left: 0">Видалити (<b>{{ checkedUsers.length }}</b>)</md-button>
			<md-button ng-disabled=" ! canGenerate" class="md-raised md-primary" ng-click="generate()">Згенерувати (<b>{{ usersCount }}</b>)</md-button>

			<md-input-container class="md-block numOnPage">
				<label>К-ть на сторінку</label>
				<input type="number" min="1" max="100" ng-model="pageSize" />
			</md-input-container>

		</div>

		<div class="list">

			<div class="preloader preloadList hidden" ng-class=" ! preloadList ? 'hidden' : ''"></div>

				<md-virtual-repeat-container id="usersList">

					<md-list-item dir-paginate="user in usersList | itemsPerPage: pageSize" current-page="currentPage" class="user" ng-class=" ! user.geo_koatuu_code ? 'disabled' : ''">
						<img ng-src="{{ 'http://volya.ua/s/img/thumb/ab/' + user.avatar }}" ng-if="user.avatar" class="md-avatar" />
						<img ng-src="http://volya.ua/img/no_image.jpg" ng-if=" ! user.avatar" class="md-avatar" />

						<p>{{ user.first_name + " " + user.last_name }}</p>
						<md-checkbox class="md-secondary" checklist-model="checkedUsers" checklist-value="user.id"></md-checkbox>
						<md-icon class="md-icon md-secondary md-hue-3" ng-click="deleteUser(user.id)">delete_forever</md-icon>
					</md-list-item>

					<md-list-item ng-if=" ! canGenerate" class="user">
						<p>Немає жодного запису</p>
					</md-list-item>

				</md-virtual-repeat-container>

			<div class="text-center paginationBlock">

				<script type="text/ng-template" id="paginationTpl">

					<div class="paginationBody" ng-if="1 < pages.length || ! autoHide">
						<div ng-if="boundaryLinks" ng-click="setCurrent(pagination.current - 1)" class="arrow">
							<a href="" ng-class="{ disabled : pagination.current == 1 }">
								<i class="icon-fastleft"></i>
							</a>
						</div>

						<div ng-if="directionLinks" ng-click="setCurrent(1)" class="arrow">
							<a href="" ng-class="{ disabled : pagination.current == 1 }">
								<i class="icon-chevron-left"></i>
							</a>
						</div>

						<div>
							<ul>
								<li ng-repeat="pageNumber in pages track by tracker(pageNumber, $index)" ng-class="{ active : pagination.current == pageNumber, disabled : pageNumber == '...' }">
									<a href="" ng-click="setCurrent(pageNumber)">{{ pageNumber }}</a>
								</li>
							</ul>
						</div>

						<div ng-if="directionLinks" ng-click="setCurrent(pagination.current + 1)" class="arrow">
							<a href="" ng-class="{ disabled : pagination.current == pagination.last }">
								<i class="icon-chevron-right"></i>
							</a>
						</div>

						<div ng-if="boundaryLinks" ng-click="setCurrent(pagination.last)" class="arrow">
							<a href="" ng-class="{ disabled : pagination.current == pagination.last }">
								<i class="icon-fastright"></i>
							</a>
						</div>
					</div>

				</script>

				<dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)" template-url="paginationTpl"></dir-pagination-controls>
			</div>
		</div>

		</div>

		<script type="text/ng-template" id="progressDialog.tmpl">
			<md-dialog ng-cloak class="progressDialog">
				<form>
					<md-toolbar>
						<div class="md-toolbar-tools">
							<h2>Прогрес генерації</h2>
							<span flex></span>
							<md-button class="md-icon-button" ng-click="cancel()">
								<md-icon class="md-icon">close</md-icon>
							</md-button>
						</div>
					</md-toolbar>
					<md-dialog-content>
						<div class="md-dialog-content">

							<div layout-gt-sm="row">

								<div flex="45">
									<p class="mt0 cgray taright pr10" ng-class="progress.generationUsersList ? 'completed' : ''">Генерація списків членів</p>
								</div>
								<div flex="55">
									<md-progress-circular class="md-hue-2" style="margin-left: 2px" md-diameter="15px" ng-if=" ! progress.generationUsersList"></md-progress-circular>
									<md-icon class="cgreen md-icon fs20" ng-if="progress.generationUsersList">check_circle</md-icon>
								</div>
							</div>

							<div layout-gt-sm="row">

								<div flex="45">
									<p class="mt0 cgray taright pr10" ng-class="progress.generationPhotos == 100 ? 'completed' : ''">Завантаження фотографій</p>
								</div>
								<div flex="55">

									<md-progress-linear md-mode="determinate" class="md-warn mt5" value="{{progress.generationPhotos}}" ng-if="progress.generationPhotos < 100 && progress.generationPhotos > 0"></md-progress-linear>

									<md-progress-circular class="md-hue-2" style="margin-left: 2px" md-diameter="15px" ng-if="progress.generationPhotos == 0"></md-progress-circular>

									<md-icon class="cgreen md-icon fs20" ng-if="progress.generationPhotos == 100">check_circle</md-icon>
								</div>
							</div>

							<div layout-gt-sm="row">

								<div flex="45">
									<p class="mt0 cgray taright pr10" ng-class="progress.generationBarcodes == 100 ? 'completed' : ''">Генерація штрихкодів</p>
								</div>
								<div flex="55">

									<md-progress-linear md-mode="determinate" class="md-warn mt5" value="{{progress.generationBarcodes}}" ng-if="progress.generationBarcodes < 100 && progress.generationBarcodes > 0"></md-progress-linear>

									<md-progress-circular class="md-hue-2" style="margin-left: 2px" md-diameter="15px" ng-if="progress.generationBarcodes == 0"></md-progress-circular>

									<md-icon class="cgreen md-icon fs20" ng-if="progress.generationBarcodes == 100">check_circle</md-icon>
								</div>
							</div>

							<div layout-gt-sm="row">

								<div flex="45">
									<p class="mt0 cgray taright pr10" ng-class="progress.generationZip ? 'completed' : ''">Формування архіву</p>
								</div>
								<div flex="55">
									<md-progress-circular class="md-hue-2" style="margin-left: 2px" md-diameter="15px" ng-if=" ! progress.generationZip"></md-progress-circular>

									<md-icon class="cgreen md-icon fs20" ng-if="progress.generationZip">check_circle</md-icon>
								</div>
							</div>

						</div>
					</md-dialog-content>
					<md-dialog-actions layout="row">
						<md-button ng-disabled=" ! progress.generationZip" ng-click="downloadPackage()" class="md-primary" style="margin-right:20px;">
							Завантажити
						</md-button>
					</md-dialog-actions>
				</form>
			</md-dialog>
		</script>

	</div>
</div>