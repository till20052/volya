<?php

Loader::loadModule("Admin");

class IndexAdminController extends AdminController
{
	private function __getModules()
	{
		$__list = array();
		
		$__directory = Router::getAppFolder().DS."modules".DS."admin".DS."controllers";
		
		foreach(scandir($__directory) as $__file)
		{
			if(in_array($__file, array(".", "..", ".svn")))
				continue;
			
			include_once $__directory.DS.$__file;
			
			$__tokens = explode(".", $__file);
			$__controller = $__tokens[0]."AdminController";
			$__vars = get_class_vars($__controller);
			
			if( ! $__vars["modIsVisible"])
				continue;
			
			if($__vars["modImgSrc"] == "")
				$__vars["modImgSrc"] = "unknown";
			
			$__list[] = array(
				"a.href" => is_null($__vars["modAHref"]) ? "/admin/".strtolower($__tokens[0]) : $__vars["modAHref"],
				"a.text" => $__vars["modAText"],
				"img.src" => "/img/frontend/admin/index/".$__vars["modImgSrc"].".png"
			);
		}
		
		return $__list;
	}
	
	public function execute()
	{
		parent::execute();
		
		HeadClass::addLess("/less/frontend/admin/index.less");
		
		$this->modules = $this->__getModules();
	}
}
