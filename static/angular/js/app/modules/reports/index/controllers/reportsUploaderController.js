app.controller('reportsUploaderController', function($scope, $http, $mdDialog, reportsService) {
	$scope.files = {};
	$scope.reportsCategories = reportsService.getCategories();

	$scope.$on("changeCategories", function(event, data) {
		$scope.reportsCategories = data;
	});

	$scope.openReportsCategoriesDialog = function(event) {
		$mdDialog.show({
			clickOutsideToClose: true,
			scope: $scope,
			targetEvent: event,
			preserveScope: true,
			templateUrl: 'reportCategoriesTmpl',
			controller: function ($scope, $mdDialog) {

				$scope.hide = function () {
					$mdDialog.hide();
				};

				$scope.cancel = function () {
					$mdDialog.cancel();
				};

				$scope.editFlag = {};
				$scope.edit = function(cid) {

					if(typeof $scope.editFlag[cid] == "undefined")
						$scope.editFlag[cid] = false;

					$scope.editFlag[cid] = ! $scope.editFlag[cid];

					if( ! $scope.editFlag[cid]) {

						if(
							($scope.reportsCategories[cid]["title"] == $scope.reportsCategories[cid]["newTitle"])
							|| (typeof $scope.reportsCategories[cid]["newTitle"] == "undefined")
							|| ($scope.reportsCategories[cid]["newTitle"].length == 0)
						)
							return;

						$scope.reportsCategories[cid]["title"] = $scope.reportsCategories[cid]["newTitle"];
						delete $scope.reportsCategories[cid]["newTitle"];

						reportsService.saveCategory($scope.reportsCategories[cid]);
						
						$http.post("/admin/reports/save_category", {data: $scope.reportsCategories[cid]}).success(function(){
							console.log("Ok");
						});
					}
					else
						$scope.edit[cid]
				};

				$scope.add = function() {
					$http.post("/admin/reports/add_category", {
						title: $scope.newCategoryTitle
					}).success(function(data){
						if(data.success)
							reportsService.addCategory(data.category);
						
						$scope.newCategoryTitle = "";
					});
				};
				
				$scope.deleteCategory = function(cid) {
					$http.post("/admin/reports/remove_category", {cid: cid}).success(function(){
						reportsService.removeCategory(cid);
					});
				}
			}
		});
	};

	$scope.openReportsDialog = function(event) {
		$mdDialog.show({
			clickOutsideToClose: true,
			scope: $scope,
			targetEvent: event,
			preserveScope: true,
			templateUrl: 'reportsDialogTmpl',
			controller: function DialogController($scope, $http, $mdDialog) {

				$scope.hide = function () {
					$mdDialog.hide();
				};

				$scope.cancel = function () {
					clearForm();
					$mdDialog.cancel();
				};

				$scope.openFileBrowser = function () {
					$("#fileInput").click();
				};

				$scope.save = function () {

					var data = {
						sid: $scope.sid,
						title: $scope.title,
						description: $scope.description,
						cid: $scope.cid,
						files: (function(){
							var files = [];

							for(doc in reportsService.getFiles())
								files.push(doc);

							return files;
						})()
					};

					$http.post("/admin/reports/save_document", data)
						.then(
							function(res){
								data.id = res.data.id;
								reportsService.addDocument(data);

								clearForm();
								$mdDialog.cancel();
							},
							function(){
								console.log( 'err' );
							}
						);
				};

				function clearForm() {

					reportsService.clearFiles();

					delete $scope.sid;
					delete $scope.title;
					delete $scope.description;
					delete $scope.cid;
					$scope.files = {};
				}

			},
			onComplete: function() {

				(function(element){
					var __uploaderUiBox = $(">div[data-uiBox='uploader']", element);

					$(">input", __uploaderUiBox).fileupload({
						dataType: "json",
						url: "/s/storage/j_save?extension[]=jpg&extension[]=jpeg&extension[]=pdf&extension[]=png",
						sequentialUploads: true,
						done: (function(event, data){
							if( ! data.result.files[0]){
								alert("Файл, який ви завантажуєте, не підтримується");
								return;
							}

							var hash = data.result.files[0];

							$scope.files[hash] = reportsService.addFile(hash);

							$("#reportTitle").focus();
						})
					});
				})($("div[data-block='documentsUploader']"));

			}
		});
	};
});
