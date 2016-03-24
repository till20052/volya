<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class UsersContactsModel extends ExtendedModel
{
	protected $table = "users_contacts";
	
	/**
	 * @param string $instance
	 * @return UsersContactsModel
	 */
	public static function i($instance = "UsersContactsModel")
	{
		return parent::i($instance);
	}
	
	public function getEmails($userId)
	{
		$__cond = array("user_id = :user_id", "type = 'email'");
		$__bind = array("user_id" => $userId);
		
		return parent::getCompiledList($__cond, $__bind);
	}
	
	public function getPhones($userId)
	{
		$__cond = array("user_id = :user_id", "type = 'phone'");
		$__bind = array("user_id" => $userId);
		
		return parent::getCompiledList($__cond, $__bind);
	}
	
	public function isContactsSet($userId)
	{
		$__cond[] = "type LIKE :type";
		$__bind["type"] = "email";
		$__cond[] = "user_id = :user_id";
		$__bind["user_id"] = $userId;
		
		$__isEmailSet = (bool) parent::getList($__cond, $__bind, array(), 1);
		
		$__bind["type"] = "phone";
		
		$__isPhoneSet = (bool) parent::getList($__cond, $__bind, array(), 1);
		
		if( ! $__isEmailSet || ! $__isPhoneSet)
			return false;
		else
			return true;
	}
}
