<?php

Loader::loadModule("S");
Loader::loadModel("materials.NewsMaterialsModel");
Loader::loadMOdel("NewsImagesModel");

class NewsSController extends SController
{
	public function execute()
	{
		parent::execute();
	}
	
	public function moveImages()
	{
		parent::execute();
		parent::setViewer(null);
		
		$__cond = ["image != ''"];
		
		foreach(NewsMaterialsModel::i()->getList($__cond) as $__id)
		{
			$__item = NewsMaterialsModel::i()->getItem($__id, ["id", "image"]);
			
			NewsMaterialsModel::i()->update([
				"id" => $__item["id"],
				"image" => ""
			]);
			
			NewsImagesModel::i()->insert([
				"material_id" => $__item["id"],
				"symlink" => $__item["image"]
			]);
		}
	}
}
