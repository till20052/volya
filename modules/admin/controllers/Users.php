<?php

Loader::loadModule("Admin");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadClass("OldGeoClass");
Loader::loadModel("UsersModel");
Loader::loadModel("UsersContactsModel");
Loader::loadModel("EmploymentScopesModel");
Loader::loadModel("UsersDocsModel");
Loader::loadModel("UsersVerifiedModel");
Loader::loadModel("EmailTemplatesModel");
Loader::loadClass("EmailTemplateClass");

class UsersAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Менеджер користувачів";
	public static $modAHref = "/admin/users";
	public static $modImgSrc = "users";
	
	private function __getUsersList(&$filter = array(), &$pager = null)
	{
		$__cond = array();
		$__bind = array();
		
		if(($__type = Request::getInt("type")) > 0)
		{
			$__cond[] = "type = :type";
			$__bind["type"] = $__type;
			$filter["type"] = $__type;
		}
		
		if(($__employmentScope = Request::getInt("es")) > 0)
		{
			$__cond[] = "employment_scope = :employment_scope";
			$__bind["employment_scope"] = $__employmentScope;
			$filter["employment_scope"] = $__employmentScope;
		}

		if(($__geo = Request::getString("geo", "-1")) != "-1" && strlen($__geo) == 10)
		{
			for($__i = 9; $__i > 0; $__i--)
			{
				if(substr($__geo, $__i, 1) == "0")
					continue;

				$__geo = substr($__geo, 0, $__i + 1);
				break;
			}

			$__cond[] = "geo_koatuu_code REGEXP '".$__geo."[0-9]{".(10-strlen($__geo))."}'";
		}
		
		if(($__isArtificial = Request::getInt("is_artificial", -1)) != -1)
		{
			$__cond[] = "is_artificial = :is_artificial";
			$__bind["is_artificial"] = $__isArtificial;
			$filter["is_artificial"] = $__isArtificial;
		}
		
		if(($__firstName = mb_ereg_replace('/[^a-zа-яёшії]+/iu', '', Request::getString("first_name"))) != "")
		{
			$__cond[] = "first_name LIKE '%".$__firstName."%'";
			$filter["first_name"] = $__firstName;
		}
		
		if(($__lastName = mb_ereg_replace('/[^a-zа-яёії]+/iu', '', Request::getString("last_name"))) != "")
		{
			$__cond[] = "last_name LIKE '%".$__lastName."%'";
			$filter["last_name"] = $__lastName;
		}
		
		if( Request::getInt("all_fields_are_filled") )
			$filter["all_fields_are_filled"] = Request::getInt("all_fields_are_filled");
		
		if(Request::getInt("all_fields_are_filled") > 0)
		{

			$__cond[] = "first_name != ''";
			$__cond[] = "last_name != ''";
			
			$__cond[] = "birthday_day != 0";
			$__cond[] = "birthday_month != 0";
			$__cond[] = "birthday_year != 0";
			
			$__cond[] = "education != ''";
			$__cond[] = "jobs != ''";
			$__cond[] = "social_activity != ''";
			$__cond[] = "political_activity != ''";
		}
		
		$__userList = array();
		$__users = UsersModel::i()->getCompiledList($__cond, $__bind, array("created_at DESC"));
		
		if(
				! is_null($pager)
				&& ! Request::getInt("all_fields_are_filled")
		){
			$pager = new PagerClass($__users, Request::getInt("page"), 14);
			$__users = $pager->getList();
		}
		
		foreach ($__users as $__user)
		{	
			$__user["all_fields_are_filled"] = UserClass::isUserFieldsAreField($__user);
			
			if(
					(Request::getInt("all_fields_are_filled") > 0)
					&& ($__user["all_fields_are_filled"] != 1)
			)
				continue;
			
			if(count(UsersVerifiedModel::i()->getList(array("user_id = :user_id"), array("user_id" => $__user["id"]))) > 0)
				if(Request::getInt("all_fields_are_filled") == 1)
					continue;
				else
					$__user["is_verified"] = 1;
			else
				if(Request::getInt("all_fields_are_filled") == 2)
					continue;
				else
					$__user["is_verified"] = 0;
			
			$__userList[] = $__user;
		}
		
		if(
				! is_null($pager)
				&& Request::getInt("all_fields_are_filled") > 0
		){
			$pager = new PagerClass($__userList, Request::getInt("page"), 14);
			$__userList = $pager->getList();
		}
		
		return $__userList;
	}
	
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadWindow("admin/users/form");
		parent::loadWindow("admin/users/confirm");
		parent::loadWindow("admin/users/finder");
		parent::loadWindow("admin/users/viewer");
		parent::loadWindow("admin/users/email_templates");
		parent::loadWindow("admin/users/viewer/scans/scans_viewer");
		
		HeadClass::addLess(array(
			"/less/frontend/admin/users/viewer/index.less"
		));
		
		HeadClass::addJs(array(
			"/js/form.js",
			"/js/frontend/admin/users.js"
		));
		
		$this->filter = array();
		$this->showCleanFilterLink = false;
		$this->pager = array();
		$this->count = 0;
		
		$this->list = $this->__getUsersList($this->filter, $this->pager);
		
		if(count($this->filter) > 0)
			$this->showCleanFilterLink = true;
		
		$this->geo = array(
			"regions" => OldGeoClass::i()->getRegions(2)
		);
		
		$this->credentials = UsersModel::getCredentials();
		$this->employmentScopes = EmploymentScopesModel::i()->getCompiledList();
	}
	
	public function jSave()
	{
		parent::setViewer("json");
		$this->json["errors"] = array();
		
//		if( ! parent::_user()->isAuthorized())
//			$this->json["errors"][] = "access denied";
		
		$__id = Request::getInt("id");
		
		$__login = Request::getString("login");
		if(
				! filter_var($__login, FILTER_VALIDATE_EMAIL)
				|| (($__item = UsersModel::i()->getItemByLogin($__login)) && $__id != $__item["id"])
		)
			$this->json["errors"][] = "invalid login";
		
		if(($__password = Request::getString("password")) != Request::getString("confirm_password"))
			$this->json["errors"][] = "invalid password";
		
		if(count($this->json["errors"]))
			return false;
		
		$__user = array(
			"login" => $__login,
			"first_name" => Request::getString("first_name"),
			"last_name" => Request::getString("last_name"),
			"middle_name" => Request::getString("middle_name"),
			"type" => Request::getInt("type"),
//			"is_active" => Request::getInt("is_active"),
			"credential_level"	=> Request::getInt("credential_level")
		);
		
		if($__password != "")
			$__user["password"] = $__password;
		
		if(
				! ($__id > 0)
				|| ! (UsersModel::i()->update(array_merge(array("id" => $__id), $__user)))
		){
			$__id = UsersModel::i()->insert(array_merge($__user, array(
				"activated_at" => date("Y-m-d H:i:s", 0)
			)));
		}
		
//		UsersVolunteersGroupsModel::i()->setVolunteersGroups($__id, Request::getArray("groups"));
		
		$this->json["item"] = UsersModel::i()->getItem($__id);
		
		return true;
	}
	
	public function jGetFullInfo()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		$__userId = Request::getInt("id");
		
		$__cond = array("user_id = :user_id");
		$__bind = array("user_id" => $__userId);
		
		$this->json["user_info"] = UsersModel::i()->getItem($__userId);
		$this->json["user_contacts"] = array(
			"emails" => UsersContactsModel::i()->getEmails($__userId),
			"phones" => UsersContactsModel::i()->getPhones($__userId),
		);
		
		$this->json["user_docs"] = array();
		foreach (UsersDocsModel::i()->getDocsByUserId($__userId) as $type => $doc)
			$this->json["user_docs"][] = array(
				"type" => $type,
				"file" => $doc
			);
		
		$this->json["verification"] = UsersVerifiedModel::i()->getItemByField("user_id", $__userId);
		
		$__user_verified = UsersModel::i()->getItem($this->json["verification"]["user_verifier_id"]);
		$this->json["verification"]["user_verifier"] = $__user_verified["name"];
	}
	
	public function jVerify()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		$__data = array(
			"user_id" => Request::getInt("id"),
			"user_verifier_id" => UserClass::i()->getId()
		);
		
		UsersVerifiedModel::i()->insert($__data);
		
		$this->json["verification"] = UsersVerifiedModel::i()->getItemByField("user_id", Request::getInt("id"));
		
		$__user_verified = UsersModel::i()->getItem($this->json["verification"]["user_verifier_id"]);
		$this->json["verification"]["user_verified"] = $__user_verified["name"];
	}

	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! ($__item = UsersModel::i()->getItem($__id))
		){
			return false;
		}
		
		$this->json["item"] = $__item;
		
		return true;
	}
	
	public function jActivate()
	{
		parent::setViewer("json");
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! ($__item = UsersModel::i()->getItem($__id))
		){
			return false;
		}
		
		UsersModel::i()->update(array(
			"id" => $__id,
			"is_active" => (bool) Request::getInt("state")
		));
		
		return true;
	}
	
	public function jDelete()
	{
		parent::setViewer("json");
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! ($__item = UsersModel::i()->getItem($__id))
		){
			return false;
		}
		
		UsersModel::i()->deleteItem($__id);
		
		return true;
	}
	
	public function jGetEmailTemplates()
	{
		parent::setViewer("json");
		
		$this->json["list"] = EmailTemplatesModel::i()->getCompiledList();
		
		return true;
	}
	
	public function jSendEmail()
	{
		parent::setViewer("json");
		
		$__symlink = stripslashes(Request::getString("symlink"));
		$__list = $this->__getUsersList();
		
		foreach($__list as $__item)
		{
			EmailTemplateClass::i()->send($__symlink, $__item["login"], array(
				"server_name" => $_SERVER["SERVER_NAME"],
				"login" => $__item["login"],
				"password" => $__item["password_temp"],
				"security_code" => $__item["security_code"]
			));
		}
		
		return true;
	}
}
