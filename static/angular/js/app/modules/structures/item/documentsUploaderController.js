app.controller('documentsUploaderController', function($scope, $http, $mdDialog, $timeout) {

	$http.get("get_documents_categories").success(function(data){
		$scope.documentsCategories = data.categories;
	});

	$http.post("get_structure_documents", {sid: $scope.sid}).success(function(data){
		$scope.documentsList = data.documents;
	});

	$scope.documents = {};

	$scope.openDocumentsUploadDialog = function(event) {
		$mdDialog.show({
			clickOutsideToClose: true,
			scope: $scope,
			targetEvent: event,
			preserveScope: true,
			templateUrl: 'documentsUploaderTmpl',
			local: {
				files: $scope.files
			},
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
						category: $scope.category,
						files: (function(){
							var files = [];

							for(doc in $scope.documents) {
								files.push(doc);
							}

							return files;
						})()
					};

					$http.post("/structures/save_document", data)
						.then(
							function(){
								clearForm();
								$mdDialog.cancel();
							},
							function(){
								console.log( 'err' );
							}
						);
				};

				$scope.addFile = function (hash) {
					$scope.documents[hash] = {
						hash: hash,
						isOpen: false,
						tooltipVisible: false
					};
				};

				function clearForm() {
					$scope.documents = {};
					delete $scope.sid;
					delete $scope.title;
					delete $scope.description;
					delete $scope.category;
				}

			},
			onComplete: function($scope) {

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

							$scope.addFile(data.result.files[0]);

							$("#docTitle").focus();
						})
					});
				})($("div[data-block='documentsUploader']"));

			}
		});
	};
});


// $scope.$watch($scope.documents[hash].isOpen, function(isOpen) {
//
// 	if (isOpen) {
// 		$timeout(function() {
// 			$scope.documents[hash].tooltipVisible = isOpen;
// 		}, 500);
// 	} else {
// 		$scope.documents[hash].tooltipVisible = isOpen;
// 	}
// });