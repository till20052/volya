<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class GeoCitiesAreasModel extends ExtendedModel
{
	protected $table = "geo_cities_areas";
	/**
	 * @param string $instance
	 * @return GeoCitiesAreasModel
	 */
	public static function i($instance = "GeoCitiesAreasModel")
	{
		return parent::i($instance);
	}
}
