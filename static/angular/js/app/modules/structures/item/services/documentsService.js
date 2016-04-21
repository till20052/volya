app.factory('documentsService', ['$rootScope', function($rootScope) {
	var documents = {};
	var files = {};
	var categories = {};

	function addDocument (data) {
		documents[data.did] = data;

		$rootScope.$broadcast('addDocument', data);
	}

	function getDocuments () {
		return documents;
	}

	function removeDocument (hash) {
		delete documents[hash];

		if( ! documents[hash])
			return true;
		else
			return false;
	}

	function clearDocuments() {
		documents = {};
	}

	function clearFiles () {
		files = {};
	}

	function addFile (hash) {
		return files[hash] = {
			hash: hash,
			isOpen: false,
			tooltipVisible: false
		};
	}

	function getFile (hash) {
		return files[hash];
	}

	function getFiles () {
		return files;
	}

	function setCategories (data) {
		$(data).each(function(i, val){
			categories[val.id] = val;
		});

		return categories;
	}

	function setDocuments (data) {
		$(data).each(function(i, val){
			addDocument(val);
		});

		return documents;
	}

	function addCategory (data) {
		return categories[data.id] = data;
	}

	function getCategories () {
		return categories;
	}

	return {
		setDocuments: setDocuments,
		addDocument: addDocument,
		getDocuments: getDocuments,
		removeDocument: removeDocument,
		clearDocuments: clearDocuments,
		clearFiles: clearFiles,
		addFile: addFile,
		getFile: getFile,
		getFiles: getFiles,
		setCategories: setCategories,
		addCategory: addCategory,
		getCategories: getCategories
	}
}]);