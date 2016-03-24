<?php

Loader::loadModule("Profile");
Loader::loadModel("UsersModel");
Loader::loadClass("UserClass");

class SignProfileController extends ProfileController
{
	public function getHtml($args = array())
	{
		parent::setLayout(false);
		
		if(
				! isset($args[0])
				|| ! in_array($args[0], array("login"))
		){
			parent::redirect("/errors/404");
		}
		
		parent::setView("sign/".$args[0]);
	}
	
	public function jIn()
	{
		parent::setViewer("json");
		
		$__cond = array("login = :login", "password = :password", "is_active = 1");
		$__bind = array(
			"login" => stripslashes(Request::getString("login")),
			"password" => md5(stripslashes(Request::getString("password")))
		);
		
		if( ! ($__item = ($__list = UsersModel::i()->getList($__cond, $__bind)) && count($__list) > 0 ? UsersModel::i()->getItem($__list[0]) : false))
		{
			return false;
		}
		
		UserClass::i()->authorize($__item, true);
		
		return true;
	}
	
	public function jOut()
	{
		parent::setViewer("json");
		UserClass::i()->clear();
		$this->json["success"] = true;
	}
}
