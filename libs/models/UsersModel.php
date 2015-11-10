<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);
Loader::loadClass("UserClass");
Loader::loadModel("UsersContactsModel");

class UsersModel extends ExtendedModel
{
	protected $table = "users";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force", "activated_at"),
		"md5" => array("password")
	);
	
	private static $__credentials = array(
		0 => "Користувач",
		774 => "Модератор",
		775 => "Адміністратор",
		777 => "Суперадміністратор"
	);
	
	/**
	 * @param string $instance
	 * @return UsersModel
	 */
	public static function i($instance = "UsersModel")
	{
		return parent::i($instance);
	}
	
	public static function getCredentials()
	{
		return self::$__credentials;
	}

	public function getItem($pkey, $fields = array())
	{
		if( ! ($__item = parent::getItem($pkey, $fields)))
			return $__item;
		
		if(
				! (count($fields) > 0)
				|| (in_array("first_name", $fields) && in_array("last_name", $fields) && in_array("middle_name", $fields))
		){
			$__item["name"] = UserClass::getNameByItem($__item);
		}
		
		return $__item;
	}
	
	public function getItemByLogin($login)
	{
		return $this->getItemByField("login", $login);
	}
	
//	public function getItemByActivationKey($activationKey)
//	{
//		return $this->getItemByField("activation_key", $activationKey);
//	}
	
	public function deleteItem($pkey)
	{
		parent::deleteItem($pkey);
	}
	
	public function setContacts($userId, $type, $contacts)
	{
		$__cond = array(
			"user_id = :user_id",
			"type = :type"
		);
		$__bind = array(
			"user_id" => $userId,
			"type" => $type
		);
		
		foreach(UsersContactsModel::i()->getList($__cond, $__bind) as $__id)
			UsersContactsModel::i()->deleteItem($__id);
		
		foreach($contacts as $__contact)
		{
			UsersContactsModel::i()->insert(array(
				"user_id" => $userId,
				"type" => $type,
				"value" => $__contact
			));
		}
	}
	
	public function getContacts($userId, $type = null)
	{
		$__list = array();
		
		$__cond = array("user_id = :user_id");
		$__bind = array("user_id" => $userId);
		
		if( ! is_null($type))
		{
			$__cond[] = "type = :type";
			$__bind["type"] = $type;
		}
		
		foreach(UsersContactsModel::i()->getCompiledList($__cond, $__bind) as $__contact)
			$__list[] = $__contact["value"];
		
		return $__list;
	}
}
