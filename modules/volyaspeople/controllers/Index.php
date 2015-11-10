<?php

Loader::loadModule("VolyasPeople");

class IndexVolyasPeopleController extends VolyasPeopleController
{
	public function execute()
	{
		parent::execute();
		parent::loadFileupload(true);
		parent::loadWindow([
			"volyaspeople/form",
			"volyaspeople/video_uploader"
		]);
		
		HeadClass::addLess("/less/frontend/volyaspeople/index.less");
		HeadClass::addJs("/js/frontend/volyaspeople/index.js");
	}
	
	public function jAddVolyaMan()
	{
		parent::setViewer("json");
		
		$__errors = array();
		
		if(
				($__name = stripslashes(Request::getString("name")))
				&& empty(preg_replace("/\s+/i", "", $__name))
		)
			$__errors[] = "name_should_not_be_empty";
		
		if(count($__errors) > 0)
		{
			$this->json["errors"] = $__errors;
			return false;
		}
		
		@list($__firstName, $__lastName) = explode(" ", $__name);
		
		$__data = array(
			"symlink_avatar" => stripslashes(Request::getString("symlink_avatar")),
			"first_name" => $__firstName,
			"last_name" => $__lastName,
			"description" => stripslashes(Request::getString("description"))
		);
		
		foreach($__data as $__field => $__value)
			$__data[$__field] = str_replace("'", "\'", $__value);
		
		$this->json["data"] = $__data;
		
		return true;
	}
}
