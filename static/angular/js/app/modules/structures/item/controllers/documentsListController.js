app
	.controller('documentsListController', function($scope, $http, $mdDialog, documentsService) {

		$http.get("get_documents_categories").success(function(data){
			$scope.documentsCategories = documentsService.setCategories(data.categories);
		});

		$http.post("get_structure_documents", {sid: $scope.sid}).success(function(data){
			$scope.documentsList = documentsService.setDocuments(data.documents);

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

		$scope.$on("changeDocuments", function(event, data) {
			$scope.documentsList = data;
		});

		$scope.viewDocument = function(id) {
			$mdDialog.show({
				clickOutsideToClose: true,
				templateUrl: 'documentsViewerTmpl',
				locals: {
					document: documentsService.getDocument(id)
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

				$http.post("/structures/delete_document", { did: id}).success(function(){
					documentsService.removeDocument(id);
				});

			});
		};

	})

	.directive('imgOnload', function() {
		return {
			restrict: 'A',
			link: function($scope, element, attrs) {

				element.bind('load', function() {
					$scope.$apply(attrs.imgOnload);
				});
			}
		};
	});