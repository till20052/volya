app
	.controller('reportsListController', function($scope, $sce, $http, $mdDialog, reportsService) {

		$http.get("get_reports_categories").success(function(data){
			$scope.documentsCategories = reportsService.setCategories(data.categories);
		});

		$http.post("get_reports_documents", {sid: $scope.sid}).success(function(data){
			$scope.documentsList = reportsService.setDocuments(data.documents);
		});

		$scope.$on("changeDocuments", function(event, data) {
			$scope.documentsList = data;
		});

		$scope.viewDocument = function(id) {
			$mdDialog.show({
				clickOutsideToClose: true,
				templateUrl: 'reportViewerTmpl',
				locals: {
					document: reportsService.getDocument(id)
				},
				controller: function DialogController($scope, $http, $mdDialog, document) {
					$scope.document = document;

					$scope.hide = function () {
						$mdDialog.hide();
					};

					$scope.cancel = function () {
						$mdDialog.cancel();
					};
				}
			});
		};

		$scope.deleteDocument = function(id) {
			var confirm = $mdDialog.confirm()
				.title('Ви дійсно бажаєте видалити цей документ ?')
				.textContent('Всі файли які завантажені в цей документ також будуть видалені.')
				.ok('Видалити')
				.cancel('Відміна');
			$mdDialog.show(confirm).then(function() {

				$http.post("/party/delete_document", { id: id}).success(function(){
					reportsService.removeDocument(id);
				});
			});
		};
	});