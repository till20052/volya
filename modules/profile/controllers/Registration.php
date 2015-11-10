<?php

Loader::loadModule("Profile");
Loader::loadClass("VKApiClass", Loader::SYSTEM);
Loader::loadModel("EmploymentScopesModel");
Loader::loadModel("VolunteerGroupsModel");
Loader::loadModel("UsersModel");
Loader::loadModel("UsersVolunteerGroupsModel");
Loader::loadModel("UsersContactsModel");
Loader::loadClass("EmailTemplateClass");
Loader::loadClass("OldGeoClass");

class RegistrationProfileController extends ProfileController
{
//	public function execute()
//	{
//		parent::execute();
//		parent::loadKendo(true);
//		parent::loadWindow("profile/scans_uploader");
//		parent::loadWindow("profile/registration/requirements");
//		
//		HeadClass::addJs(array(
//			"/js/form.js",
//			"/js/frontend/profile/registration.js"
//		));
//		HeadClass::addCss("/css/frontend/profile/registration.css");
//		HeadClass::addLess("/less/frontend/profile/registration/scans.less");
//		
//		$this->geo = array(
//			"regions" => OldGeoClass::i()->getRegions(2)
//		);
//	}
	
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadFileupload(true);
		
		parent::setView("registration/steps");
		
		HeadClass::addJs(array(
			"/js/form.js",
			"/js/frontend/profile/registration/steps.js"
		));
		
		HeadClass::addLess("/less/frontend/profile/registration/steps.less");
		
		$this->registration = new stdClass();
		
		$this->registration->title = "Приєднатися";
		$this->registration->description = "";
	}
	
	public function jSubmit()
	{
		parent::setViewer("json");
		
		$__errors = array();
		$__userContacts = array();
		
		if(
				($__type = Request::getInt("type"))
				&& ! in_array($__type, array(1, 50, 99))
		)
			$__errors[] = "type_is_not_in_condition";
		
		if(
				($__email = stripslashes(Request::getString("email")))
				&& ! filter_var($__email, FILTER_VALIDATE_EMAIL)
		)
			$__errors[] = "email_has_not_correct_value";
		
		if(count(UsersModel::i()->getList(["login = :login", "type > 1"], ["login" => $__email], [], 1)) > 0)
			$__errors[] = "user_already_exists";
		
		$__userContacts[] = array(
			"type" => "email",
			"value" => $__email
		);
		
		// NAME
		if(
				($__name = stripslashes(Request::getString("name")))
				&& empty(preg_replace("/\s+/i", "", $__name))
		)
			$__errors[] = "name_should_not_be_empty";
		else
		{
			@list($__firstName, $__lastName, $__middleName) = explode(" ", $__name);
			
			if(
					in_array($__type, array(50, 99))
					&& (empty($__firstName) || empty($__lastName) || empty($__middleName))
			)
				$__errors[] = "all_tokens_of_name_should_be_filled";
		}
		
		$__password = "";
		$__documents = array();
		$__birthdayDay = null;
		$__birthdayMonth = null;
		$__birthdayYear = null;
		$__geoKoatuuCode = null;
		$__street = "";
		$__education = null;
		$__workScope = Request::getInt("work_scope");
		$__professionalStatus = null;
		$__jobs = null;
		$__socialActivity = null;
		$__politicalActivity = null;
		
		if(in_array($__type, array(50, 99)))
		{
			// DOCUMENTS
			if($__type == 99)
			{
				if(strlen($__statement = stripslashes(Request::getString("statement"))) != 32)
					$__errors[] = "need_a_statement";
				
				$__documents[] = array(
					"type" => "ApplicationForMembership",
					"hash" => $__statement
				);
				
				if(strlen($__declaration = stripslashes(Request::getString("declaration"))) != 32)
					$__errors[] = "need_a_declaration";
				
				$__documents[] = array(
					"type" => "LustrationDeclaration",
					"hash" => $__declaration
				);
			}
			
			// PASSWORD
			if(
					($__password = stripslashes(Request::getString("password"))) == ""
					|| $__password != Request::getString("confirm_password")
			)
				$__errors[] = "invalid_password";
			
			// CONTACTS: Phone
			if(
					($__phone = preg_replace("/[^0-9]/", "", stripslashes(Request::getString("phone"))))
					&& ! in_array(strlen($__phone), array(10, 12))
			)
				$__errors[] = "phone_has_not_correct_value";
			else
			{
				$__userContacts[] = array(
					"type" => "phone",
					"value" => $__phone
				);
			}
			
			// BIRTHDAY: Day & Month
			if($__type == 99)
			{
				if(
						($__birthdayDay = Request::getInt("birthday_day", -1)) == -1
						|| $__birthdayDay < 1
						|| $__birthdayDay > 31
				)
					$__errors[] = "incorrect_birthday_day_value";
				
				if(
						($__birthdayMonth = Request::getInt("birthday_month", -1)) == -1
						|| $__birthdayMonth < 1
						|| $__birthdayMonth > 12
				)
					$__errors[] = "incorrect_birthday_month_value";
			}
			
			// BIRTHDAY: Year
			if(
					($__birthdayYear = Request::getInt("birthday_year", -1)) == -1
					|| $__birthdayYear <= (date("Y") - 100)
					|| $__birthdayYear > (date("Y") - 18)
			)
				$__errors[] = "incorrect_birthday_year_value";
			
			// GEO: geo_koatuu_code
			if(
					strlen($__geoKoatuuCode = stripslashes(Request::getString("geo_koatuu_code"))) != 10
					|| ! OldGeoClass::i()->getCity($__geoKoatuuCode)
			)
				$__errors[] = "incorrect_geo_code_value";
			
			if($__type == 99 && ($__street = stripslashes(Request::getString("address"))) == "")
				$__errors[] = "incorrect_address_value";
			
			// EDUCATION
			if( ! (($__education = Request::getInt("education")) > 0) && $__type == 99)
				$__errors[] = "incorrect_education_value";
			
			// WORK SCOPE
//			if(
//					$__type == 50
//					&& ! (($__workScope = Request::getInt("work_scope")) > 0)
//			)
//				$__errors[] = "incorrect_work_scope_value";
			
			// PROFESSIONAL STATUS
			if( ! (($__professionalStatus = Request::getInt("professional_status")) > 0) && $__type == 99)
				$__errors[] = "incorrect_professional_status_value";
			
			// ADDITIONAL INFORAMATION
			if($__type == 99)
			{
				if(($__jobs = stripslashes(Request::getString("jobs"))) == "")
					$__errors[] = "jobs_should_be_not_empty";
				
				if(($__socialActivity = stripslashes(Request::getString("social_activity"))) == "")
					$__errors[] = "social_activity_should_be_not_empty";
				
				if(($__politicalActivity = stripslashes(Request::getString("political_activity"))) == "")
					$__errors[] = "political_activity_should_be_not_empty";
			}
		}
		
		if(count($__errors) > 0)
		{
			$this->json["errors"] = $__errors;
			return false;
		}
		
		list($__t1, $__t2) = explode(".", microtime(true));
		$__securityCode = md5($__t1.str_pad($__t2, 4, "0"));
		
		$__data = array(
			"type" => $__type,
			"login" => (string) $__email,
			"password" => (string) $__password,
			"security_code" => $__securityCode,
			"first_name" => (string) $__firstName,
			"last_name" => (string) $__lastName,
			"middle_name" => (string) $__middleName,
			"birthday_day" => $__birthdayDay,
			"birthday_month" => $__birthdayMonth,
			"birthday_year" => $__birthdayYear,
			"sex" => (($__sex = Request::getInt("sex", -1)) != -1 ? $__sex : null),
			"geo_koatuu_code" => $__geoKoatuuCode,
			"street" => $__street,
			"education_level" => $__education,
			"work_scope" => $__workScope,
			"professional_status" => $__professionalStatus,
			"jobs" => $__jobs,
			"social_activity" => $__socialActivity,
			"political_activity" => $__politicalActivity,
			"additional_info" => stripslashes(Request::getString("addtional_info"))
		);
		
		$__userId = UsersModel::i()->insert($__data);
		
		foreach($__userContacts as $__userContact)
			UserClass::i($__userId)->addContact($__userContact["type"], $__userContact["value"]);
		
		if(UserClass::i($__userId)->isSupporter())
		{
			foreach(Request::getArray("volunteer_groups") as $__volunteerGroupId)
				UserClass::i($__userId)->addToVolunteerGroup($__volunteerGroupId);
		}
		
		if(UserClass::i($__userId)->isCandidate())
		{
			foreach($__documents as $__document)
				UserClass::i($__userId)->addDocument($__document["type"], $__document["hash"]);
		}
		
		if(
				UserClass::i($__userId)->isSupporter()
				|| UserClass::i($__userId)->isCandidate()
		){
			$this->json["email"] = EmailTemplateClass::i()->send("profile.registration.j_submit", $__email, array(
				"server_name" => $_SERVER["SERVER_NAME"],
				"login" => $__email,
				"password" => $__password,
				"security_code" => $__securityCode
			));
		}
		
		return true;
	}
	
//	private function old_jSubmit()
//	{
//		parent::setViewer("json");
//		$this->json["error"] = array();
//		
//		$__login = stripslashes(Request::getString("email"));
//		
//		if( ! filter_var($__login, FILTER_VALIDATE_EMAIL))
//			$this->json["error"][] = "incorrect:email";
//		
//		if(
//				$__login != "till20052@gmail.com"
//				&& $__login != "aleschenko.rostislav@gmail.com"
//				&& UsersModel::i()->getItemByLogin($__login) != false
//		)
//			$this->json["error"][] = "user_already_exists";
//		
//		$__password = stripslashes(Request::getString("password"));
//		
//		if($__password == "" || $__password != Request::getString("confirm_password"))
//			$this->json["error"][] = "incorrect:password";
//		
//		$__phone = preg_replace("/[ +_()-]/", "", Request::getString("phone"));
//		if(strlen($__phone) != 12)
//			$this->json["error"][] = "incorrect:phone";
//		
//		list($__t1, $__t2) = explode(".", microtime(true));
//		$__securityCode = md5($__t1.str_pad($__t2, 4, "0"));
//		
//		$__data = array(
//			"login" => $__login,
//			"password" => $__password,
//			"security_code" => $__securityCode,
//			"first_name" => stripslashes(Request::getString("first_name")),
//			"last_name" => stripslashes(Request::getString("last_name")),
//			"middle_name" => stripslashes(Request::getString("middle_name")),
//			"birthday_day" => Request::getInt("birthday_day"),
//			"birthday_month" => Request::getInt("birthday_month"),
//			"birthday_year" => Request::getInt("birthday_year"),
//			"country_id" => 2,
//			"country_name" => t("Україна"),
//			"region_id" => Request::getInt("region_id"),
//			"region_name" => stripslashes(Request::getString("region_name")),
//			"area_id" => Request::getInt("area_id"),
//			"area_name" => stripslashes(Request::getString("area_name")),
//			"city_id" => Request::getInt("city_id"),
//			"city_name" => stripslashes(Request::getString("city_name")),
//			"street" => stripslashes(Request::getString("street")),
//			"house_number" => stripslashes(Request::getString("house_number")),
//			"apartment_number" => stripslashes(Request::getString("apartment_number")),
//			"employment_scope" => Request::getInt("employment_scope"),
//			"type" => Request::getInt("type"),
//			"sex" => Request::getInt("sex"),
//			"education_level" => Request::getInt("education_level"),
//			"professional_status" => Request::getInt("professional_status"),
////			"education" => Request::getString("education"),
//			"jobs" => Request::getString("jobs"),
//			"social_activity" => Request::getString("social_activity"),
//			"political_activity" => Request::getString("political_activity"),
//			"was_allowed_to_use_pd" => Request::getInt("was_allowed_to_use_pd")
//		);
//		
//		$this->json["scans"] = Request::get("scan");
//		
//		foreach($__data as $__field => $__value)
//		{
//			if(in_array($__field, array("first_name", "last_name")) && $__value == "")
//				$this->json["error"][] = "value_cannot_be_empty:".$__field;
//			
//			if(in_array($__field, array("region_id", "area_id", "city_id", "employment_scope", "education_level", "professional_status")) && ! ($__value > 0))
//				$this->json["error"][] = "value_must_be_greater_than_zero:".$__field;
//			
//			if( Request::getInt("type") == 99 )
//			{
//				if(in_array($__field, array("middle_name", "political_activity", "social_activity", "jobs")) && $__value == "")
//					$this->json["error"][] = "value_cannot_be_empty:".$__field;
//				
//				if(in_array($__field, array("street", "house_number", "apartment_number", "education_level", "professional_status", "was_allowed_to_use_pd")) && ! ($__value > 0))
//					$this->json["error"][] = "value_must_be_greater_than_zero:".$__field;
//			}
//		}
//		
//		if( Request::getInt("type") == 99 )
//			foreach (Request::getArray("scan") as $__type => $__hash)
//				if($__hash == "")
//					$this->json["error"][] = "scan_cannot_be_empty:".$__type;
//		
//		if(count($this->json["error"]) > 0)
//			return false;
//		
//		$__userId = UsersModel::i()->insert($__data);
//		
//		if( Request::getInt("type") == 99 )
//			foreach (Request::getArray("scan") as $__type => $__hash)
//				UsersDocsModel::i()->insert(array("type" => $__type, "file" => $__hash, "user_id" => $__userId));
//		
//		UsersVolunteerGroupsModel::i()->set($__userId, Request::getArray("volunteer_groups"));
//		
//		foreach(array(
//			"email" => $__login,
//			"phone" => stripslashes(Request::getString("phone"))) as $__t => $__v)
//		{
//			UsersContactsModel::i()->insert(array(
//				"user_id" => $__userId,
//				"type" => $__t,
//				"value" => $__v
//			));
//		}
//		
//		$__security_code = "";
//		
//		$this->json["email_status"] = EmailTemplateClass::i()->send("profile.registration.j_submit", $__login, array(
//			"server_name" => $_SERVER["SERVER_NAME"],
//			"login" => $__login,
//			"password" => $__password,
//			"security_code" => $__securityCode
//		));
//		
//		return true;
//	}
}
