<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class GeoAreasModel extends ExtendedModel
{
	protected $table = "geo_areas";
	/**
	 * @param string $instance
	 * @return GeoAreasModel
	 */
	public static function i($instance = "GeoAreasModel")
	{
		return parent::i($instance);
	}
}
