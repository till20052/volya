<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class UsersVerificationsModel extends ExtendedModel
{
	protected $table = "users_verifications";
	protected $_specificFields = array(
		"date" => array("created_at:force")
	);
	
	/**
	 * @param string $instance
	 * @return UsersVerificationsModel
	 */
	public static function i($instance = "UsersVerificationsModel")
	{
		return parent::i($instance);
	}
}
