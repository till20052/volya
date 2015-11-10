<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class PMGroupsModel extends ExtendedModel
{
	protected $table = "pm_groups";
	protected $_specificFields = [
		"date" => ["created_at", "modified_at:force"]
	];
	/**
	 * @param string $i
	 * @return PMGroupsModel
	 */
	public static function i($i = "PMGroupsModel")
	{
		return parent::i($i);
	}
}