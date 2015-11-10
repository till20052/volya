<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class GeoKoatuuModel extends ExtendedModel
{
	protected $table = "geo_koatuu";
	/**
	 * 
	 * @param string $instance
	 * @return GeoKoatuuModel
	 */
	public static function i($instance = "GeoKoatuuModel")
	{
		return parent::i($instance);
	}
	
	public function getItem($pkey, $fields = array(), $transformFields = array()) {
		if( ! ($__item = parent::getItem($pkey, $fields)))
			return $__item;
		
		foreach($transformFields as$__field)
		{
			if( ! isset($__item[$__field]))
				continue;
			
			$__item[$__field] = mb_substr($__item[$__field], 0, 1, "UTF-8")
					.mb_strtolower(mb_substr($__item[$__field], 1, null, "UTF-8"), "UTF-8");
		}
		
		return $__item;
	}
	
	public function getItemByCode($code, $options = array())
	{
		return parent::getItemByField("code", $code, $options);
	}
}
