<?php

Loader::loadModule("Register");

Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadClass("OldGeoClass");
Loader::loadClass("GeoClass");
Loader::loadClass("UserClass");

Loader::loadModel("UsersModel");
Loader::loadService("register.MembersService", Loader::APPLICATION);
Loader::loadService("register.admin.GroupsService");

use \libs\services\register\MembersService;
use \libs\services\register\admin\GroupsService;

class MembersRegisterController extends RegisterController
{
	public static $__membersService;

	private function __init()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::addBreadcrumb("/register/admin", t("Реєстр членів"));

		self::$__membersService = new MembersService();
	}

	public function __construct()
	{
		parent::__construct();

		$this->addAccessHandler(function($uid, $credentials = false){

			if( ! ($__group = GroupsService::i()->getGroupByUid($uid)))
				return false;

			if( ! $credentials)
				return true;

			if($__group["type"] == 0)
			{
				$credentials->filter["geo"] = $__group["geo"];
				$credentials->showRegionsFilter = false;
				$credentials->approver = false;
				$credentials->verifier = true;
			}

			if($__group["type"] == 1)
			{
				$credentials->showRegionsFilter = true;
			}

			if($__group["type"] == 2)
			{
				$credentials->approver = true;
				$credentials->showRegionsFilter = true;
			}

			$credentials->showAddButton = true;
			return true;
		});
	}

	public function __findMembers(&$filter = array())
	{
		$__cond = array("is_active = 1", "type >= 99");
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

		if($this->cred->showRegionsFilter){
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
		}

		if(isset($this->cred->filter["geo"]))
		{
			$__code = rtrim($this->cred->filter["geo"], '0');
			$__cond[] = "geo_koatuu_code REGEXP :regexp";
			$__bind["regexp"] = $__code . "[0-9]{" . (10 - strlen($__code)) . "}";
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

	public function execute()
	{
		$this->__init();

		$credentials = new stdClass();

		if( ! $this->hasAccess(UserClass::i()->getId(), $credentials))
			$this->redirect('/');

		$this->cred = $credentials;

		parent::loadWindow([
			"register/members/viewer",
			"register/members/approve",
			"register/export"
		]);

		HeadClass::addJs(array(
			"/js/frontend/register/members.js"
		));

		$this->filter = array();

		if(isset($credentials->filter["geo"])){
			$__code = rtrim($credentials->filter["geo"], '0');
			$__cond[] = "geo REGEXP :regexp";
			$__bind["regexp"] = $__code . "[0-9]{" . (10 - strlen($__code)) . "}";
		}

		$__list = array();
		$__pager = new PagerClass($this->__findMembers($this->filter), Request::getInt("page"), 14);
		foreach($__pager->getList() as $__id)
			$__list[] = self::$__membersService->getMember($__id);

		$this->list = $__list;
		$this->pager = $__pager;
	}

	public function getMember()
	{
		if( ! $this->hasAccess(UserClass::i()->getId()))
			return false;

		parent::execute();
		parent::setViewer("json");
		$this->__init();

		$this->json["item"] = self::$__membersService->getMember(Request::getInt("id"));

		return true;
	}

	public function exportMembers($args = array())
	{
		if( ! $this->hasAccess(UserClass::i()->getId()))
			$this->redirect('/');

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

	public function setVarification()
	{
		if( ! $this->hasAccess(UserClass::i()->getId()))
			return false;

		parent::execute();
		parent::setViewer("json");
		$this->__init();

		self::$__membersService->setVerification(Request::getInt("uid"), UserClass::i()->getId(), Request::getInt("state"), Request::getString("comment"));

		$this->json["item"] = self::$__membersService->getMember(Request::getInt("uid"));

		return true;
	}

	public function setApprove()
	{
		$credentials = new stdClass();

		if( ! $this->hasAccess(UserClass::i()->getId(), $credentials))
			$this->redirect('/');

		if( ! $credentials->approver)
			return false;

		parent::execute();
		parent::setViewer("json");
		$this->__init();

		self::$__membersService->setApprove(Request::getInt("uid"), UserClass::i()->getId(), Request::getInt("did"), Request::getInt("type"), Request::getString("comment"));

		$this->json["item"] = self::$__membersService->getMember(Request::getInt("uid"));

		return true;
	}
}
