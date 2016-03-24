<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class TrainingsMembersModel extends ExtendedModel
{
	protected $table = "trainings_members";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	/**
	 * @param string $instance
	 * @return TrainingsMembersModel
	 */
	public static function i($instance = "TrainingsMembersModel")
	{
		return parent::i($instance);
	}
}
