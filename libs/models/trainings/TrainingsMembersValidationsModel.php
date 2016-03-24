<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class TrainingsMembersValidationsModel extends ExtendedModel
{
	protected $table = "trainings_members_validations";
	protected $_specificFields = array(
		"date" => array("created_at")
	);
	/**
	 * @param string $instance
	 * @return TrainingsMembersValidationsModel
	 */
	public static function i($instance = "TrainingsMembersValidationsModel")
	{
		return parent::i($instance);
	}
	
	
}
