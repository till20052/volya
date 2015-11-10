<?php

Loader::loadModule("Profile");

class ActivateProfileController extends ProfileController
{
	public function execute($args = array())
	{
		parent::execute();
		
		if(
				! isset($args[0])
				|| ! ($__item = UsersModel::i()->getItemByField("security_code", $args[0]))
				|| $__item["is_active"] != 0
		)
			parent::redirect("/");
		
		UsersModel::i()->update(array(
			"id" => $__item["id"],
			"is_active" => 1
		));
	}
}
