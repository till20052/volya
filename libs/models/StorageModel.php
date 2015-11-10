<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class StorageModel extends ExtendedModel
{
	protected $table = "storage";
	protected $_specificFields = array(
		"date" => array("created_at")
	);
	/**
	 * 
	 * @param string $instance
	 * @return StorageModel
	 */
	public static function i($instance = "StorageModel")
	{
		return parent::i($instance);
	}
	
	public function getItemByHash($hash)
	{
		return parent::getItemByField("hash", $hash);
	}
}
