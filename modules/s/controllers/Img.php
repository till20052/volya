<?php

Loader::loadModule("S");
Loader::loadModel("storage.ImagesStorageModel");

class ImgSController extends SController
{
	private $__imageSizes = array(
		"aa" => "100x100",
		"ab" => "240x320",
		"ac" => "x50",
		"ad" => "x100",
		"ae" => "138x138",
		"af" => "1000x",
		"ag" => "200x",
		"ah" => "350x",
		"ai" => "50x50",
		"aj" => "350x350",
		"ak" => "x350",
		"al" => "650x200",
		"am" => "1280x1024",
		"an" => "230x",
		"ao" => "100x150",
		"ap" => "600x",
		"ar" => "150x150",
		"as" => "300x300",
		"at" => "75x75",
		"160x120" => "160x120",
		"150x100" => "150x100",
		"200x" => "200x",
		"630x" => "630x",
		"x400" => "x400",
		"105x140" => [
			"size" => "105x140",
			"crop" => 1
		]
	);
	
	private function __saveFile($file)
	{
		$__path = $this->path();
		
		list($__i, $__j) = explode(".", microtime(true));
		$__filename = md5($__i.str_pad($__j, 4, "0"));
		
		$__info = getimagesize($file);
		switch($__info["mime"])
		{
			case "image/jpg":
			case "image/jpeg":
				$__image = imagecreatefromjpeg($file);
				break;
			
			case "image/gif":
				$__image = imagecreatefromgif($file);
				break;
			
			case "image/png":
				$__image = imagecreatefrompng($file);
				break;
			
			default:
				return false;
		}
		
		imagejpeg($__image, $this->root.DS.$__path.$__filename.".jpg", 100);
		
		ImagesStorageModel::i()->insert(array(
			"hash" => $__filename,
			"extension" => "jpg",
			"path" => $__path
		));
		
		return $__filename;
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
				|| ! ($__item = ImagesStorageModel::i()->getItemByHash($args[0]))
				|| ! is_file($this->root.DS.$__item["path"].DS.$__item["hash"].".".$__item["extension"])
		){
			return header("HTTP/1.0 404 Not Found");
		}
		
		$this->fileName = $this->root.DS.$__item["path"].DS.$__item["hash"].".".$__item["extension"];
	}

	public function jSave()
	{
		parent::setViewer("json");
		$this->json["files"] = array();
		
		$__files = $_FILES;
		
		foreach($__files as $__file)
		{
			$__token = is_array($__file["tmp_name"]) ? $__file["tmp_name"] : array($__file["tmp_name"]);
			foreach($__token as $__tmpName)
			{
				$this->json["files"][] = $this->__saveFile($__tmpName);
			}
		}
		
		return true;
	}
	
	public function jSaveByUrl()
	{
		parent::setViewer("json");
		$this->json["files"] = array();
		
		$__url = urldecode(Request::getString("url"));
		
		list($__i, $__j) = explode(".", microtime(true));
		$__filename = "/tmp/".md5($__i.str_pad($__j, 4, "0"));
		
		if( ! file_put_contents($__filename, file_get_contents($__url)))
		{
			return false;
		}
		
		$this->json["files"][] = $this->__saveFile($__filename);
		
		unlink($__filename);
		
		return true;
	}
	
	public function thumb($args = array())
	{
		parent::setViewer("file");

		if(
				! isset($args[0])
				|| ! isset($this->__imageSizes[$args[0]])
				|| ! isset($args[1])
				|| ! ($__item = ImagesStorageModel::i()->getItemByHash($args[1]))
				|| ! is_file($this->root.DS.$__item["path"].DS.$__item["hash"].".".$__item["extension"])
		){
			return header("HTTP/1.0 404 Not Found");
		}

		$__imagepath = $this->root.DS.$__item["path"].DS.$__item["hash"].".".$__item["extension"];
		$__thumbpath = $this->root.DS.$__item["path"].DS.$__item["hash"]."_".$args[0].".".$__item["extension"];

//		if( ! file_exists($__thumbpath))
//		{

		$__exec = "convert ".$__imagepath." ";

		$__value = $this->__imageSizes[$args[0]];
		if(is_array($__value))
		{
			$__exec .= "-resize ".$__value["size"];

			if (isset($__value["crop"]) && $__value["crop"] == 1)
				$__exec .= "^ -gravity center -crop ".$__value["size"]."+0+0 ";
		}
		else
			$__exec .= "-resize ".$__value." ";

		$__exec .= "-quality 100 " .$__thumbpath;

		exec($__exec);
//		}

		$this->fileName = $__thumbpath;
	}

//	public function crop()
//	{
//		
//	}
}
