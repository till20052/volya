app
	.controller('reportsViewController', function($scope, $http, $mdDialog, reportsService) {

		$http.get("/admin/reports/get_reports_categories").success(function(data){
			$scope.documentsCategories = reportsService.setCategories(data.categories);
		});

		$http.post("/admin/reports/get_reports_documents", {sid: $scope.sid}).success(function(data){
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
	});