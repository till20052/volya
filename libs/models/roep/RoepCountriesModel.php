<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class RoepCountriesModel extends ExtendedModel
{
	protected $table = "roep_countries";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	/**
	 * @param string $instance
	 * @return RoepCountriesModel
	 */
	public static function i($instance = "RoepCountriesModel")
	{
		return parent::i($instance);
	}
}
