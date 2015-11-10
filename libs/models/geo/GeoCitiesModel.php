<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class GeoCitiesModel extends ExtendedModel
{
	protected $table = "geo_cities";
	/**
	 * @param string $instance
	 * @return GeoCitiesModel
	 */
	public static function i($instance = "GeoCitiesModel")
	{
		return parent::i($instance);
	}
}
