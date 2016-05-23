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
		parent::loadFileupload(true);
		parent::loadAngular(true);

		HeadClass::addJs([
			"/angular/js/app/modules/reports/index/services/reportsService.js",

			"/js/frontend/party/index/finances.js",
			"/angular/js/app/modules/reports/index/controllers/reportsViewController.js"
		]);

		HeadClass::addLess("/less/frontend/party/reports.less");
		
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
}
