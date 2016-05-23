app
	.controller('reportsViewController', function($scope, $http, $mdDialog, reportsService) {

		$http.get("/party/get_reports_categories").success(function(data){
			$scope.documentsCategories = reportsService.setCategories(data.categories);
		});

		$http.post("/party/get_reports_documents", {sid: $scope.sid}).success(function(data){
			$scope.documentsList = reportsService.setDocuments(data.documents);
		});

		$scope.$on("changeDocuments", function(event, data) {
			$scope.documentsList = data;
		});

		$scope.viewDocument = function(hash) {
			window.open('/s/storage/' + hash, '_blank');
		};
	});