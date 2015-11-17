<?php

Loader::loadModule("Register");

Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadClass("GeoClass");
Loader::loadClass("UserClass");

Loader::loadModel("UsersModel");

Loader::loadService("StructuresService");
Loader::loadService("structures.InitService");
Loader::loadService("register.admin.GroupsService");

use \libs\services\StructuresService;
use \libs\services\register\admin\GroupsService;

class StructuresRegisterController extends RegisterController
{
	private function __init()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadFileupload(true);
		parent::addBreadcrumb("/register/structures", t("Реєстр осередків"));
	}

	public function __findStructures(&$filter = array())
	{
		$__cond = array("is_active = 1");
		$__bind = array();
		$__order = array("created_at DESC");

		if(($__q = stripslashes(Request::getString("q"))) != "")
		{
			foreach(explode(" ", $__q) as $__token)
			{
				$__cond[] = array("OR" => array(
					"login LIKE '".str_replace("'", "\'", $__token)."%'",
					"first_name LIKE '".str_replace("'", "\'", $__token)."%'",
					"last_name LIKE '".str_replace("'", "\'", $__token)."%'",
				));
			}
			$filter["q"] = $__q;
		}

		if(count($this->registerUser["geo_koatuu_code"]) > 0)
		{
			$__GKC = [];
			$filter["region"] = $this->registerUser["geo_koatuu_code"];

			foreach($filter["region"] as $__region)
				$__GKC[] = "geo_koatuu_code REGEXP '".substr($__region, 0, 2)."[0-9]{8}'";

			$__cond[] = "(".implode(" OR ", $__GKC).")";
		}
		elseif(($__cityArea = stripslashes(Request::getString("cityArea"))) && strlen($__cityArea) == 10)
		{
			$__koatuuLength = Request::getInt('kl') > 0 ? Request::getInt('kl') : 10;
			$__cond[] = "geo_koatuu_code REGEXP '".substr($__cityArea, 0, $__koatuuLength)."[0-9]{".(10 - $__koatuuLength)."}'";
			$filter["cityArea"] = $__cityArea;
			$filter["city"] = stripslashes(Request::getString("city"));
			$filter["area"] = stripslashes(Request::getString("area"));
			$filter["region"] = stripslashes(Request::getString("region"));
		}
		elseif(($__city = stripslashes(Request::getString("city"))) && strlen($__city) == 10)
		{
			$__koatuuLength = Request::getInt('kl') > 0 ? Request::getInt('kl') : 10;
			$__cond[] = "geo_koatuu_code REGEXP '".substr($__city, 0, $__koatuuLength)."[0-9]{".(10 - $__koatuuLength)."}'";
			$filter["city"] = $__city;
			$filter["region"] = stripslashes(Request::getString("region"));
		}
		elseif(($__area = stripslashes(Request::getString("area"))) && strlen($__area) == 10)
		{
			$__koatuuLength = Request::getInt('kl') > 0 ? Request::getInt('kl') : 5;
			$__cond[] = "geo_koatuu_code REGEXP '".substr($__area, 0, $__koatuuLength)."[0-9]{".(10 - $__koatuuLength)."}'";
			$filter["area"] = $__area;
			$filter["region"] = stripslashes(Request::getString("region"));
		}
		elseif(($__region = stripslashes(Request::getString("region"))) && strlen($__region) == 10)
		{
			$__koatuuLength = Request::getInt('kl') > 0 ? Request::getInt('kl') : 2;
			$__cond[] = "geo_koatuu_code REGEXP '".substr($__region, 0, $__koatuuLength)."[0-9]{".(10 - $__koatuuLength)."}'";
			$filter["region"] = $__region;
		}

		if(
			($__type = Request::getInt("type")) > 0
			&& in_array($__type, [50, 99, 100])
		){
			$__cond[] = "type = :type";
			$__bind["type"] = $__type;
			$filter["type"] = $__type;
			$__type = array(
				50 => [],
				99 => [-1, 1],
				100 => [-10, 9, 10]
			)[$__type];
		}
		else
		{
			$__cond["OR"] = [
				"type = :type1",
				"type = :type2",
				"type = :type3"
			];
			$__bind["type1"] = UserClass::getTypeIdByKey("supporter");
			$__bind["type2"] = UserClass::getTypeIdByKey("candidate");
			$__bind["type3"] = UserClass::getTypeIdByKey("member");
		}

		if(
			($__verification = Request::getInt("verification")) != 0
			&& in_array($__verification, is_array($__type) ? $__type : [])
		){
			$filter["verification"] = $__verification;
		}

		$__list = array();
		foreach(UsersModel::i()->getList($__cond, $__bind, $__order) as $__id)
		{
			if(isset($filter["verification"]))
			{
				$__cond = array("user_id = :user_id");
				$__bind = array("user_id" => $__id);
				$__verification = UsersVerificationsModel::i()->getCompiledList($__cond, $__bind, array("id DESC"), 1);
				if( ! (count($__verification) > 0) || $__verification[0]["type"] != $filter["verification"])
					continue;
			}

			$__list[] = $__id;
		}

		return $__list;
	}

	public function __construct()
	{
		parent::__construct();

		$this->addAccessHandler(function($uid, $credentials){

			if( ! ($__group = GroupsService::i()->getGroupByUid($uid)))
				return false;

			if($__group["type"] == 0)
			{
				$credentials->filter["geo"] = $__group["geo"];
				$credentials->showRegionsFilter = false;
			}

			$credentials->showAddButton = true;
			return true;
		});
	}

	public function execute()
	{
		$this->__init();

		$credentials = new stdClass();

		if( ! $this->hasAccess(UserClass::i()->getId(), $credentials))
			$this->redirect('/');

		$this->cred = $credentials;

		parent::loadWindow([
			"register/structures/form",
			"register/structures/viewer",
			"register/structures/verification",
			"register/export"
		]);

		HeadClass::addLess([
			"/less/frontend/register/structures/form.less",
			"/less/frontend/register/structures/viewer.less",
		]);

		HeadClass::addJs(array(
			"/js/form.js",
			"/js/frontend/register/structures.js"
		));

		$this->filter = array();
		$__cond = [];
		$__bind = [];

		if(isset($credentials->filter["geo"])){
			$__code = rtrim($credentials->filter["geo"], '0');
			$__cond[] = "geo REGEXP :regexp";
			$__bind["regexp"] = $__code . "[0-9]{" . (10 - strlen($__code)) . "}";
		}

		$__list = array();
		$__pager = new PagerClass(StructuresService::i()->getStructures($__cond, $__bind), Request::getInt("page"), 14);

		foreach($__pager->getList() as $__id)
			$__list[] = StructuresService::i()->getStructure($__id);

		$this->list = $__list;
		$this->pager = $__pager;
	}

	public function getStructureLevel()
	{
		parent::execute();
		parent::setViewer("json");

		$this->json["level"] = StructuresService::i()->getStructureLevel(Request::getString("geo"));
	}

	public function getStructure()
	{
		parent::execute();
		parent::setViewer("json");

		if( ! ($__structure = StructuresService::i()->getStructure(Request::getInt("id"), true)))
			return false;

		$this->json["item"] = $__structure;

		return true;
	}

	public function setVarification()
	{
		parent::execute();
		parent::setViewer("json");

		StructuresService::i()->setVerification(Request::getInt("sid"), UserClass::i()->getId(), Request::getInt("state"), Request::getString("comment"));

		$this->json["item"] = StructuresService::i()->getStructure(Request::getInt("sid"));

		return true;
	}

	public function exportMembers($args = array())
	{
		parent::setLayout("document");
		parent::execute($args);
		parent::setView("register/export_members");

		parent::title(t("Витяг з Єдиного реєстру членів партії та партійних організацій"));

		$this->list = array();
		foreach(array_slice($this->__findMembers(), 0) as $__id)
		{
			$__item = UsersModel::i()->getItem($__id, array(
				"id",
				"type",
				"first_name",
				"last_name",
				"middle_name",
				"geo_koatuu_code"
			));

			$__item["contacts"] = array(
				"email" => UserClass::i($__item["id"])->getContacts("email"),
				"phone" => UserClass::i($__item["id"])->getContacts("phone")
			);

			$__item["verification"] = UserClass::i($__item["id"])->getLastVerification();

			$this->list[] = $__item;
		}

		$this->intlDateFormatter = new IntlDateFormatter('UK_ua', IntlDateFormatter::LONG, IntlDateFormatter::NONE, 'Europe/Berlin');
		$this->intlDateFormatter->setPattern("dd MMMM yyyy");

		return true;
	}

	public function saveStructure()
	{
		parent::execute();
		parent::setViewer("json");

		$__data = [
			"geo" => Request::getString("geo"),
			"address" => Request::getString("address"),
			"level" => Request::getInt("level"),
			"members" => Request::getArray("members"),
			"images" => Request::getArray("images")
		];

		$this->json["item"] = StructuresService::i()->save($__data);

		return true;
	}

	public function checkStructure()
	{
		parent::execute();
		parent::setViewer("json");

		$this->json = StructuresService::i()->checkStructure([
			"geo" => Request::getString("geo"),
			"members" => Request::getArray("members"),
			"level" => Request::getInt("level")
		]);
	}
}
