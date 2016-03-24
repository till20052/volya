<?php

Loader::loadModule("Register");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadService("register.DocumentsService", Loader::APPLICATION);

use \libs\services\register\documents\DocumentsService;

class DocumentsRegisterController extends RegisterController
{

	private function __getList()
	{
		$this->pager = new PagerClass(parent::$documents->getDocuments(), Request::getInt("page"), 14);
		$this->list = $this->pager->getList();
		$this->categories = parent::$documents->getCategories();
	}

	public function execute($args = [])
	{
		parent::execute();
		parent::loadKendo(TRUE);
		parent::loadFileupload(true);
		parent::addBreadcrumb("/register/admin", t("Документи"));

		HeadClass::addJs([
			"/js/form.js",
			"/js/frontend/register/documents.js"
		]);

		HeadClass::addLess([
			"/less/frontend/register/documents/documents_form.less",
			"/less/frontend/register/documents.less"
		]);

		parent::loadWindow([
			"register/documents/form",
			"register/documents/categories_form",
			"register/documents/scans_viewer"
		]);

		$documents = new DocumentsService();

		$subController = "get_list";
		if(isset($args[0]))
			$subController = $args[0];

		switch($subController)
		{
			case "get_list":
				$this->__getList();

				break;

			case "find_document":
				parent::setViewer("json");
				$this->json["list"] = parent::$documents->findDocument(Request::getString("number"));

				break;
		}

		if($subController == "j_get_categories")
		{
			parent::setViewer("json");

			$this->json["list"] = $documents->getCategories();

			return true;
		}

		if($subController == "j_save_category")
		{
			parent::setViewer("json");

			$__id = $documents->saveCategory([
				'id' => Request::getInt("id"),
				'title' => Request::getString("title")
			]);

			$this->json["item"] = $documents->getCategory($__id);

			return true;
		}

		if($subController == "j_get_document")
		{
			parent::setViewer("json");

			$this->json["item"] = $documents->getDocument(Request::getInt("id"));
			$this->json["date"] = date("Y-m-d H:i:s", strtotime(Request::getString("created_at")));

			return true;
		}

		if($subController == "j_save_document")
		{
			parent::setViewer("json");

			$__id = $documents->saveDocument([
				"id" => Request::getInt("id"),
				"cid" => Request::getInt("cid"),
				"number" => Request::getString("number"),
				"created_at" => date("Y-m-d H:i:s", strtotime(Request::getString("created_at"))),
				"images" => Request::getArray("images")
			]);

			$this->json["item"] = $documents->getDocument($__id);

			return true;
		}
	}
}
