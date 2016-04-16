<?php

Loader::loadModule("Structures");
Loader::loadService("StructuresService", Loader::APPLICATION);

use \libs\services\StructuresService;

class IndexStructuresController extends StructuresController
{

	private function __getStructure($fild)
	{
		if(
			strlen($fild) != 10
			|| ! ($__structure = StructuresService::i()->getStructureByGeo($fild))
		)
			$__structure = StructuresService::i()->getStructure($fild, true);

		$__structure["coordinator"] = StructuresService::i()->getStructureCoordinator($__structure["id"]);

		$__code = rtrim($__structure["geo"], '0');
		$__user = UsersModel::i()->getItem(UserClass::i()->getId());

		$__structure["can_join"] = true;

		if(StructuresService::i()->isInStructure(UserClass::i()->getId()))
			$__structure["can_join"] = false;

		if(preg_match("/" . $__code . "[0-9]{" . (10 - strlen($__code)) . "}/", $__user["geo_koatuu_code"]) < 1)
			$__structure["can_join"] = false;

		return $__structure;
	}

	public function __construct()
	{
		parent::__construct();

		if( ! UserClass::i()->isAuthorized())
			parent::redirect("/");

		$this->addAccessHandler(function($uid, $credentials = false){

		});
	}

	public function execute($args = [])
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadFileupload(true);
		parent::loadGallery(true);
		parent::loadAngular(true);
		parent::loadFileupload(true);

//		$credentials = new stdClass();
//
//		if( ! $this->hasAccess(UserClass::i()->getId(), $credentials))
//			$this->redirect('/');
//
//		$this->cred = $credentials;

		HeadClass::addJs("/js/form.js");
		HeadClass::addJs("/angular/js/app/modules/structures/index.js");
		HeadClass::addJs("/js/frontend/structures/index.js");

		HeadClass::addCss("/angular/css/app/modules/structures/index.css");

		$this->page = "";

		if(isset($args[0]))
		{
			$this->page = $args[0];

			switch($this->page) {
				case "regional":
					parent::setView("regional");
					parent::addBreadcrumb("/structures/regional", t("Інтерактивна карта партійних організацій"));

					HeadClass::addLess([
						"/less/frontend/structures/regional.less"
					]);

					HeadClass::addJs([
						"/js/frontend/structures/regional.js"
					]);

					break;

				default:
					parent::setView("structure");

					$this->page = "structure";

					HeadClass::addLess([
						"/less/frontend/structures/common/structure.less"
					]);

					HeadClass::addJs([
						"/js/frontend/structures/item.js"
					]);

					$this->structure = $this->__getStructure($args[0]);

					if($this->structure["levelInt"] < 6)
						$this->structure["structures"] = StructuresService::i()->getSubstructures( $this->structure["id"] );

					parent::addBreadcrumb("/structures/regional", t("Карта"));
					parent::addBreadcrumb("/structures/regional/" . $args[0], $this->structure["locality"]);

					break;
			}

			return;
		}

		parent::loadWindow([
			"register/structures/form",
		]);

		HeadClass::addLess([
			"/less/frontend/structures/index.less",
			"/less/frontend/structures/common/filter.less",
			"/less/frontend/structures/common/structures.less",
			"/less/frontend/register/structures/form.less",
			"/less/frontend/structures/common/scheme.less"
		]);

		$this->filter = [];
		$__cond = [];
		$__bind = [];

		if(Request::getString("geo"))
		{
			$this->filter["geo"] = GeoClass::i()->location(Request::getString("geo"), [
				"locationUrlPattern" => "?geo=:id",
				"lastNotLink" => true
			]);

			$__code = rtrim(Request::getString("geo"), '0');
			$__cond[] = "geo REGEXP :regexp";
			$__bind["regexp"] = $__code . "[0-9]{" . (10 - strlen($__code)) . "}";
		}

		$this->list = StructuresService::i()->getStructures($__cond, $__bind);
	}

	public function joinStructure()
	{
		parent::execute();
		parent::setViewer("json");

		$__code = rtrim(Request::getInt("geo"), '0');
		$__user = UsersModel::i()->getItem(UserClass::i()->getId());

		$this->json = [
			"status" => true
		];

		if(StructuresService::i()->isInStructure(UserClass::i()->getId()) )
			$this->json = [
				"status" => false,
				"msg" => t("Ви вже долучень до іншого осередку")
			];

		if(preg_match("/" . $__code . "[0-9]{" . (10 - strlen($__code)) . "}/", $__user["geo_koatuu_code"]) == 0)
			$this->json = [
				"status" => false,
				"msg" => t("Ви не попадаєте під зону дії цього осередку")
			];

		if( ! $this->json["status"])
			return false;

		StructuresService::i()->addMember(Request::getInt("sid"), UserClass::i()->getId());

		return true;
	}

	public function getStructureMembers()
	{
		parent::execute();
		parent::setViewer("json");

		$this->json["members"] = $this->__getStructure(Request::get("geo"))["members"];
	}

	public function showFileUploader()
	{
		parent::execute();
		parent::setLayout(false);

		parent::setView("windows/fileUpload");
	}
	
	public function saveDocument()
	{
		
	}
}
