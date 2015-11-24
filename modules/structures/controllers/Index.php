<?php

Loader::loadModule("Structures");
Loader::loadService("StructuresService", Loader::APPLICATION);

use \libs\services\StructuresService;

class IndexStructuresController extends StructuresController
{

	private function __getStructure($sid)
	{
		$structure = StructuresService::i()->getStructure($sid, true);
		$structure["head"] = StructuresService::i()->getStructureHead($sid);
		$structure["coordinator"] = StructuresService::i()->getStructureCoordinator($sid);
		$structure["in_structure"] = StructuresService::i()->isInStructure(UserClass::i()->getId());

		return $structure;
	}

	public function __construct()
	{
		parent::__construct();

		$this->addAccessHandler(function($uid, $credentials = false){

		});
	}

	public function execute($args = [])
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadFileupload(true);

//		$credentials = new stdClass();
//
//		if( ! $this->hasAccess(UserClass::i()->getId(), $credentials))
//			$this->redirect('/');
//
//		$this->cred = $credentials;

		HeadClass::addJs("/js/form.js");

		if(isset($args[0]))
		{
			parent::setView("structure");

			HeadClass::addLess([
				"/less/frontend/structures/common/structure.less",
			]);

			HeadClass::addJs([
				"/js/frontend/structures/item.js"
			]);

			$this->structure = $this->__getStructure($args[0]);

			return;
		}

		parent::loadWindow([
			"register/structures/form",
		]);

		HeadClass::addJs([
			"/js/frontend/structures/index.js"
		]);

		HeadClass::addLess([
			"/less/frontend/structures/index.less",
			"/less/frontend/structures/common/filter.less",
			"/less/frontend/structures/common/structures.less",
			"/less/frontend/register/structures/form.less"
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

		if(StructuresService::i()->isInStructure(UserClass::i()->getId()))
			return false;

		StructuresService::i()->addMember(Request::getInt("sid"), UserClass::i()->getId());

		return true;
	}
}
