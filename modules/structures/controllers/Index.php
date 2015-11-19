<?php

Loader::loadModule("Structures");
Loader::loadService("StructuresService", Loader::APPLICATION);

use \libs\services\StructuresService;

class IndexStructuresController extends StructuresController
{

	public function __construct()
	{
		parent::__construct();

		$this->addAccessHandler(function($uid, $credentials = false){

		});
	}

	public function execute()
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

		parent::loadWindow([
			"register/structures/form",
		]);

		HeadClass::addLess([
			"/less/frontend/register/structures/form.less"
		]);

		HeadClass::addJs(array(
			"/js/form.js",
			"/js/frontend/structures/index.js"
		));

		HeadClass::addLess([
			"/less/frontend/structures/index.less",
			"/less/frontend/structures/common/filter.less",
			"/less/frontend/structures/common/structures.less"
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
}
