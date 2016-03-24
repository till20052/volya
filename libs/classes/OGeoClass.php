<?php

Loader::loadClass("ExtendedClass", Loader::SYSTEM);
Loader::loadModel("geo.GeoCountriesModel");
Loader::loadModel("geo.GeoRegionsModel");
Loader::loadModel("geo.GeoCitiesModel");

class OGeoClass extends ExtendedClass
{
	private $__lang = "ua";
	/**
	 * @param string $instance
	 * @return OGeoClass
	 */
	public static function i($instance = "OGeoClass")
	{
		return parent::i($instance);
	}
	
	public function getCountries()
	{
		$__countries = array();
		
		foreach(GeoCountriesModel::i()->getList() as $__id)
			$__countries[] = GeoCountriesModel::i()->getItem($__id, array("id", "title_".$this->__lang." AS title"));
		
		return $__countries;
	}
	
	public function getRegions($countryId)
	{
		$__regions = array();
		
		$__cond = array("geo_country_id = :geo_country_id");
		$__bind = array("geo_country_id" => $countryId);
		
		foreach(GeoRegionsModel::i()->getList($__cond, $__bind) as $__id)
			$__regions[] = GeoRegionsModel::i()->getItem($__id, array("id", "title_".$this->__lang." AS title"));
		
		return $__regions;
	}
	
	public function getRegionById($regionId)
	{
		return GeoRegionsModel::i()->getItem($regionId, array("id", "title_".$this->__lang." AS title"));
	}
	
	public function getAreas($countryId, $regionId)
	{
		$__areas = array();
		
		$__bind = array(
			"geo_country_id" => $countryId,
			"geo_region_id" => $regionId
		);
		
		$__sqlAreas = "SELECT `id` "
				."FROM `geo_cities` "
				."WHERE `geo_country_id` = :geo_country_id AND `geo_region_id` = :geo_region_id "
				."GROUP BY `area_".$this->__lang."`";
		
		$__sqlCities = "SELECT `id` "
				."FROM `geo_cities` "
				."WHERE `geo_country_id` = :geo_country_id "
				."AND `geo_region_id` = :geo_region_id "
				."AND `important` = 1";
		
		foreach(array_unique(array_merge(
				GeoCitiesModel::i()->getCols($__sqlAreas, $__bind),
				GeoCitiesModel::i()->getCols($__sqlCities, $__bind)
		)) as $__id){
			$__area = GeoCitiesModel::i()->getItem($__id, array(
				"id",
				"important",
				"title_".$this->__lang." AS title",
				"area_".$this->__lang." AS area"
			));
			
			if(strpos(mb_strtolower($__area["area"], "UTF-8"), "город") !== false)
				continue;
			
			if(is_null($__area["area"]))
				unset($__area["area"]);
			
			$__areas[] = $__area;
		}
		
		return $__areas;
	}
	
	public function getCities($countryId, $q = "", $regionId = null, $area = "")
	{
		$__cities = array();
		
		$__cond = array("geo_country_id = :geo_country_id");
		$__bind = array("geo_country_id" => $countryId);
		
		if(($__q = stripslashes($q)) != "")
			$__cond[] = "title_".$this->__lang." LIKE '".$__q."%'";
		
		if( ! is_null($regionId))
		{
			$__cond[] = "geo_region_id = :geo_region_id";
			$__bind["geo_region_id"] = $regionId;
		}
		else
			$__cond[] = "geo_region_id IS NULL";
		
		if(($__area = stripslashes($area)) != "")
			$__cond[] = "area_".$this->__lang." LIKE '".$__area."%'";
		
		foreach(GeoCitiesModel::i()->getList($__cond, $__bind, array("title_".$this->__lang." ASC")) as $__id)
		{
			$__city = GeoCitiesModel::i()->getItem($__id, array(
				"id",
				"important",
				"title_".$this->__lang." AS title",
				"area_".$this->__lang." AS area"
			));
			
			if(is_null($__city["area"]))
				unset($__city["area"]);
			
			$__cities[] = $__city;
		}
		
		return $__cities;
	}
	
	public function getCityById($cityId)
	{
		return GeoCitiesModel::i()->getItem($cityId, array(
			"id",
			"geo_country_id AS country_id",
			"geo_region_id AS region_id",
			"title_".$this->__lang." AS title",
			"area_".$this->__lang." AS area",
			"region_".$this->__lang." AS region"
		));
	}
}
