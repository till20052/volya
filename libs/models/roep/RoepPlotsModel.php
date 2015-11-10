<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class RoepPlotsModel extends ExtendedModel
{
	protected $table = "roep_plots";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	/**
	 * @param string $instance
	 * @return RoepPlotsModel
	 */
	public static function i($instance = "RoepPlotsModel")
	{
		return parent::i($instance);
	}
}
