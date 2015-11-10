<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class GeoCountriesModel extends ExtendedModel
{
	protected $table = "geo_countries";
	/**
	 * @param string $instance
	 * @return GeoCountriesModel
	 */
	public static function i($instance = "GeoCountriesModel")
	{
		return parent::i($instance);
	}
}
