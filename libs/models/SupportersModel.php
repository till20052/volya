<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class SupportersModel extends ExtendedModel
{
	protected $table = "supporters";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	
	/**
	 * @param string $instance
	 * @return SupportersModel
	 */
	public static function i($instance = "SupportersModel")
	{
		return parent::i($instance);
	}
}
