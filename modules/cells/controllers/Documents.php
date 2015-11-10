<?php

Loader::loadModule("Cells");
Loader::loadModel("CellsModel");
Loader::loadModel("CellsDocumentsModel");

class DocumentsCellsController extends CellsController
{
	public function execute()
	{
		parent::execute();
		parent::setViewer(null);
	}
	
	public function jAdd()
	{
		parent::setViewer("json");
		
		if(
				! (($__cellId = Request::getInt("cell_id"))) > 0
				|| ! CellsModel::i()->getItem($__cellId)
		)
			return false;
		
		$__data = array(
			"cell_id" => $__cellId,
			"type" => Request::getInt("type"),
			"hash" => stripslashes(Request::getString("hash")),
			"name" => stripslashes(Request::getString("name"))
		);
		
		$this->json["item"] = CellsDocumentsModel::i()->getItem(CellsDocumentsModel::i()->insert($__data));
		
		return true;
	}
	
	public function jRemove()
	{
		parent::setViewer("json");
		
		if(
				! (($__id = Request::getInt("id"))) > 0
				|| ! CellsDocumentsModel::i()->getItem($__id)
		)
			return false;
		
		CellsDocumentsModel::i()->deleteItem($__id);
		
		return true;
	}
}
