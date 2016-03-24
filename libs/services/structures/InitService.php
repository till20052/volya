<?php

namespace libs\services\structures;

\Loader::loadService("StructuresService");
use libs\services\StructuresService;

class InitService extends \Keeper
{

	private function __constructRerionsStructures()
	{
		$__regions = \GeoClass::i()->regions();

		foreach ($__regions as $__region) {
			StructuresService::i()->addStructure($__region["id"], StructuresService::LEVEL_REGION);

			$this->__constructCitiesWithDistrictsStructures($__region["id"]);
		}
	}

	private function __constructCitiesWithDistrictsStructures($region)
	{
		$__citiesWithDistricts = \GeoClass::i()->citiesWithDistricts($region);

		foreach ($__citiesWithDistricts as $__item) {

			if(
				count(\GeoClass::i()->cityDistricts($__item["id"])) > 0
				&& $__item["type"] == "city"
			)
				StructuresService::i()->addStructure($__item["id"], StructuresService::LEVEL_CITY_WITH_DISTRICTS);
			elseif(
				count(\GeoClass::i()->cityDistricts($__item["id"])) == 0
				&& $__item["type"] == "city"
			)
				StructuresService::i()->addStructure($__item["id"], StructuresService::LEVEL_CITY_WITHOUTH_DISTRICTS, ["not_in_area" => 1]);
			elseif($__item["type"] == "district")
				StructuresService::i()->addStructure($__item["id"], StructuresService::LEVEL_DISTRICT);

			if(
				count(\GeoClass::i()->cityDistricts($__item["id"])) > 0
				&& $__item["type"] == "city"
			)
				$this->__constructCitiesDistrictsStructures($__item["id"]);
			elseif($__item["type"] == "district")
				$this->__constructCitiesStructures($__item["id"]);
		}
	}

	private function __constructCitiesStructures($district)
	{
		$__cities = \GeoClass::i()->cities($district);

		if(count($__cities) > 0)
			foreach ($__cities as $__city)
				StructuresService::i()->addStructure($__city["id"], StructuresService::LEVEL_CITY_WITHOUTH_DISTRICTS);
	}

	private function __constructCitiesDistrictsStructures($city)
	{
		$__districts = \GeoClass::i()->cityDistricts($city);

		foreach ($__districts as $__district) {
			StructuresService::i()->addStructure($__district["id"], StructuresService::LEVEL_CITY_DISTRICT);
		}
	}

	/**
	 * @return InitService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function init()
	{
		$this->__constructRerionsStructures();
	}
}