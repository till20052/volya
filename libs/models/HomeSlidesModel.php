<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class HomeSlidesModel extends ExtendedModel
{
	protected $table = "home_slides";
	protected $_specificFields = array(
			"serialized" => array("title", "description"),
			"date" => array("created_at", "modified_at:force")
	);
	
	/**
	 * 
	 * @param string $instance
	 * @return HomeSlidesModel
	 */
	public static function i($instance = "HomeSlidesModel")
	{
		return parent::i($instance);
	}
}
