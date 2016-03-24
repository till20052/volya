<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class RoepRegionsModel extends ExtendedModel
{
	protected $table = "roep_regions";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	/**
	 * @param string $instance
	 * @return RoepRegionsModel
	 */
	public static function i($instance = "RoepRegionsModel")
	{
		return parent::i($instance);
	}
}
