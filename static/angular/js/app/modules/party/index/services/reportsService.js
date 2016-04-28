app.factory('reportsService', ['$rootScope', function($rootScope) {
	var documents = {};
	var files = {};
	var categories = {};

	function setDocuments (data) {
		$(data).each(function(i, val){
			addDocument(val);
		});

		$rootScope.$broadcast('changeDocuments', documents);

		return documents;
	}

	function addDocument (data) {
		documents[data.id] = data;

		$rootScope.$broadcast('changeDocuments', documents);
	}

	function getDocuments () {
		return documents;
	}

	function getDocument (id) {
		return documents[id];
	}

	function removeDocument (id) {
		delete documents[id];

		$rootScope.$broadcast('changeDocuments', documents);

		if( ! documents[id])
			return true;
		else
			return false;
	}

	function clearDocuments() {
		documents = {};

		$rootScope.$broadcast('changeDocuments', documents);
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

	function removeFile (hash) {
		delete files[hash];

		if( ! files[hash])
			return true;
		else
			return false;
	}


	function setCategories (data) {
		$(data).each(function(i, val){
			categories[val.id] = val;
		});

		return categories;
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
		getDocument: getDocument,
		removeDocument: removeDocument,
		clearDocuments: clearDocuments,

		clearFiles: clearFiles,
		addFile: addFile,
		getFile: getFile,
		getFiles: getFiles,
		removeFile: removeFile,
		
		setCategories: setCategories,
		addCategory: addCategory,
		getCategories: getCategories
	}
}]);