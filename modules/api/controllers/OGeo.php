<?php

Loader::loadModule("Api");
Loader::loadModel("geo.GeoCountriesModel");
Loader::loadModel("geo.GeoRegionsModel");
Loader::loadModel("geo.GeoCitiesModel");

class OGeoApiController extends ApiController
{
	private $__lang;
	
	public function __construct()
	{
		$this->__lang = Router::getLang();
		
		if(($__lang = stripslashes(Request::getString("lang"))) != "")
			$this->__lang = $__lang;
	}
	
	public function execute()
	{
		parent::execute();
	}
	
	public function jGetCountries()
	{
		parent::setViewer("json");
		
		$__list = array();
		
		foreach(GeoCountriesModel::i()->getList() as $__id)
			$__list[] = GeoCountriesModel::i()->getItem($__id, array("id", "title_".$this->__lang." AS title"));
		
		$this->json["countries"] = $__list;
		
		return true;
	}
	
	public function jGetRegions()
	{
		parent::setViewer("json");
		
		if(($__countryId = Request::getInt("country_id", -1)) == -1)
			return false;
		
		$__list = array();
		
		$__cond = array("geo_country_id = :geo_country_id");
		$__bind = array("geo_country_id" => $__countryId);
		
		foreach(GeoRegionsModel::i()->getList($__cond, $__bind) as $__id)
			$__list[] = GeoRegionsModel::i()->getItem($__id, array("id", "title_".$this->__lang." AS title"));
		
		$this->json["regions"] = $__list;
		
		return true;
	}
	
	public function jGetAreas()
	{
		parent::setViewer("json");
		
		if(
				($__countryId = Request::getInt("country_id", -1)) == -1
				|| ($__regionId = Request::getInt("region_id", -1)) == -1
		)
			return false;
		
		$__areas = array();
		
		$__bind = array(
			"geo_country_id" => $__countryId,
			"geo_region_id" => $__regionId
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
				GeoCitiesModel::i()->getCols($__sqlCities, $__bind),
				GeoCitiesModel::i()->getCols($__sqlAreas, $__bind)
		)) as $__id){
			$__area = GeoCitiesModel::i()->getItem($__id, array(
				"id",
				"important",
				"title_".$this->__lang." AS title",
				"area_".$this->__lang." AS area"
			));
			
//			if(strpos(mb_strtolower($__area["area"], "UTF-8"), "город") !== false)
//				continue;
			
			if(is_null($__area["area"]))
				unset($__area["area"]);
			
			$__areas[] = $__area;
		}
		
		$this->json["areas"] = $__areas;
		
		return true;
	}
	
	public function jGetCities()
	{
		parent::setViewer("json");
		
		if(($__countryId = Request::getInt("country_id", -1)) == -1)
			return false;
		
		$__cities = array();
		
		$__cond = array("geo_country_id = :geo_country_id");
		$__bind = array("geo_country_id" => $__countryId);
		
		if(($__q = stripslashes(Request::getString("q"))) != "")
			$__cond[] = "title_".$this->__lang." LIKE '".$__q."%'";
		
		if(($__regionId = Request::getInt("region_id", -1)) != -1)
		{
			$__cond[] = "geo_region_id = :geo_region_id";
			$__bind["geo_region_id"] = $__regionId;
		}
		else
			$__cond[] = "geo_region_id IS NULL";
		
		if(($__area = stripslashes(Request::getString("area"))) != "")
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
		
		$this->json["cities"] = $__cities;
		
		return true;
	}
	
	public function jGetCity()
	{
		parent::setViewer("json");
		
		if((
				$__cityId = Request::getInt("city_id", -1)) == -1
				|| ! ($__city = GeoCitiesModel::i()->getItem($__cityId, array(
					"id",
					"important",
					"title_".$this->__lang." AS title"
				)))
		)
			return false;
		
		$this->json["city"] = $__city;
		
		return true;
	}
	
}
