<?php

Loader::loadModule("Cells");
Loader::loadClass("OGeoClass");
Loader::loadClass("UserClass");
Loader::loadModel("roep.RoepRegionsModel");
Loader::loadModel("roep.RoepPlotsModel");
Loader::loadModel("CellsModel");
Loader::loadModel("CellsUsersModel");
Loader::loadModel("CellsDocumentsModel");
Loader::loadModel("UsersVerifiedModel");
Loader::loadClass("EmailTemplateClass");

Loader::loadModel("materials.NewsMaterialsModel");

class IndexCellsController extends CellsController
{
	private function __viewItem($id)
	{
		parent::setView("index/item");
		parent::loadFileupload(true);
		parent::loadKendo(true);
		
		parent::loadWindow(array(
			"cells/index/users_finder",
			"cells/index/confirm"
		));
		
		HeadClass::addLess(array(
			"/less/frontend/cells/index/item.less",
			"/less/frontend/cells/common/right_column.less",
			"/less/frontend/cells/common/right_column/calendar.less"
		));
		
		HeadClass::addJs(array(
			"/js/frontend/cells/index/item.js",
			"/js/frontend/cells/common/right_column/calendar.js"
		));
		
		$this->cell = CellsModel::i()->getItem($id);
		$this->cell["roep"] = RoepPlotsModel::i()->getItem($this->cell["roep_plot_id"]);
		$this->cell["documents"] = CellsDocumentsModel::i()->getCompiledListByCellId($this->cell["id"], array(
			"order" => array("id DESC")
		));
		$this->cell["news"] = NewsMaterialsModel::i()->getCompiledListByCellId($this->cell["id"], array(
			"order" => array("id DESC")
		));
		
		if(CellsModel::i()->isMember(UserClass::i()->getId()))
		{
			parent::loadWindow(array(
				"cells/index/item/add_document",
				"cells/index/item/add_new"
			));
			
			HeadClass::addJs(array(
				"/js/frontend/cells/index/item/documents.js",
				"/js/frontend/cells/index/item/news.js"
			));

			$this->documentTypes = array();
			foreach(CellsDocumentsModel::getTypes() as $__typeId => $__typeText)
			{
				$this->documentTypes[] = array(
					"id" => $__typeId,
					"text" => $__typeText
				);
			}
		}
		
		$this->common = CellsUsersModel::i()->getUsersByCellId($id);
	}
	
	private function __viewList()
	{
		parent::setView("index/list");
		parent::loadKendo(true);
		parent::loadWindow("cells/index/list/new_cell");
		parent::loadWindow("cells/index/list/roep_selection");
		parent::loadWindow("cells/index/users_finder");
		parent::loadWindow("cells/scan_uploader");
		
		HeadClass::addJs(array(
			"/js/frontend/cells/index/list.js"
		));
		
		HeadClass::addLess("/less/frontend/cells/index/list.less");
		
		$this->geo = array(
			"regions" => OGeoClass::i()->getRegions(2)
		);
		
		$__regions = array();
		foreach(RoepRegionsModel::i()->getList() as $__id)
			$__regions[] = RoepRegionsModel::i()->getItem($__id, array("id", "name"));
		
		$this->roep = array(
			"regions" => $__regions
		);
		
		$__cells = array();
		foreach(CellsModel::i()->getCompiledList(array(), array(), array("id DESC")) as $__cell)
		{
			$__cell["plot"] = RoepPlotsModel::i()->getItem($__cell["roep_plot_id"]);
			$__cell["users"] = CellsUsersModel::i()->getCompiledList(array("cell_id = :cell_id"), array("cell_id" => $__cell["id"]));
			$__cells[] = $__cell;
		}
		
		$this->list = $__cells;
		
	}
	
	public function execute($args = array())
	{
		parent::execute();
		
		if( ! (count(UsersVerifiedModel::i()->getList(array("user_id = :user_id"), array("user_id" => UserClass::i()->getId()))) > 0))
			parent::redirect("/");
		
		if( isset($args[0]) )
			$this->__viewItem($args[0]);
		else
			$this->__viewList();
	}
	
	public function jSave()
	{
		parent::setViewer("json");
		
		$__data = array(
			"user_creator_id" => UserClass::i()->getId(),
			"region_id" => Request::getInt("region_id"),
			"region_name" => stripslashes(Request::getString("region_name")),
			"city_id" => Request::getInt("city_id"),
			"city_name" => stripslashes(Request::getString("city_name")),
			"area_in_city" => stripslashes(Request::getString("area_in_city")),
			"address" => stripslashes(Request::getString("address")),
			"roep_plot_id" => Request::getInt("plot_id"),
			"started_at" => date("Y-m-d H:i:s", strtotime(Request::getString("started_at")))
		);
		
		$__cellId = CellsModel::i()->insert($__data);
		
		$__users = array();
		foreach(Request::getArray("users") as $__userId)
		{
			CellsUsersModel::i()->insert(array(
				"cell_id" => $__cellId,
				"user_id" => $__userId
			));
			$__users[] = $__userId;
		}
		
		foreach(Request::getArray("images") as $__image)
		{
			CellsDocumentsModel::i()->insert(array(
				"cell_id" => $__cellId,
				"hash" => $__image
			));
		}
		
		$__roepPlot = RoepPlotsModel::i()->getItem($__data["roep_plot_id"]);
		
		foreach($__users as $__userId)
		{
			if(UserClass::i()->getId() == $__userId)
				continue;
			
			$__receiver = UsersModel::i()->getItem($__userId);
			
			EmailTemplateClass::i()->send("cells.index.notification", $__receiver["login"], array(
				"receiver_name" => $__receiver["name"],
				"sender_name" => UserClass::i()->getName(),
				"city_name" => $__data["city_name"],
				"region_name" => $__data["region_name"],
				"area_in_city" => $__data["area_in_city"] != "" ? ", ".$__data["area_in_city"] : "",
				"plot_number" => $__roepPlot["number"],
				"link" => "<a href=\"/cells/\">[".t("Підтвердити")."]</a>"
			));
		}
		
		return true;
	}
	
	public function jAddUsers()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		CellsUsersModel::i()->insert(array(
			"cell_id" => Request::getInt("cell_id"),
			"user_id" => Request::getInt("user_id")
		));	
	}
	
	public function jDeleteUsers()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		CellsUsersModel::i()->deleteUser(Request::getInt("user_id"), Request::getInt("cell_id"));	
	}
}
