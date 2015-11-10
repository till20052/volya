<?php

Loader::loadModule("Profile");
Loader::loadClass("UserClass");
Loader::loadClass("OldGeoClass");
Loader::loadModel("UsersModel");
Loader::loadModel("UsersDocsModel");
Loader::loadModel("EmploymentScopesModel");
Loader::loadModel("roep.RoepRegionsModel");

class EditProfileController extends ProfileController
{
	public function execute($args = array())
	{
		parent::execute((isset($args[0]) && UserClass::i()->hasCredential(777)) ? $args : array());
		parent::loadWindow("profile/scans_uploader");
		
		if( ! UserClass::i()->isAuthorized())
			parent::redirect("/");
		
		parent::loadKendo(true);
		
		HeadClass::addLess(array(
			"/less/frontend/profile/edit.less",
			"/less/frontend/profile/edit/scans_uploader.less"
		));
		
		HeadClass::addJs(array(
			"/js/form.js",
			"/js/frontend/profile/edit.js"
		));
		
		$this->profile["contacts"] = array(
			"email" => UsersModel::i()->getContacts($this->profile["id"], "email"),
			"phone" => UsersModel::i()->getContacts($this->profile["id"], "phone")
		);
		
		$this->profile["docs"] = UsersDocsModel::i()->getDocsByUserId($this->profile["id"]);

		$this->locality = [
			"id" => "",
			"title" => ""
		];
		if(strlen($this->profile["geo_koatuu_code"]) == 10)
			$this->locality = OldGeoClass::i()->getCity($this->profile["geo_koatuu_code"]);
		
//		$areas = OldGeoClass::i()->getAreas(2, $this->profile["region_id"]);
//		$userCity = OldGeoClass::i()->getCityById($this->profile["city_id"]);
//		
//		foreach ( $areas as $area )
//		{
//			if( 
//					$userCity["area"] == ""
//					&& $userCity["title"] == $area["title"]
//			)
//			{
//				$this->profile["area_id"] = $area["id"];
//				$this->profile["area_name"] = $area["title"];
//			}
//			else if(
//					$userCity["area"] != ""
//					&& isset ($area["area"])
//					&& $userCity["area"] == $area["area"]
//			)
//			{
//				$this->profile["area_id"] = $area["id"];
//				$this->profile["area_name"] = $area["area"];
//			}
//		}
		
//		UsersModel::i()->update(
//			array(
//				"id" => $this->profile["id"],
//				"area_id" => $this->profile["area_id"],
//				"area_name" => $this->profile["area_name"]
//			)
//		);
		
//		$__regions = array();
//		foreach(RoepRegionsModel::i()->getList() as $__id)
//			$__regions[] = RoepRegionsModel::i()->getItem($__id, array("id", "name"));
		
//		$this->roep = array(
//			"regions" => $__regions
//		);
	}
	
	public function jSave()
	{
		parent::setViewer("json");
		$this->json["error"] = array();
		
		$__userId = Request::getInt("id");
		
		if(
				$__userId != UserClass::i()->getId()
				&& ! UserClass::i()->hasCredential(777)
		){
			$this->json["error"][] = "access denied";
			return false;
		}
		
		$__profile = $this->initProfile($__userId);
		
		$__login = stripslashes(Request::getString("login"));
		if( ! filter_var($__login, FILTER_VALIDATE_EMAIL))
		{
			$this->json["error"][] = "input#login";
			return false;
		}
		
		$__password = stripslashes(Request::getString("password"));
		if($__password != "" && $__password != Request::getString("confirm_password"))
		{
			$this->json["error"][] = "input#password, input#confirm_password";
			return false;
		}
		
		$__data = array(
			"login" => $__login,
			"first_name" => stripslashes(Request::getString("first_name")),
			"middle_name" => stripslashes(Request::getString("middle_name")),
			"last_name" => stripslashes(Request::getString("last_name")),
			"birthday_day" => Request::getInt("birthday_day"),
			"birthday_month" => Request::getInt("birthday_month"),
			"birthday_year" => Request::getInt("birthday_year"),
			"education" => Request::getString("education"),
			"jobs" => Request::getString("jobs"),
			"social_activity" => Request::getString("social_activity"),
			"political_activity" => Request::getString("political_activity"),
			"was_allowed_to_use_pd" => Request::getInt("allowToUsePd"),
			"street" => Request::getString("street"),
			"house_number" => Request::getInt("house_number"),
			"apartment_number" => Request::getInt("apartment_number"),
			"education_level" => Request::getInt("education_level"),
			"professional_status" => Request::getInt("professional_status"),
			"employment_scope" => Request::getInt("employment_scope")
		);

		if(($__geoKoatuuCode = Request::getString("locality", "-1")) != "-1" && strlen($__geoKoatuuCode) == 10)
			$__data["geo_koatuu_code"] = $__geoKoatuuCode;
		
		if($__password != "")
			$__data["password"] = $__password;
		
		if( ! isset($__profile["id"]))
			return false;
		
		if( ! UsersModel::i()->update(array_merge(array("id" => $__profile["id"]), $__data)))
			return false;
		
		$__contacts = Request::getArray("contacts");
		
		foreach(array("email", "phone") as $__contactType)
			UsersModel::i()->setContacts(
					$__profile["id"],
					$__contactType,
					(isset($__contacts[$__contactType]) ? $__contacts[$__contactType] : array())
			);
		
		return true;
	}
	
	public function jAddDoc()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		$__userId = Request::getInt("id");
		
		if(
				$__userId != UserClass::i()->getId()
				&& ! UserClass::i()->hasCredential(777)
		){
			$this->json["error"][] = "access denied";
			return false;
		}
		
		$__profile = $this->initProfile($__userId);
		
		$__data = array(
			"user_id" => $__profile["id"],
			"file" => stripcslashes(Request::getString("scan")),
			"type" => stripcslashes(Request::getString("type"))
		);
		
		if( ! UsersDocsModel::i()->update(array("file" => $__data["file"]), array("user_id = ".$__data["user_id"], "type = ".UsersDocsModel::i()->getTypeIdByKey($__data["type"]))))
			UsersDocsModel::i()->insert($__data);
	}
	
	public function jDeleteDocByType()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		$__userId = Request::getInt("id");
		
		if(
				$__userId != UserClass::i()->getId()
				&& ! UserClass::i()->hasCredential(777)
		){
			$this->json["error"][] = "access denied";
			return false;
		}
		
		$__profile = $this->initProfile($__userId);
		
		UsersDocsModel::i()->deleteDocByType($__profile["id"], Request::getString("type"));
	}
}
