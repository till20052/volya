app
	.controller('documentsListController', function($scope, $http, documentsService) {

		$http.get("get_documents_categories").success(function(data){
			$scope.documentsCategories = documentsService.setCategories(data.categories);
		});

		$http.post("get_structure_documents", {sid: $scope.sid}).success(function(data){
			$scope.documentsList = documentsService.setDocuments(data.documents);

			$scope.$on("addDocument", function(event, data) {
				$scope.documentsList[data.did] = data;
			});

			$scope.filesForms = {
				0: 'Файлів немає',
				1: '{} файл',
				2: '{} файли',
				3: '{} файли',
				4: '{} файли',
				5: '{} файлів',
				6: '{} файлів',
				7: '{} файлів',
				8: '{} файлів',
				9: '{} файлів',
				10: '{} файлів',
				11: '{} файлів',
				12: '{} файлів',
				13: '{} файлів',
				14: '{} файлів',
				15: '{} файлів',
				16: '{} файлів',
				17: '{} файлів',
				other: '{} файли'
			};
		});
	});