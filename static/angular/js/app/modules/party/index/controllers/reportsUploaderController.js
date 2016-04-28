app.controller('reportsUploaderController', function($scope, $http, $mdDialog, reportsService) {
	$scope.files = {};
	$scope.reportsCategories = reportsService.getCategories();

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

					$http.post("/party/save_document", data)
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
