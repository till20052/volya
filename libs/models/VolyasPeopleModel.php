<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class VolyasPeopleModel extends ExtendedModel
{
	protected $table = "volyas_people";
	protected $_specificFields = array(
		"date" => array("created_at")
	);
	/**
	 * 
	 * @param string $instance
	 * @return VolyasPeopleModel
	 */
	public static function i($instance = "VolyasPeopleModel")
	{
		return parent::i($instance);
	}
}
