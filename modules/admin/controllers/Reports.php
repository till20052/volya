<?php

Loader::loadModule("Admin");

Loader::loadModel("UsersModel");

Loader::loadService("ReportsService");

use libs\services\ReportsService;

class ReportsAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Фінансові звіти";
	public static $modAHref = "/admin/reports";
	public static $modImgSrc = "reports";

	public function execute()
	{
		parent::execute();
		parent::loadFileupload(true);
		parent::loadAngular(true);

		HeadClass::addJs([
			"/angular/js/app/modules/reports/index/services/reportsService.js",

			"/angular/js/app/modules/reports/index/controllers/reportsListController.js",
			"/angular/js/app/modules/reports/index/controllers/reportsUploaderController.js"
		]);

		HeadClass::addLess([
			"/less/frontend/admin/reports.less"
		]);
	}

	public function getReportsCategories()
	{
		parent::execute();
		parent::setViewer("json");

		$this->json["categories"] = ReportsService::i()->getCategories();
	}

	public function addCategory()
	{
		parent::execute();
		parent::setViewer("json");

		$__category = ReportsService::i()->addCategory(Request::getString("title"));

		if($__category)
			$this->json["category"] = $__category;
		else
			return false;

		return true;
	}

	public function saveCategory()
	{
		parent::execute();
		parent::setViewer("json");

		ReportsService::i()->saveCategory(Request::getArray("data"));

		return true;
	}

	public function removeCategory()
	{
		parent::execute();
		parent::setViewer("json");

		ReportsService::i()->removeCategory(Request::getInt("cid"));

		return true;
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
		$this->json["files"] = $data["files"];

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
