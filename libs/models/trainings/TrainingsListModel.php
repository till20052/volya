<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class TrainingsListModel extends ExtendedModel
{
	protected $table = "trainings_list";
	protected $_dateFormat = "Y-m-d H:i:s";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force", "happen_at"),
		"serialized" => array("title", "meta_title", "meta_description", "meta_keywords", "text")
	);
	/**
	 * @param string $instance
	 * @return TrainingsListModel
	 */
	public static function i($instance = "TrainingsListModel")
	{
		return parent::i($instance);
	}
}
