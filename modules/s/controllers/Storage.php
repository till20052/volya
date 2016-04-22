<?php

Loader::loadModule("S");
Loader::loadModel("StorageModel");

class StorageSController extends SController
{
	private function __saveFile($file, $filter = array())
	{
		$__path = $this->path();
		
		list($__i, $__j) = explode(".", microtime(true));
		$__fileName = md5($__i.str_pad($__j, 4, "0"));
		
		$__extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

		if(isset($filter["extension"]))
		{
			if(is_array($filter["extension"]))
			{
				foreach($filter["extension"] as $__key => $__val)
					$filter["extension"][$__key] = strtolower($__val);
			}
			else
				$filter["extension"] = strtolower($filter["extension"]);

			if(
					(is_array($filter["extension"]) && ! in_array($__extension, $filter["extension"]))
					|| (is_string($filter["extension"]) && $filter["extension"] != $__extension)
			)
				return false;
		}
		
		$__destination = $this->root.DS.$__path.DS.$__fileName.".".$__extension;
		
		move_uploaded_file($file["tmp_name"], $__destination);
		
		StorageModel::i()->insert(array(
			"hash" => $__fileName,
			"extension" => $__extension,
			"path" => $__path
		));
		
		return $__fileName;
	}
	
	public function __construct()
	{
		parent::__construct("storage");
	}
	
	public function execute($args = array())
	{
		parent::setViewer("file");
		
		if(
				! isset($args[0])
				|| ! ($__item = StorageModel::i()->getItemByHash($args[0]))
				|| ! ($__destination = $this->root.DS.$__item["path"].DS.$__item["hash"].".".$__item["extension"])
				|| ! is_file($__destination)
		){
			return header("HTTP/1.0 404 Not Found");
		}
		
		$this->fileName = $__destination;
	}
	
	public function jSave()
	{
		parent::setViewer("json");
		
		$__files = $_FILES;
		
		$__filter = array();
		if(($__extension = Request::get("extension", -1)) != -1)
			$__filter["extension"] = $__extension;
		
		foreach($__files as $__file)
			$this->json["files"][] = $this->__saveFile($__file, $__filter);
		
		return true;
	}
}
