<?php

Loader::loadClass("ExtendedClass", Loader::SYSTEM);
Loader::loadModel("geo.GeoCountriesModel");
Loader::loadModel("geo.GeoRegionsModel");
Loader::loadModel("geo.GeoAreasModel");
Loader::loadModel("geo.GeoCitiesModel");
Loader::loadModel("geo.GeoCitiesAreasModel");
Loader::loadModel("geo.GeoKoatuuModel");

class OldGeoClass extends ExtendedClass
{
	private $__lang = "ua";
	private $__countryId = 2;
	private $__templates = array(
		0 => array(
			"key" => "city",
			"pattern" => "(80|85){1}0{8}",
			"token" => "##0{8}"
		),
		1 => array(
			"key" => "city.district",
			"pattern" => "(80|85){1}3(0[1-9]|[1-9][1-9])0{5}",
			"token" => "#####0{5}",
		),
		2 => array(
			"key" => "city.district.location",
			"pattern" => "(80|85)3([0-9]{2}(1|6)[0-9]{2}00|[0-9]{6}[1-9]{1})",
			"token" => "##########",
		),
		
		3 => array(
			"key" => "region",
			"pattern" => "[0-9]{2}0{8}",
			"token" => "##0{8}"
		),
		4 => array(
			"key" => "city.district",
			"pattern" => "(80|85){1}3(0[1-9]|[1-9][1-9])0{5}",
			"token" => "#####0{5}",
		),
		5 => array(
			"key" => "city.district.location",
			"pattern" => "(80|85)3([0-9]{2}(1|6)[0-9]{2}00|[0-9]{6}[1-9]{1})",
			"token" => "##########",
		),
			
			"[0-9]{2}0{8}"										=> "region",
		
			"[0-9]{2}1(0[1-9]|[1-9][1-9])0{5}"					=> "region.city",
			
			"[0-9]{2}1[0-9]{2}3(0[1-9]|[1-9][1-9])00"	=> "region.city.district",
			"[0-9]{2}1([0-9]{2}((4|6|7)[0-9]{2}00|900[0-9]{2})|[0-9]{6}[1-9]{1})"	=> "region.city.location",
			
			"[0-9]{2}2[0-9]{2}0{5}"					=> "region.area",
			
			"[0-9]{2}2[0-9]{2}(4|5)[0-9]{4}"		=> "region.area.location",
			"[0-9]{2}2[0-9]{2}8[0-9]{3}[1-9]{1}"	=> "region.area.location",
			"[0-9]{2}2[0-9]{2}1[0-9]{2}00"			=> "region.area.city",
			"[0-9]{2}2[0-9]{2}1[0-9]{3}[1-9]{1}"	=> "region.area.city.location",
		);
	
	private function __getItemByCode($code, $start, $length, $cond)
	{
		$__item = false;
		
		$__cond = array(
			"geo_country_id = :geo_country_id",
			"code REGEXP '".substr($code, $start, $length).$cond."'"
		);
		$__bind = array("geo_country_id" => $this->__countryId);
		
		foreach(GeoKoatuuModel::i()->getList($__cond, $__bind, array(), 1) as $__id)
			$__item = GeoKoatuuModel::i()->getItem($__id, array(
				"code AS id",
				"title_".$this->__lang." AS title"
			), array("title"));
		
		$__item["title"] = $this->__formatTitle($__item["title"]);
		
		return $__item;
	}
	
	private function __formatTitle($title)
	{
		$__title = $title;
		
		$__tokens = preg_split("/\-|\s/", $title);
		
		foreach($__tokens as $__token)
		{
			if(in_array(mb_strtolower($__token, "UTF-8"), ["область", "район"]))
				$__value = mb_strtolower($__token, "UTF-8");
			else
				$__value = mb_strtoupper(mb_substr($__token, 0, 1, "UTF-8"), "UTF-8")
					.mb_strtolower(mb_substr($__token, 1, null, "UTF-8"), "UTF-8");
			
			$__title = str_replace($__token, $__value, $__title);
		}
		
		return $__title;
	}

	/**
	 * @param string $instance
	 * @return OldGeoClass
	 */
	public static function i($instance = "OldGeoClass")
	{
		return parent::i($instance);
	}
	
	/*public static function getRegexp($type, $value, $field = null)
	{
		$__regexp = "";
		switch ($type)
		{
			case "region":
				$__regexp = substr($value, 0, 2)."([0-9]){8}";
				break;
			case "city":
				$__regexp = substr($value, 0, 2)."1([0-9]){7}";
				break;
			case "area":
				$__regexp = substr($value, 0, 2)."2([0-9]){7}";
				break;
			case "city_district":
				if(in_array(substr($value, 0, 2), array("80", "85")))
					$__regexp = substr($value, 0, 5)."([0-9]){5}";
				else
					$__regexp = substr($value, 0, 2)."1".substr($value, 3, 5)."([0-9]){2}";
				break;
		}
		
		if( ! is_null($field))
			return $field." REGEXP '".$__regexp."'";
		
		return $__regexp;
	}
	
	public function getCountries()
	{
		$__countries = array();
		
		$__cond = array()
		
		GeoKoatuuModel::i()->getList();
		
		foreach(GeoCountriesModel::i()->getList() as $__id)
			$__countries[] = GeoCountriesModel::i()->getItem($__id, array("id", "title_".$this->__lang." AS title"));
		
		return $__countries;
	}*/
	
	public function getRegions($countryId = 2)
	{
		$__regions = array();
		
		$__cond = array(
			"geo_country_id = :geo_country_id",
			"code REGEXP '([0-9]){2}(0){8}'"
		);
		$__bind = array("geo_country_id" => $countryId);
		
		foreach(GeoKoatuuModel::i()->getList($__cond, $__bind, array("title_".$this->__lang)) as $__id)
		{
			$__region = GeoKoatuuModel::i()->getItem($__id, array("code AS id", "title_".$this->__lang." AS title"));
			
			$__region["title"] = $this->__formatTitle($__region["title"]);
			
//			$__region["title"] = mb_substr($__region["title"], 0, 1, "UTF-8")
//					.mb_strtolower(mb_substr($__region["title"], 1, null, "UTF-8"), "UTF-8");
			
			$__regions[] = $__region;
		}
		
		return $__regions;
	}
	
	public function getRegionById($regionId)
	{
		return GeoKoatuuModel::i()->getItemByCode($regionId, array("code AS id", "title_".$this->__lang." AS title"));
	}
	
	public function getRegion($regionCode)
	{
		return $this->__getItemByCode($regionCode, 0, 2, "(0){8}");
	}
	
	public function getAreas($countryId, $regionCode)
	{
		$__areas = array();
		
		$__cond = array(
			"geo_country_id = :geo_country_id",
			"code REGEXP '".substr($regionCode, 0, 2)."2([0-9]){2}00000'"
		);
		$__bind = array("geo_country_id" => $countryId);
		
		foreach(GeoKoatuuModel::i()->getList($__cond, $__bind) as $__id){
			$__area = GeoKoatuuModel::i()->getItem($__id, array(
				"code AS id",
				"title_".$this->__lang." AS title"
			));
			
			if(strpos($__area["id"], "0000000") !== false)
				continue;
			
			$__area["title"] = $this->__formatTitle($__area["title"]);
			
//			$__area["title"] = mb_substr($__area["title"], 0, 1, "UTF-8")
//					.mb_strtolower(mb_substr($__area["title"], 1, null, "UTF-8"), "UTF-8");
			
			$__areas[] = $__area;
		}
		
		return $__areas;
	}
	
	public function getArea($areaCode)
	{
		return $this->__getItemByCode($areaCode, 0, 5, "(0){5}");
	}
	
	public function getAreaCities($countryId, $areaCode)
	{
		$__areaCities = array();
		
		$__cond = array(
			"geo_country_id = :geo_country_id",
			"code REGEXP '".substr($areaCode, 0, 5)."([1-9])([0-9])([1-9])([0-9])([1-9])'"
		);
		$__bind = array("geo_country_id" => $countryId);
		$__order = array("title_".$this->__lang." ASC");
		
		foreach(GeoKoatuuModel::i()->getList($__cond, $__bind, $__order) as $__id)
		{
			$__areaCity = GeoKoatuuModel::i()->getItem($__id, array(
				"code AS id",
				"title_".$this->__lang." AS title"
			));
			
			$__areaCity["title"] = $this->__formatTitle($__areaCity["title"]);
			
			$__areaCities[] = $__areaCity;
		}
		
		return $__areaCities;
	}
	
	public function getCity($cityCode)
	{
		if( ! ($__city = $this->__getItemByCode($cityCode, 0, 10, "")))
			return $__city;
		
		if(
				($__region = $this->getRegion($__city["id"])) != false
				&& $__region["title"] != $__city["title"]
		)
			$__city["region"] = $__region["title"];

		if(
				($__area = $this->getArea($__city["id"])) != false
				&& $__city["title"] != $__area["title"]
		)
			$__city["area"] = $__area["title"];
		
		return $__city;
	}
	
	public function getCities($countryId, $regionCode = null, $areaCode = null)
	{
		$__cities = array();
		
		$__cond = array("geo_country_id = :geo_country_id");
		$__bind = array("geo_country_id" => $countryId);
		
		if( ! is_null($regionCode) && is_null($areaCode))
			$__cond[] = "code REGEXP '".substr($regionCode, 0, 2)."1(0[1-9]|[1-9][0-9])00000'";
		elseif( ! is_null($areaCode))
		{
			$__cond[] = "code REGEXP '".substr($areaCode, 0, 5);
			switch(intval(substr($areaCode, 2, 1)))
			{
				case 1:
					$__cond[count($__cond)-1] .= "3([0-9])([1-9])([0-9]){2}'";
					break;
				
				case 2:
					$__cond[count($__cond)-1] .= "8([0-9])([1-9])([0-9])([1-9])'";
					break;
				
				default:
					$__cond[count($__cond)-1] .= "([0-9]){5}'";
					break;
			}
		}
		
		foreach(GeoKoatuuModel::i()->getList($__cond, $__bind, array("title_".$this->__lang." ASC")) as $__id)
		{
			$__city = GeoKoatuuModel::i()->getItem($__id, array(	
				"code AS id",
				"title_".$this->__lang." AS title"
			));
			
			$__city["title"] = $this->__formatTitle($__city["title"]);
			
//			$__city["title"] = mb_substr($__city["title"], 0, 1, "UTF-8")
//					.mb_strtolower(mb_substr($__city["title"], 1, null, "UTF-8"), "UTF-8");
			
			$__cities[] = $__city;
		}
		
		return $__cities;
	}
	
	public function getCityAreas($countryId, $cityCode)
	{
		$__cityAreas = array();
		
		$__cond = array(
			"geo_country_id = :geo_country_id",
			"code REGEXP '"
		);
		
		if(in_array(substr($cityCode, 0, 2), array("80", "85")))
			$__cond[count($__cond) - 1] .= substr($cityCode, 0, 2)."3(0[1-9]|[1-9][0-9])(0){5}'";
		else
			$__cond[count($__cond) - 1] .= substr($cityCode, 0, 5)."3([0-9])([1-9])([0-9]){2}'";
		
		$__bind = array("geo_country_id" => $countryId);
		
		foreach(GeoKoatuuModel::i()->getList($__cond, $__bind) as $__id)
		{
			$__cityArea = GeoKoatuuModel::i()->getItem($__id, array(
				"code AS id",
				"title_".$this->__lang." AS title"
			));
			
			$__cityArea["title"] = $this->__formatTitle($__cityArea["title"]);
			
//			$__cityArea["title"] = mb_substr($__cityArea["title"], 0, 1, "UTF-8")
//					.mb_strtolower(mb_substr($__cityArea["title"], 1, null, "UTF-8"), "UTF-8");
			
			$__cityAreas[] = $__cityArea;
		}
		
		return $__cityAreas;
	}
	
	public function findCities($q, $regionCode = null, $regionTitle = null, $areaTitle = null)
	{
		$__cities = array();
		$__forcedities = array();
		
		$__cond = array("title_".$this->__lang." LIKE '".str_replace("'", "\'", $q)."%'");
		
		$__regexp = "(`code` REGEXP '";
		if( ! is_null($regionCode))
			$__regexp .= substr($regionCode, 0, 2);
		else
			$__regexp .= "[0-9]{2}";
		
		$__regexp .= "[1-3](0[1-9]|[1-9][0-9])[0-9]{5}'";

		if(is_null($regionCode))
			$__regexp .= " OR `code` REGEXP '(80|85)[0-9]{8}'";

		$__regexp .= ")";

		$__cond[] = $__regexp;
		
		foreach(GeoKoatuuModel::i()->getList($__cond) as $__id)
		{
			$__city = GeoKoatuuModel::i()->getItem($__id, array(
				"code AS id",
				"title_".$this->__lang." AS title"
			));
			
			$__city["title"] = $this->__formatTitle($__city["title"]);
			
			if(($__region = $this->getRegion($__city["id"])) != false)
				$__city["region"] = $__region["title"];
			
//			if(
//					! is_null($regionTitle)
//					&& mb_strpos(mb_strtolower($__city["region"], "UTF-8"), mb_strtolower($regionTitle, "UTF-8"), 0, "UTF-8") === false
//					&& ! in_array(substr($__city["id"], 0, 2), ["80", "85"])
//			)
//				continue;
			
			if(
					($__area = $this->getArea($__city["id"])) != false
					&& $__city["title"] != $__area["title"]
			)
				$__city["area"] = $__area["title"];
			
			$__cities[] = $__city;
			
			if(
					$__city["title"] == $__city["region"]
					|| mb_strtolower($__city["title"], "UTF-8") == mb_strtolower($q, "UTF-8")
			){
				if($__city["title"] == $__city["region"])
					unset($__city["region"]);
				
				$__forcedities[] = $__city;
			}
		}
		
		return count($__forcedities) > 0 ? $__forcedities : $__cities;
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
	
	public function getCodeByName($name)
	{
		$__cond = array("title_".$this->__lang." LIKE :name");
		$__bind["name"] = $name;
		$__list = GeoKoatuuModel::i()->getCompiledList($__cond, $__bind);
		return $__list[0]["code"];
	}
	
	public function getTypeByCode($code)
	{	
		foreach($this->__templates as $__template => $__type)
			if( preg_match("/".$__template."/", $code) )
			{
				$this->getRegexp($code, $__type);
				return;
			}
	}
	
	public function getRegexp($code, $type)
	{
		$__templates = array_flip($this->__templates);
		
		$__childTemplates = array();
		foreach($this->__templates as $__template => $__key)
			if(
					($__key != $type)
					&& (strpos($__key, $type) === 0)
			)
			{
				
				$__source = explode(".", $type);
				$__childTemplate = explode(".", $__key);
				$__childTemplate = $__childTemplate[count($__source)];
				
				$__childTemplates[$__templates[$type.".".$__childTemplate]] = $type.".".$__childTemplate;
			}
		
		foreach($__childTemplates as $__template => $__key)
		{
//			preg_filter($__template, "", $code);
			
			Console::log("/".$__template."/", $code);
			
			$__templatePices = explode( "}", $__template);
			$__regexp = array();
			$__tempCode = $code;
			
			for($__i = 0; $__i <= count(explode(".", $type)); $__i++)
			{
				$__regexpTemp = "";
				if(strpos($__templatePices[$__i], "(") !== false)
				{
					$__regexp[] = substr($__tempCode, 0, 2);
					$__tempCode = substr($__tempCode, 2, strlen($__tempCode) - 2);
				}
				else if(
						($__pos = strpos($__templatePices[$__i], "{")) !== false
						&& $__templatePices[$__i] != ""
				)
				{
					$__len = (int) substr($__templatePices[$__i], $__pos + 1, 1);
					$__pos = strpos($__templatePices[$__i], "[");
					
					if(($__pos = strpos($__templatePices[$__i], "[")) > 0)
						$__regexpTemp = substr($__templatePices[$__i], 0, $__pos).$__regexpTemp;
					
					$__regexp[] = $__regexpTemp.substr($__tempCode, $__pos, $__len);
					$__tempCode = substr($__tempCode, $__len, strlen($__tempCode) - 2);
				}
			}
			
			$__regexpTemp = "";
			for($__i = count($__templatePices) - 1; $__i >= 0; $__i--)
			{
				if(strpos($__templatePices[$__i], "{") === false)
					$__regexpTemp .= $__templatePices[$__i];
				else
				{
					$__regexp[] = $__templatePices[$__i]."}";
					$__i = 0;
				}
			}
			$__regexp[] = $__regexpTemp;
			
			Console::log(implode("", $__regexp));
		}
		
		Console::log($__childTemplates);
	}
}
