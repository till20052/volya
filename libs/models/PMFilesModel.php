<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class PMFilesModel extends ExtendedModel
{
	protected $table = "pm_files";
	protected $_specificFields = [
		"date" => ["created_at", "modified_at:force"]
	];
	/**
	 * @param string $i
	 * @return PMFilesModel
	 */
	public static function i($i = "PMFilesModel")
	{
		return parent::i($i);
	}
}