app
	.controller('reportsListController', function($scope, $http, $mdDialog, reportsService) {

		$http.get("/admin/reports/get_reports_categories").success(function(data){
			$scope.documentsCategories = reportsService.setCategories(data.categories);
		});

		$http.post("/admin/reports/get_reports_documents", {sid: $scope.sid}).success(function(data){
			$scope.documentsList = reportsService.setDocuments(data.documents);
		});

		$scope.viewDocument = function(hash) {
			window.open('/s/storage/' + hash, '_blank');
		};

		$scope.deleteDocument = function(id) {
			var confirm = $mdDialog.confirm()
				.title('Ви дійсно бажаєте видалити цей документ ?')
				.textContent('Всі файли які завантажені в цей документ також будуть видалені.')
				.ok('Видалити')
				.cancel('Відміна');
			$mdDialog.show(confirm).then(function() {

				$http.post("/admin/reports/delete_document", { id: id}).success(function(){
					reportsService.removeDocument(id);
				});
			});
		};
	});