<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class TeamModel extends ExtendedModel
{
	protected $table = "team";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force", "age"),
		"serialized" => array("name", "job", "slogan", "bio", "links")
	);
	
	/**
	 * @param string $instance
	 * @return UsersModel
	 */
	public static function i($instance = "TeamModel")
	{
		return parent::i($instance);
	}
}
