<?php

Loader::loadSystem("Cookie");
Loader::loadClass("ExtendedClass", Loader::SYSTEM);
Loader::loadClass("OldGeoClass");
Loader::loadModel("UsersModel");
Loader::loadModel("UsersContactsModel");
Loader::loadModel("UsersVolunteerGroupsModel");
Loader::loadModel("UsersDocsModel");
Loader::loadModel("UsersVerificationsModel");

class UserClass extends ExtendedClass
{
	private static $__types = array(
		array(
			"id" => 1,
			"key" => "subscriber",
			"text" => "Підписник"
		),
		array(
			"id" => 50,
			"key" => "supporter",
			"text" => "Прихильник"
		),
		array(
			"id" => 99,
			"key" => "candidate",
			"text" => "Кандидат в члени партії"
		),
		array(
			"id" => 100,
			"key" => "member",
			"text" => "Член партії"
		)
	);
	
	private static $__sex = array(
		0 => "Чоловіча",
		1 => "Жіноча"
	);
	
	private static $__educationTypes = array(
		1 => "Вища",
		2 => "Середня / Спеціальна",
		3 => "Закордонна",
		4 => "Незакінчена вища"
	);
	
	private static $__workScopeTypes = array(
		1 => "Освіта, наука, виховання",
		2 => "Бухгалтерія, банки, фінанси, аудит",
		3 => "ЗМІ/журналістика",
		4 => "Юриспруденція",
		5 => "Комп'ютерні технології, IT",
		6 => "Медицина, фармація",
		7 => "Телекомунікації, зв'язок",
		8 => "Офісний персонал, HR",
		9 => "Реклама, маркетинг, PR",
		10 => "Поліграфія, видавництво",
		11 => "Торгівля, продаж",
		12 => "Сільське господарство, агробізнес",
		13 => "Будівництво, архітектура, нерухомість",
		14 => "Транспорт, автосервіс",
		15 => "Логістика, склад, ЗЕД",
		16 => "Служба безпеки, охорона",
		17 => "Інженерія, виробництво, робоча спеціальность",
		18 => "Сфера послуг",
		19 => "Культура, кіно, шоу-бізнес, фотографія",
		20 => "Туризм, спорт",
		21 => "Cтрахування",
		99 => "Інше"
	);
	
	private static $__professionalStatusTypes = array(
		1 => "Власник / Підприємець",
		2 => "Керівник вищої ланки",
		3 => "Керівник середньої ланки",
		4 => "Спеціаліст",
		5 => "Студент"
	);
	
	private static $__volunteerGroups = array(
		1 => "розповсюджувати агітаційну продукцію",
		2 => "організувати зустрічі представників партії з громадськістю",
		3 => "надвати безкоштовні консультації громадянам",
		4 => "організаційно допомагати в офісі",
		5 => "приймати дзвінки на гарячій лінії"
	);
	
	private $__sessionKey = "UserClass.__data.id";
	private $__cookieKey = "UserClass.__data.id";
	private $__userId = 0;
	private $__user = array();
	
    /**
	 * 
     * @return UserClass
     */
	public static function i($userId = 0)
	{
		return parent::i("UserClass", array($userId));
	}
	
	public static function getNameByItem($item, $tpl = "&fn &ln")
	{
		$data = array(
			"fn" => $item["first_name"],
			"mn" => $item["middle_name"],
			"ln" => $item["last_name"]
		);
		
		foreach($data as $key => $val)
			$tpl = str_replace("&".$key, $val, $tpl);
		
		return $tpl;
	}
	
	public static function hasUserCredential($user, $credentialLevel)
	{
		return (bool) ($user["credential_level"] >= $credentialLevel);
	}
	
	public static function isUserFieldsAreField($user)
	{
		$__all_fields_are_filled = 1;
		if( 
				($user["first_name"] == "")
				|| ($user["last_name"] == "")
				|| ($user["birthday_day"] == 0)
				|| ($user["birthday_month"] == 0)
				|| ($user["birthday_year"] == 0)
				|| ($user["education"] == "")
				|| ($user["jobs"] == "")
				|| ($user["social_activity"] == "")
				|| ($user["political_activity"] == "")
		)
			$__all_fields_are_filled = 0;
		
		if( ! UsersContactsModel::i()->isContactsSet($user["id"]) )
			$__all_fields_are_filled = 0;
		
		if( ! UsersDocsModel::i()->isAllDocs($user["id"]) )
			$__all_fields_are_filled = 0;
		
		return $__all_fields_are_filled;
	}
	
	public static function getTypes()
	{
		$__list = array();
		
		foreach(self::$__types as $__type)
			$__list[] = array_merge($__type, array(
				"text" => t($__type["text"])
			));
		
		return $__list;
	}
	
	public static function getType($id)
	{
		foreach(self::$__types as $__type)
		{
			if($__type["id"] != $id)
				continue;
			
			return $__type;
		}
		
		return array(
			"id" => 0,
			"key" => "",
			"text" => ""
		);
	}

	public static function getTypeIdByKey($typeKey)
	{
		foreach(self::$__types as $__type)
		{
			if($__type["key"] != $typeKey)
				continue;
			
			return $__type["id"];
		}
		
		return 0;
	}
	
	public static function getSex()
	{
		$__list = array();
		
		foreach(self::$__sex as $__sexId =>  $__sexText)
			$__list[] = array(
				"id" => $__sexId,
				"text" => t($__sexText)
			);
		
		return $__list;
	}

	public static function getEducationTypes()
	{
		$__list = array();
		
		foreach(self::$__educationTypes as $__educationTypeId =>  $__educationTypeText)
			$__list[] = array(
				"id" => $__educationTypeId,
				"text" => t($__educationTypeText)
			);
		
		return $__list;
	}
	
	public static function getWorkScopeTypes()
	{
		$__list = array();
		
		foreach(self::$__workScopeTypes as $__workScopeTypeId =>  $__workScopeTypeText)
			$__list[] = array(
				"id" => $__workScopeTypeId,
				"text" => t($__workScopeTypeText)
			);
		
		return $__list;
	}
	
	public static function getProfessionalStatusTypes()
	{
		$__list = array();
		
		foreach(self::$__professionalStatusTypes as $__professionalStatusTypeId =>  $__professionalStatusTypeText)
			$__list[] = array(
				"id" => $__professionalStatusTypeId,
				"text" => t($__professionalStatusTypeText)
			);
		
		return $__list;
	}
	
	public static function getVolunteerGroups()
	{
		$__list = array();
		
		foreach(self::$__volunteerGroups as $__volunteerGroupId => $__volunteerGroupText)
			$__list[] = array(
				"id" => $__volunteerGroupId,
				"text" => t($__volunteerGroupText)
			);
		
		return $__list;
	}
	
	public static function getAge($date)
	{
		$__ageWords = array(t("років"), t("рік"), t("роки"));
	    
		if(is_null($date))
			return false;
		
		list($__dayNow, $__monthNow, $__yearNow) = explode(".", date("d.m.Y"));
		list($__day, $__month, $__year) = explode(".", date("d.m.Y", strtotime($date)));
		
		$__age = $__yearNow - $__year;
		if($__monthNow < $__month && $__dayNow < $__day)
			$__age -= 1;
		
		$__mod = $__age;
		if($__age > 9)
			$__mod = fmod($__age, 10);
		
		$__ageWordsIndex = 0;
		if($__mod > 1 && $__mod < 5)
			$__ageWordsIndex = 2;
		elseif($__mod == 1)
			$__ageWordsIndex = 1;
		
		if($__age > 9 && $__age < 20)
			$__ageWordsIndex = 0;
		
		return $__age." ".$__ageWords[$__ageWordsIndex];
	}

	public function isAllFieldsAreField()
	{
		return self::isUserFieldsAreField($this->__user);
	}
	
	public function __construct($userId = 0)
	{
		if($userId > 0)
			return ($this->__user = UsersModel::i()->getItem($userId));
		
		if( ! isset($this->__user["id"]))
			$this->__user["id"] = 0;
		
		if( ! ($this->__user["id"] > 0))
		{
			if( ! (($__userId = Session::get($this->__sessionKey)) > 0))
				$__userId = (int) Cookie::get($this->__cookieKey);
			
			$this->__user["id"] = $__userId;
		}
		
		if($this->__user["id"] > 0 && count($this->__user["id"]) == 1)
			$this->__user = UsersModel::i()->getItem($this->__user["id"]);
	}
	
	public function get($field, $default = null)
	{
		return isset($this->__user[$field]) ? $this->__user[$field] : $default;
	}
	
	public function getId()
	{
		return isset($this->__user["id"]) ? (int) $this->__user["id"] : 0;
	}
	
	public function getAvatar()
	{
		return isset($this->__user["avatar"]) ? $this->__user["avatar"] : "";
	}
	
	public function getCity()
	{
		return isset($this->__user["city_name"]) ? $this->__user["city_name"] : "";
	}
	
	public function getName($tpl = "&fn &ln")
	{
		return self::getNameByItem($this->__user, $tpl);
	}
	
	public function getLocality($splitBy = " / ")
	{
		if( ! (($__userId = $this->getId()) > 0))
			return false;
		
		$__tokens = array();
		$__city = OldGeoClass::i()->getCity($this->__user["geo_koatuu_code"]);
		
		foreach(["region", "area", "title"] as $__field)
		{
			if(isset($__city[$__field]))
				$__tokens[] = $__city[$__field];
		}
		
		return implode($splitBy, $__tokens);
	}
	
	public function getContacts($type = null)
	{
		if( ! (($__userId = $this->getId()) > 0))
			return false;
		
		$__list = array();
		
		$__cond = array();
		$__bind = array();
		
		if( ! is_null($type) && in_array($type, array("phone", "email")))
		{
			$__cond[] = "type = :type";
			$__bind["type"] = $type;
		}
		
		foreach(UsersContactsModel::i()->getCompiledListByField("user_id", $__userId, array(
			"cond" => $__cond,
			"bind" => $__bind,
			"fields" => array("value"))
		) as $__contact)
			$__list[] = $__contact["value"];
		
		return $__list;
	}
	
	public function authorize($user, $inCookie = false)
	{
		$this->__user = $user;
		
		Session::set($this->__sessionKey, $this->__user["id"]);
		
		if($inCookie)
			Cookie::set($this->__cookieKey, $this->__user["id"], null, "/", '.volya.ua');
	}
	
	public function isAuthorized()
	{
		return (bool) ($this->getId() > 0);
	}
	
	public function clear()
	{
		$this->authorize(array("id" => 0), true);
	}
	
	public function hasCredential($credentialLevel)
	{
		return self::hasUserCredential($this->__user, $credentialLevel);
	}
	
	public function isSupporter()
	{
		if( ! (($__userId = $this->getId()) > 0))
			return -1;
		
		return (bool) ($this->__user["type"] == self::getTypeIdByKey("supporter"));
	}
	
	public function isCandidate()
	{
		if( ! (($__userId = $this->getId()) > 0))
			return -1;
		
		return (bool) ($this->__user["type"] == self::getTypeIdByKey("candidate"));
	}
	
	/**
	 * 
	 * @param string $type
	 * @param string $value
	 * @return int
	 * @example UserClass::i($userId)->addContact($type, $value) or UserClass::i()->addContact($type, $value) for authorized users
	 */
	public function addContact($type, $value)
	{
		if( ! (($__userId = $this->getId()) > 0))
			return false;
		
		return UsersContactsModel::i()->insert(array(
			"user_id" => $__userId,
			"type" => $type,
			"value" => $value
		));
	}
	
	public function addToVolunteerGroup($volunteerGroupId)
	{
		if( ! (($__userId = $this->getId()) > 0))
			return false;
		
		return UsersVolunteerGroupsModel::i()->insert(array(
			"user_id" => $__userId,
			"volunteer_group_id" => $volunteerGroupId
		));
	}
	
	public function addDocument($type, $hash)
	{
		if( ! (($__userId = $this->getId()) > 0))
			return false;
		
		UsersDocsModel::i()->insert(array(
			"user_id" => $__userId,
			"type" => $type,
			"file" => $hash
		));
	}
	
	public function getDocuments()
	{
		if( ! (($__userId = $this->getId()) > 0))
			return false;
		
		$__list = array();
		
		$__cond = array("user_id = :user_id");
		$__bind = array(
			"user_id" => $__userId
		);
		
		foreach(UsersDocsModel::i()->getList($__cond, $__bind) as $__id)
			$__list[] = UsersDocsModel::i()->getItem($__id, array("file"))["file"];
		
		return $__list;
	}
	
	public function setVerification($type, $comment, $decisionNumber = null, $userVerifierId = null)
	{
		if( ! (($__userId = $this->getId()) > 0))
			return false;
		
		if(is_null($userVerifierId))
			$userVerifierId = UserClass::i()->getId();
		
		UsersVerificationsModel::i()->insert(array(
			"user_id" => $__userId,
			"user_verifier_id" => $userVerifierId,
			"type" => $type,
			"decision_number" => $decisionNumber,
			"comment" => $comment
		));
	}
	
	public function getLastVerification()
	{
		if( ! (($__userId = $this->getId()) > 0))
			return false;
		
		$__cond = array("user_id = :user_id");
		$__bind = array(
			"user_id" => $__userId
		);
		$__order = array("created_at DESC");
		
		foreach(UsersVerificationsModel::i()->getList($__cond, $__bind, $__order, 1) as $__id)
			return UsersVerificationsModel::i()->getItem($__id);
		
		return null;
	}
	
	public function getLastVerificationType()
	{
		if( ! (($__userId = $this->getId()) > 0))
			return false;
		
		$__cond = array("user_id = :user_id");
		$__bind = array(
			"user_id" => $__userId
		);
		$__order = array("created_at DESC");
		
		foreach(UsersVerificationsModel::i()->getList($__cond, $__bind, $__order, 1) as $__id)
			return UsersVerificationsModel::i()->getItem($__id, array("type"))["type"];
		
		return 0;
	}
	
	public function isVerified($type = null)
	{
		if( ! (($__userId = $this->getId()) > 0))
			return false;
		
		$__cond = array("user_id = :user_id");
		$__bind = array(
			"user_id" => $__userId
		);
		
		if( ! is_null($type))
		{
			$__cond[] = "type = :type";
			$__bind["type"] = $type;
		}
		
		return (bool) (count(UsersVerificationsModel::i()->getList($__cond, $__bind, array(), 1)) > 0);
	}
}
