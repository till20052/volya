<?php

Loader::loadModule("Party");

Loader::loadModel("TeamModel");
Loader::loadModel("materials.PagesMaterialsModel");

Loader::loadService("ReportsService");

use libs\services\ReportsService;

class IndexPartyController extends PartyController
{
	public function execute()
	{
		parent::execute();
		
		HeadClass::addLess("/less/frontend/party/index/landing_page.less");
		
		$__cond = ["is_public = :is_public"];
		$__bind = ["is_public" => 1];
		$__order = ["priority ASC"];
		
		$this->team = array();
		foreach(TeamModel::i()->getList($__cond, $__bind, $__order) as $__id)
			$this->team[] = TeamModel::i()->getItem($__id, ["name", "photo"]);
	}
	
	public function finances()
	{
		parent::execute();
		parent::loadAngular(true);
		parent::loadFileupload(true);
		
		HeadClass::addJs([
			"/js/frontend/party/index/finances.js",
			
			"/angular/js/app/modules/party/index/controllers/reportsListController.js",
			"/angular/js/app/modules/party/index/controllers/reportsUploaderController.js",

			"/angular/js/app/modules/party/index/services/reportsService.js"
		]);
		
		$this->menuClickable = true;
		
		$this->selected = "finances";
		$this->page = PagesMaterialsModel::i()->getItemBySymlink("finances");
	}
	
	public function documents()
	{
		parent::execute();
		
		HeadClass::addLess("/less/frontend/party/index/documents.less");
		
		$this->menuClickable = true;
		
		$this->selected = "documents";
		$this->page = PagesMaterialsModel::i()->getItemBySymlink("rules");
	}

	public function getReportsCategories()
	{
		parent::execute();
		parent::setViewer("json");

		$this->json["categories"] = ReportsService::i()->getCategories();
	}

	public function getReportsDocuments()
	{
		parent::execute();
		parent::setViewer("json");

		$this->json["documents"] = ReportsService::i()->getDocuments();
	}
	
	public function saveDocument()
	{
		parent::execute();
		parent::setViewer("json");

		$data = Request::getAll();

		$this->json["id"] = ReportsService::i()->addDocument($data["files"], $data["title"], $data["cid"]);

		return true;
	}

	public function deleteDocument()
	{
		parent::execute();
		parent::setViewer("json");

		ReportsService::i()->deleteDocument(Request::getInt("id"));

		return true;
	}
}
