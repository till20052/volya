<?php

Loader::loadModule("Structures");
Loader::loadService("StructuresService", Loader::APPLICATION);

use \libs\services\StructuresService;

class IndexStructuresController extends StructuresController
{

	private function __getStructure($sid)
	{
		$__structure = StructuresService::i()->getStructure($sid, true);
		$__structure["head"] = StructuresService::i()->getStructureHead($sid);
		$__structure["coordinator"] = StructuresService::i()->getStructureCoordinator($sid);

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

//		$credentials = new stdClass();
//
//		if( ! $this->hasAccess(UserClass::i()->getId(), $credentials))
//			$this->redirect('/');
//
//		$this->cred = $credentials;

		HeadClass::addJs("/js/form.js");

		if(isset($args[0]))
		{
			switch($args[0]) {
				case "regional":
					parent::setView("regional");

					HeadClass::addLess([
						"/less/frontend/structures/regional.less"
					]);

					HeadClass::addJs([
						"/js/frontend/structures/regional.js"
					]);

					break;

				default:
					parent::setView("structure");

					HeadClass::addLess([
						"/less/frontend/structures/common/structure.less"
					]);

					HeadClass::addJs([
						"/js/frontend/structures/item.js"
					]);

					$this->structure = $this->__getStructure($args[0]);

					break;
			}

			return;
		}

		parent::loadWindow([
			"register/structures/form",
		]);

		HeadClass::addJs([
			//"/js/frontend/structures/index.js"
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
}
