<?php

namespace libs\services\structures;

\Loader::loadService("StructuresService");
use libs\services\StructuresService;

class InitService
{

	public function constructRerionsStructures()
	{
		$__regions = \GeoClass::i()->regions();

		foreach ($__regions as $__region) {
			parent::addStructure($__region["id"], StructuresService::LEVEL_PRIMARY);

			$this->constructCitiesWithDistrictsStructures($__region["id"]);
		}
	}

	public function constructCitiesWithDistrictsStructures($region)
	{
		$__citiesWithDistricts = \GeoClass::i()->citiesWithDistricts($region);

		foreach ($__citiesWithDistricts as $__item) {

			if(
				count(\GeoClass::i()->cityDistricts($__item["id"])) > 0
				&& $__item["type"] == "city"
			)
				parent::addStructure($__item["id"], StructuresService::LEVEL_CITY_WITH_DISTRICTS);
			elseif(
				count(\GeoClass::i()->cityDistricts($__item["id"])) == 0
				&& $__item["type"] == "city"
			)
				parent::addStructure($__item["id"], StructuresService::LEVEL_CITY_WITHOUTH_DISTRICTS);
			elseif($__item["type"] == "district")
				parent::addStructure($__item["id"], StructuresService::LEVEL_DISTRICT);

			if(
				count(\GeoClass::i()->cityDistricts($__item["id"])) > 0
				&& $__item["type"] == "city"
			)
				$this->constructCitiesDistrictsStructures($__item["id"]);
			elseif($__item["type"] == "district")
				$this->constructCitiesStructures($__item["id"]);
		}
	}

	public function constructCitiesStructures($district)
	{
		$__cities = \GeoClass::i()->cities($district);

		if(count($__cities) > 0)
			foreach ($__cities as $__city)
				parent::addStructure($__city["id"], StructuresService::LEVEL_CITY_WITHOUTH_DISTRICTS);
	}

	public function constructCitiesDistrictsStructures($city)
	{
		$__districts = \GeoClass::i()->cityDistricts($city);

		foreach ($__districts as $__district) {
			parent::addStructure($__district["id"], StructuresService::LEVEL_CITY_DISTRICT);
		}
	}
}