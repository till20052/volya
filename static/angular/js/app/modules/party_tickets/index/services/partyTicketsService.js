app.factory('partyTicketsService', ['$rootScope', '$http', function($rootScope, $http) {
	var usersList = {};
	var newUsers = {};
	var generatedUsers = {};
	var autocompleteList = {};

	$http.get("party_tickets/get_users_list/new").success(function(data){
		newUsers = data.users;

		setAutocompleteList(newUsers);
	});

	$http.get("party_tickets/get_users_list/generated").success(function(data){
		generatedUsers = data.users;

		setAutocompleteList(generatedUsers);
	});

	function setAutocompleteList(data) {
		$.each(data, function(n, user){
			addToAutocomplete(user);
		});
	}

	function deleteFromAutocomplete(user) {
		delete autocompleteList[user.id];
	}

	function addToAutocomplete(user) {
		autocompleteList[user.id] = user;
	}

	function getAutocompleteList() {
		var list = [];

		$.each(autocompleteList, function(n, user){
			list.push(user);
		});

		return list;
	}

	function setUsers(data) {
		$.each(data, function(n, user){
			usersList[user.id] = user;

			deleteFromAutocomplete(user);
		});

		$rootScope.$broadcast('changeUsersList', usersList);
	}

	function addUser(user) {
		usersList[user.id] = user;

		deleteFromAutocomplete(user);

		$rootScope.$broadcast('changeUsersList', usersList);
	}

	function getUser(uid) {
		if(usersList[uid])
			return usersList[uid];

		return false;
	}

	function showNewUsers() {
		usersList = {};
		setUsers(newUsers);

		$rootScope.$broadcast('changeUsersList', usersList);
	}

	function showGeneratedUsers() {
		usersList = {};
		setUsers(generatedUsers);

		$rootScope.$broadcast('changeUsersList', usersList);
	}

	function showAllUsers() {
		usersList = {};
		setUsers(newUsers);
		setUsers(generatedUsers);

		$rootScope.$broadcast('changeUsersList', usersList);
	}

	function getIdsList() {
		var list = [];

		$.each(usersList,function(n, user){
			list.push(user.id);
		});

		return list;
	}

	function clearUsers() {
		usersList = {};
		setAutocompleteList(newUsers);
		setAutocompleteList(generatedUsers);

		$rootScope.$broadcast('changeUsersList', usersList);
	}

	function deleteUser(uid) {
		addToAutocomplete(usersList[uid]);
		delete usersList[uid];

		$rootScope.$broadcast('changeUsersList', usersList);
	}

	return {
		setUsers: setUsers,
		addUser: addUser,
		showNewUsers: showNewUsers,
		showGeneratedUsers: showGeneratedUsers,
		showAllUsers: showAllUsers,
		clearUsers: clearUsers,
		deleteUser: deleteUser,
		getUser: getUser,

		getIdsList: getIdsList,

		getAutocompleteList: getAutocompleteList,
	};

}]);