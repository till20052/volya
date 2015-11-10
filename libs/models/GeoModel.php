<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class GeoModel extends ExtendedModel
{
	protected $table = "geo";

	/**
	 * @param string $i
	 * @return GeoModel
	 */
	public static function i($i = "GeoModel")
	{
		return parent::i($i);
	}
}