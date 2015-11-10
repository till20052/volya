<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class PollingPlacesModel extends ExtendedModel
{
	protected $table = "polling_places";
	/**
	 * 
	 * @param string $instance
	 * @return PollingPlacesModel
	 */
	public static function i($instance = "PollingPlacesModel")
	{
		return parent::i($instance);
	}
}
