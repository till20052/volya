var Uploader = (function(data){
	/**
	 * Private methods
	 */
	
	/**
	 * Public fields
	 */
	this.element = element;
	
	/**
	 * Private methods
	 */
	
	/**
	 * Initialize function
	 * @returns void
	 */
	(function(){
		$("<input type=\"file\" name=\"file\" />").fileupload({
			dataType: "json"
		});
	}());
	
	return this;
});