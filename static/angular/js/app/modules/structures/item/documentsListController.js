app
	.controller('ListMembers', function($scope, $http) {
		$scope.go = function ( uid ) {
			window.open('/profile/' + uid , '_blank');
		};

		$http.post("get_structure_members", {sid: $scope.sid}).success(function(data){
			$scope.todos = data.members;
		});
	})