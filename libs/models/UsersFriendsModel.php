<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class UsersFriendsModel extends ExtendedModel
{
	protected $table = "users_friends";
	
	/**
	 * @param string $instance
	 * @return UsersFriendsModel
	 */
	public static function i($instance = "UsersFriendsModel")
	{
		return parent::i($instance);
	}
	
	public function getFriends($userId)
	{
		$__cond = array("user_id = :user_id");
		$__bind = array("user_id" => $userId);
		$__order = array("id DESC");
		
		$__list = array();
		foreach(parent::getCompiledList($__cond, $__bind, $__order) as $__item)
			$__list[] = $__item["friend_id"];
		
		return $__list;
	}
	
	public function areFriends($user1, $user2)
	{
		$__cond = array("user_id = :user_id", "friend_id = :friend_id");
		$__bind = array(
			"user_id" => $user1,
			"friend_id" => $user2
		);
		
		return ($__list = UsersFriendsModel::i()->getList($__cond, $__bind, array(), 1))
				&& count($__list) > 0
				? true
				: false;
	}
}
