var app = angular.module('StructuresApp', ['ngMaterial', 'flow']);

app.controller('ListMembers', function($scope, $http) {
	$scope.imagePath = 'http://volya.ua/s/img/thumb/ai/c07827f960558a090cf18f7abfc2a822';

	$scope.go = function ( uid ) {
		window.open('/profile/' + uid , '_blank');
	};

	(function(){
		$http.get("get_structure_members?geo=3200000000").success(function(data){
			$scope.todos = data.members;
		});
	})();

});

app.controller('UploadDocument', function($scope, $mdDialog, $mdMedia) {
	$scope.status = '  ';
	// $scope.customFullscreen = $mdMedia('xs') || $mdMedia('sm');

	$scope.showFileUploader = function(ev) {
		// var useFullScreen = ($mdMedia('sm') || $mdMedia('xs'))  && $scope.customFullscreen;
		$mdDialog.show({
				controller: DialogController,
				templateUrl: '/structures/show_file_uploader',
				parent: angular.element(document.body),
				targetEvent: ev,
				clickOutsideToClose: true,
				fullscreen: false // useFullScreen
			})
			.then(function(answer) {
				$scope.status = 'You said the information was "' + answer + '".';
			}, function() {
				$scope.status = 'You cancelled the dialog.';
			});
		$scope.$watch(function() {
			return $mdMedia('xs') || $mdMedia('sm');
		}, function(wantsFullScreen) {
			$scope.customFullscreen = (wantsFullScreen === true);
		});
	};

	$scope.getImages = function(){
		
	}
});

function DialogController($scope, $mdDialog) {
	$scope.hide = function() {
		$mdDialog.hide();
	};
	$scope.cancel = function() {
		$mdDialog.cancel();
	};
	$scope.answer = function(answer) {
		$mdDialog.hide(answer);
	};
}