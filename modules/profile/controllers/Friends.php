<?php

Loader::loadModule("Profile");
Loader::loadModel("UsersModel");
Loader::loadModel("UsersFriendsModel");
Loader::loadClass("UserClass");

class FriendsProfileController extends ProfileController
{
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadWindow("profile/friends/message_sender");
		
		HeadClass::addJs(array(
			"/js/form.js",
			"/js/frontend/profile/friends.js"
		));
		HeadClass::addCss(array(
			"/css/frontend/profile/friends.css"
		));
		HeadClass::addLess(array(
			"/less/frontend/profile/common/right_column.less"
		));
		
		$__list = UsersFriendsModel::i()->getFriends(UserClass::i()->getId());
		
		$__length = 10;
		$__step = Request::getInt("step") * $__length;
		
		if($__step > 0)
		{
			parent::setLayout(false);
			parent::setView("friends/table_rows");
		}
		
		$this->list = array();
		$this->count = count($__list);
		
		foreach(array_slice($__list, $__step, $__length) as $__id)
		{
			$this->list[] = UsersModel::i()->getItem($__id);
		}
	}
	
	public function jUnsubscribe()
	{
		parent::setViewer("json");
		
		if( ! UserClass::i()->isAuthorized())
			return false;
		
		$__id = Request::getInt("id");
		
		$__cond = array("user_id = :user_id", "friend_id = :friend_id");
		$__bind = array(
			"user_id" => UserClass::i()->getId(),
			"friend_id" => $__id
		);
		
		foreach(UsersFriendsModel::i()->getList($__cond, $__bind) as $__id)
		{
			UsersFriendsModel::i()->deleteItem($__id);
		}
		
		return true;
	}
}
