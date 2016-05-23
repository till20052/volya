app
	.controller("partyTicketsIndexController", function($scope, $http, $interval, $mdDialog, partyTicketsService) {
		var withoutPhotos = {};
		var withoutGeo = {};

		$scope.usersList = {};
		$scope.checkedUsers = [];
		$scope.canGenerate = false;
		$scope.usersCount = 0;
		$scope.progress = {};

		$scope.currentPage = 1;
		$scope.pageSize = 15;

		$scope.$on("changeUsersList", function(event, data) {
			$scope.usersList = data;
			$scope.usersCount = Object.keys($scope.usersList).length;

			$scope.canGenerate = (Object.keys($scope.usersList).length !== 0);
		});

		$scope.$watch("status", function(status){

			if( typeof status != "undefined" ){
				$scope.preloadList = true;

				setTimeout(function(){

					switch (status) {
						case "new":
							partyTicketsService.showNewUsers();
							$scope.preloadList = false;
							break;

						case "generated":
							partyTicketsService.showGeneratedUsers();
							$scope.preloadList = false;
							break;

						case "all":
							partyTicketsService.showAllUsers();
							$scope.preloadList = false;
							break;

						default:
							partyTicketsService.clearUsers();
							$scope.preloadList = false;
							break;
					}

				}, 100);
			}
		});

		$scope.$watch("withPhoto", function(state){

			if(state) {
				$.each($scope.usersList, function(n, user){
					if( ! user.avatar){
						withoutPhotos[user.id] = user;
						partyTicketsService.deleteUser(user.id);
					}
				});
			} else
				$.each(withoutPhotos, function(n, user){
					if($scope.withGeo && ! user.geo_koatuu_code)
						return;

					if( ! partyTicketsService.getUser(user.id))
						partyTicketsService.addUser(user);
				});
		});

		$scope.$watch("withGeo", function(state){

			if(state) {
				$.each($scope.usersList, function(n, user){
					if( ! user.geo_koatuu_code){
						withoutGeo[user.id] = user;
						partyTicketsService.deleteUser(user.id);
					}
				});
			} else
				$.each(withoutGeo, function(n, user){
					if($scope.withPhoto && ! user.avatar)
						return;

					if( ! partyTicketsService.getUser(user.id))
						partyTicketsService.addUser(user);
				});
		});

		$scope.deleteUser = function(uid) {
			var confirm = $mdDialog.confirm()
				.title('Ви дійсно бажаєте видалити цього користувача ?')
				.textContent('Він буде видалений тільки для цієї генерації.')
				.ok('Видалити')
				.cancel('Відміна');
			$mdDialog.show(confirm).then(function() {
				partyTicketsService.deleteUser(uid);
			});
		};

		$scope.deleteChecked = function() {
			var confirm = $mdDialog.confirm()
				.title('Ви дійсно бажаєте видалити виділених користувачів ?')
				.textContent('Вони буде видалений тільки для цієї генерації.')
				.ok('Видалити')
				.cancel('Відміна');
			$mdDialog.show(confirm).then(function() {

				$.each($scope.checkedUsers, function(n, uid){
					partyTicketsService.deleteUser(uid);
				});

				$scope.checkedUsers = [];
			});
		};

		$scope.autocomplete = function(query) {
			var list = partyTicketsService.getAutocompleteList();

			return query ? list.filter( createFilterFor(query) ) : list;
		};

		$scope.selectItem = function(user) {
			if( typeof user != 'undefined'){

				if($scope.withPhoto && ! user.avatar){
					withoutPhotos[user.id] = user;

					return;
				}

				if($scope.withGeo && ! user.geo_koatuu_code){
					withoutPhotos[user.id] = user;

					return;
				}

				partyTicketsService.addUser(user);
			}
		};

		$scope.showWindow = function() {

			$mdDialog.show({
				templateUrl: 'progressDialog.tmpl',
				scope: $scope,
				targetEvent: event,
				preserveScope: true
			});
		};
		
		$scope.generate = function(){

			$mdDialog.show({
				templateUrl: 'progressDialog.tmpl',
				scope: $scope,
				targetEvent: event,
				preserveScope: true,

				controller: function($scope, $mdDialog) {
					var usersList = partyTicketsService.getIdsList();

					$scope.progress.generationUsersList = false;
					$scope.progress.generationPhotos = 0;
					$scope.progress.generationBarcodes = 0;
					$scope.progress.generationExcel = 0;
					$scope.progress.generationZip = 0;

					$http.post("party_tickets/generate_users_list", {usersList: usersList}).success(function(){
						$scope.progress.generationUsersList = true;

						var count = Math.ceil(usersList.length / 10);
						var fileName = "";
						var percents = 100 / count;
						var iP = 1,
							iB = 1;

						var genPhotos = function() {
							$http.post(
								"party_tickets/generate_photos",
								{
									usersList: usersList.splice(0, 10)
								}
							).success(function(){

								if( iP * percents < 100 ) {
									$scope.progress.generationPhotos = iP * percents;
									iP++;
									genPhotos();
								} else{
									$scope.progress.generationPhotos = 100;
									usersList = partyTicketsService.getIdsList();
									genBarcodes();
								}
							});
						};

						var genBarcodes = function() {
							$http.post(
								"party_tickets/generate_barcodes",
								{
									usersList: usersList.splice(0, 10)
								}
							).success(function(){

								if( iB * percents < 100 ) {
									$scope.progress.generationBarcodes = iB * percents;
									iB++;
									genBarcodes();
								} else{
									$scope.progress.generationBarcodes = 100;
									usersList = partyTicketsService.getIdsList();
									genZip();
								}
							});
						};

						var genZip = function() {
							$http.get("party_tickets/generate_zip").success(function(data){
								$scope.progress.generationZip = true;
								fileName = data.fileName;
							});
						};

						genPhotos();

						$scope.hide = function() {
							$mdDialog.hide();
						};

						$scope.cancel = function() {
							$mdDialog.cancel();
						};

						$scope.downloadPackage = function() {
							$("body").append("<iframe src='/admin/party_tickets/download_package?file=" + fileName + "' style='display: none;' ></iframe>");
						}
					});
				}
			});
		}

	});

function createFilterFor(query) {
	var lowercaseQuery = angular.lowercase(query);

	return function filterFn(state) {
		state = angular.lowercase(state.first_name + " " + state.last_name);

		return (state.indexOf(lowercaseQuery) > -1);
	};
}