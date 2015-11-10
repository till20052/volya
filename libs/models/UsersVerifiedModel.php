<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class UsersVerifiedModel extends ExtendedModel
{
	protected $table = "users_verifications";
	protected $_specificFields = array(
		"date" => array("created_at:force")
	);
	
	/**
	 * @param string $instance
	 * @return UsersVerifiedModel
	 */
	public static function i($instance = "UsersVerifiedModel")
	{
		return parent::i($instance);
	}
}
