<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class GeoRegionsModel extends ExtendedModel
{
	protected $table = "geo_regions";
	/**
	 * @param string $instance
	 * @return GeoRegionsModel
	 */
	public static function i($instance = "GeoRegionsModel")
	{
		return parent::i($instance);
	}
}
