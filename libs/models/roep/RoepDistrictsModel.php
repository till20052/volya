<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class RoepDistrictsModel extends ExtendedModel
{
	protected $table = "roep_districts";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	/**
	 * @param string $instance
	 * @return RoepDistrictsModel
	 */
	public static function i($instance = "RoepDistrictsModel")
	{
		return parent::i($instance);
	}
}
