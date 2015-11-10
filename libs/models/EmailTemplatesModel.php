<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class EmailTemplatesModel extends ExtendedModel
{
	protected $table = "email_templates";
	protected $_specificFields = array(
		"serialized" => array("from", "subject", "message"),
		"date" => array("created_at", "modified_at:force")
	);
	
	/**
	 * @param string $instance
	 * @return EmailTemplatesModel
	 */
	public static function i($instance = "EmailTemplatesModel")
	{
		return parent::i($instance);
	}
	
	public function getItemBySymlink($symlink)
	{
		return parent::getItemByField("symlink", $symlink);
	}
}
