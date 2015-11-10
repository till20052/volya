<?php

Loader::loadModule("Admin");

Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadClass("OldGeoClass");
Loader::loadClass("UserClass");
Loader::loadClass("CellClass");

Loader::loadModel("UsersModel");
Loader::loadModel("UsersVerifiedModel");
Loader::loadModel("CellsModel");
Loader::loadModel("CellsDocumentsModel");
Loader::loadModel("CellsVerifiedModel");
Loader::loadModel("CellsPollingPlacesModel");
Loader::loadModel("PollingPlacesModel");
Loader::loadModel("RegisterUsersModel");

class RegisterAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Єдиний реєстр";
	public static $modAHref = "/admin/register";
	public static $modImgSrc = "register";
	
	private function __init()
	{
		parent::execute();
		parent::loadKendo(true);
		
		HeadClass::addLess(array(
			"/less/frontend/admin/register.less"
		));

		$this->registerUser = RegisterUsersModel::i()->getItemByUserId(UserClass::i()->getId());

		if( ! ($this->registerUser["credential_level_id"] > 0))
			parent::redirect("/admin");
	}
	
	public function __findMembers(&$filter = array())
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
	
	public function __findCells(&$filter = array())
	{
		$__cond = array();
		$__bind = array();
		$__order = array("created_at DESC");
		
		if(($__region = stripslashes(Request::getString("region"))) != "")
		{
			$__cond[] = "geo_koatuu_code REGEXP '".substr($__region, 0, 2)."[0-9]{8}'";
			$filter["region"] = $__region;
		}
		
		return CellsModel::i()->getList($__cond, $__bind, $__order);
		
	}
	
	public function execute()
	{
		parent::execute();
		parent::setView("register");
		parent::redirect("/admin/register/members");
	}
	
	public function members()
	{
		$this->__init();
		
		parent::loadWindow([
			"admin/register/members/viewer",
			"admin/register/members/verification",
			"admin/register/export"
		]);
		
		HeadClass::addJs(array(
			"/js/frontend/admin/register/members.js"
		));
		
		$this->filter = array();
		
		$__list = array();
		$__pager = new PagerClass($this->__findMembers($this->filter), Request::getInt("page"), 14);
		foreach($__pager->getList() as $__id)
		{
			$__item = UsersModel::i()->getItem($__id);
			
			$__item["name"] = UserClass::i($__id)->getName("&ln &fn &mn");
			
			if( ! is_null($__item["geo_koatuu_code"]) || $__item["geo_koatuu_code"] != "")
				$__item["locality"] = UserClass::i($__id)->getLocality();
			
			$__verification = UserClass::i($__id)->getLastVerification();
			
			if( ! is_null($__verification))
				$__verification["user_verifier"] = UsersModel::i()->getItem($__verification["user_verifier_id"], array(
					"id",
					"first_name",
					"last_name",
					"middle_name")
				);
			
			$__item["verification"] = $__verification;
			
			$__list[] = $__item;
		}
		
		$this->list = $__list;
		$this->pager = $__pager;
	}

	public function jGetMemberItem()
	{
		parent::execute();
		parent::setViewer("json");
		
		if(
				! (($__userId = Request::getInt("id")) > 0)
				|| ! ($__user = UsersModel::i()->getItem($__userId))
		)
			return false;
		
		$__user["name"] = UserClass::i($__user["id"])->getName("&ln &fn &mn");
		
		if( ! is_null($__user["geo_koatuu_code"]))
			$__user["locality"] = OldGeoClass::i()->getCity($__user["geo_koatuu_code"]);
		
		$__user["contacts"] = array(
			"email" => UserClass::i($__userId)->getContacts("email"),
			"phone" => UserClass::i($__userId)->getContacts("phone")
		);
		
		$__user["documents"] = UserClass::i($__userId)->getDocuments();
		
		$__verification = UserClass::i($__userId)->getLastVerification();	
		if( ! is_null($__verification))
			$__verification["user_verifier"] = UsersModel::i()->getItem($__verification["user_verifier_id"], array(
				"id",
				"first_name",
				"last_name",
				"middle_name"
			));

		$__user["verification"] = $__verification;
		
		$this->json["item"] = $__user;
		
		return true;
	}
	
	public function jSetMemberVerification()
	{
		parent::execute();
		parent::setViewer("json");
		
		if(
				! (($__userId = Request::getInt("user_id")) > 0)
				|| ! ($__user = UsersModel::i()->getItem($__userId))
		)
			return false;
		
		$__type = Request::getInt("type");
		
		UserClass::i($__userId)->setVerification(
				$__type,
				stripcslashes(Request::getString("comment")),
				stripcslashes(Request::getString("decision_number"))
		);
		
		$__userType = UserClass::i($__userId)->get("type");
		$__newUserType = $__userType;
		
		switch($__type)
		{
			case -10:
				$__newUserType = 99;
				break;
			
			case 10:
				$__newUserType = 100;
				break;
		}
		
		if($__userType != $__newUserType)
			UsersModel::i()->update(array(
				"id" => $__userId,
				"type" => $__newUserType
			));
		
		$this->json["user_id"] = $__userId;
		$this->json["user_type"] = $__newUserType;
		$this->json["verification"] = UserClass::i($__userId)->getLastVerification();
		
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
	
	public function cells()
	{
		$this->__init();
		
		parent::loadWindow([
			"admin/register/cells/viewer",
//			"admin/register/members/verification",
			"admin/register/export"
		]);
		
		HeadClass::addJs(array(
			"/js/frontend/admin/register/cells.js"
		));
		
		$this->list = [];
		$this->filter = [];
		$this->pager = new PagerClass($this->__findCells($this->filter), Request::getInt("page"), 14);
		
		foreach($this->pager->getList() as $__id)
		{
			$__item = CellClass::i($__id)->getEntity();
			
			$__item["number"] = CellClass::i($__id)->getNumber();
			$__item["locality"] = CellClass::i($__id)->getLocality();
			
			$this->list[] = $__item;
		}
	}
	
	public function jGetCellItem()
	{
		parent::setViewer("json");
		
		if(
				! (($__cellId = Request::getInt("id")) > 0)
				|| ! (CellClass::i($__cellId)->isExists())
		)
			return false;
		
		$__cell = CellClass::i($__cellId)->getEntity();
		
		$__cell["number"] = CellClass::i($__cellId)->getNumber();
		
		$__cell["locality"] = CellClass::i($__cellId)->getLocality();
		
		$__cell["creator"] = CellClass::i($__cellId)->getCreator();
		$__cell["members"] = CellClass::i($__cellId)->getMembers();
		
		$__cell["documents"] = CellClass::i($__cellId)->getDocuments();
		
		$__cell["polling_places"] = [CellClass::i($__cellId)->getRoepPollingPlace()];
		
		$this->json["item"] = $__cell;
		
		return true;
	}
	
	public function exportCells($args = array())
	{
		parent::setLayout("document");
		parent::execute($args);
		parent::setView("register/export_cells");
		
		parent::title(t("Витяг з Єдиного реєстру членів партії та партійних організацій"));
		
		$this->list = array();
		foreach(array_slice($this->__findCells(), 0) as $__id)
		{
			$__item = CellClass::i($__id)->getEntity();
			
			$__item["number"] = CellClass::i($__id)->getNumber();
			$__item["locality"] = CellClass::i($__id)->getLocality();
			
			$__item["members"] = CellClass::i($__id)->getMembers();
			
			$__item["polling_places"] = [CellClass::i($__id)->getRoepPollingPlace()];
			
			$this->list[] = $__item;
		}
		
		$this->intlDateFormatter = new IntlDateFormatter('UK_ua', IntlDateFormatter::LONG, IntlDateFormatter::NONE, 'Europe/Berlin');
		$this->intlDateFormatter->setPattern("dd MMMM yyyy");
		
		return true;
	}

	private function __getRegisterUserItem($id)
	{
		if( ! ($__item = RegisterUsersModel::i()->getItem($id)))
			return $__item;

		$__item["user"] = UsersModel::i()->getItem($__item["user_id"], [
			"id",
			"first_name",
			"last_name",
			"avatar"
		]);

		$__item["credential_level_title"] = RegisterUsersModel::i()->getCredentialLevelTitleById($__item["credential_level_id"]);

//		if(strlen($__item["geo_koatuu_code"]) == 10)
//			$__item["region"] = OldGeoClass::i()->getRegion($__item["geo_koatuu_code"]);

		$__item["regions"] = [];
		foreach($__item["geo_koatuu_code"] as $__code)
		{
			if(strlen($__code) != 10)
				continue;

			$__item["regions"][] = OldGeoClass::i()->getRegion($__code);
		}

		return $__item;
	}

	public function settings()
	{
		$this->__init();
		
		parent::loadWindow([
			"admin/register/settings/form",
			"admin/register/settings/confirm_form"
		]);

		HeadClass::addJs(array(
			"/js/frontend/admin/register/settings.js"
		));

		$this->filter = [];

		$__cond = ["is_hidden = 0"];
		$__bind = [];

		if(($__cl = Request::getInt("cl", -1)) != -1)
		{
			$__cond[] = "credential_level_id = :credential_level_id";
			$__bind["credential_level_id"] = $__cl;
			$this->filter["cl"] = $__cl;
		}

		if(($__r = Request::getString("r")) && strlen($__r) == 10)
			$this->filter["r"] = $__r;

//		foreach(RegisterUsersModel::i()->getList() as $__id)
//		{
//			$__item = RegisterUsersModel::i()->getItem($__id, ["id", "geo_koatuu_code"]);
//			RegisterUsersModel::i()->update([
//				"id" => $__id,
//				"geo_koatuu_code" => serialize([$__item["geo_koatuu_code"]])
//			]);
//		}

		$this->pager = new PagerClass(RegisterUsersModel::i()->getList($__cond, $__bind, ["id DESC"]), Request::getInt("page"), 15);

		$__list = [];
		foreach($this->pager->getList() as $__id)
		{
			$__item = $this->__getRegisterUserItem($__id);

			if(isset($this->filter["r"]) && ! in_array($this->filter["r"], $__item["geo_koatuu_code"]))
				continue;

			$__list[] = $__item;
		}

		$this->list = $__list;
	}

	public function jSettingsSaveRegisterUserItem()
	{
		parent::setViewer("json");

		$__id = Request::getInt("id");

		$__data = [
			"user_id" => Request::getInt("user_id"),
			"geo_koatuu_code" => Request::getArray("geo_koatuu_code")
		];

		if(($__credentialLevel = Request::getInt("credential_level", -1)) != -1)
			$__data["credential_level_id"] = $__credentialLevel;

		if( ! ($__id > 0) || ! RegisterUsersModel::i()->update(array_merge(["id" => $__id], $__data)))
			$__id = RegisterUsersModel::i()->insert($__data);

		$this->json["item"] = $this->__getRegisterUserItem($__id);

		return true;
	}

	public function jSettingsGetRegisterUserItem()
	{
		parent::setViewer("json");

		$__id = Request::getInt("id");

		if( ! ($__id > 0) || ! ($__item = $this->__getRegisterUserItem($__id)))
			return false;

		$this->json["item"] = $__item;

		return true;
	}

	public function jSettingsRemoveRegisterUserItem()
	{
		parent::setViewer("json");

		$__id = Request::getInt("id");

		if( ! ($__id > 0) || ! ($__item = $this->__getRegisterUserItem($__id)))
			return false;

		RegisterUsersModel::i()->deleteItem($__id);

		return true;
	}
}
