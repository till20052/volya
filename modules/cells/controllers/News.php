<?php

Loader::loadModule("Cells");
Loader::loadModel("materials.NewsMaterialsModel");

class NewsCellsController extends CellsController
{
	public function execute()
	{
		parent::execute();
		parent::setViewer(null);
	}
	
	public function jAdd()
	{
		parent::setViewer("json");
		
		$__data = array(
			"author_id" => UserClass::i()->getId(),
			"cell_id" => Request::getInt("cell_id"),
			"title" => stripslashes(Request::getString("title")),
			"text" => stripslashes(Request::getString("text"))
		);
		
		foreach(array("title", "text") as $__field)
		{
			$__value = $__data[$__field];
			foreach(Router::getLangs() as $__lang)
			{
				if( ! is_array($__data[$__field]))
					$__data[$__field] = array();
				
				$__data[$__field][$__lang] = $__value;
			}	
		}
		
		$__id = NewsMaterialsModel::i()->insert($__data);
		
		$this->json["item"] = NewsMaterialsModel::i()->getItem($__id);
		
		return true;
	}
	
	public function jRemove()
	{
		parent::setViewer("json");
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! ($__item = NewsMaterialsModel::i()->getItem($__id))
		)
			return false;
		
		NewsMaterialsModel::i()->deleteItem($__id);
		
		return true;
	}
}
