app.controller('documentsUploaderController', function($scope, $http, $mdDialog, documentsService) {
	$scope.files = {};
	$scope.documentsCategories = documentsService.getCategories();

	$scope.openDocumentsUploadDialog = function(event) {
		$mdDialog.show({
			clickOutsideToClose: true,
			scope: $scope,
			targetEvent: event,
			preserveScope: true,
			templateUrl: 'documentsUploaderTmpl',
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

							for(doc in documentsService.getFiles())
								files.push(doc);

							return files;
						})()
					};

					$http.post("/structures/save_document", data)
						.then(
							function(res){
								data.did = res.data.did;
								documentsService.addDocument(data);

								clearForm();
								$mdDialog.cancel();
							},
							function(){
								console.log( 'err' );
							}
						);
				};

				function clearForm() {

					documentsService.clearFiles();

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
						url: "/s/img/j_save?extension[]=jpg&extension[]=jpeg&extension[]=png",
						sequentialUploads: true,
						done: (function(event, data){
							if( ! data.result.files[0]){
								alert("Файл, який ви завантажуєте, не підтримується");
								return;
							}

							var hash = data.result.files[0];

							$scope.files[hash] = documentsService.addFile(hash);

							$("#docTitle").focus();
						})
					});
				})($("div[data-block='documentsUploader']"));

			}
		});
	};
});