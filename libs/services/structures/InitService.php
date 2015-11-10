<?php

namespace libs\services\structures;

\Loader::loadService("StructuresService");

use libs\services\StructuresService;

class InitService extends StructuresService
{

	public function constructRerionsStructures()
	{
		$__regions = \GeoClass::i()->regions();

		foreach ($__regions as $__region) {
			parent::addStructure($__region["id"], 1);

			$this->constructCitiesWithDistrictsStructures($__region["id"]);
		}
	}

	public function constructCitiesWithDistrictsStructures($region)
	{
		$__citiesWithDistricts = \GeoClass::i()->citiesWithDistricts($region);

		foreach ($__citiesWithDistricts as $__item) {
			parent::addStructure($__item["id"], $__item["type"] == "city" ? 2 : 3);

			if($__item["type"] == "district")
				$this->constructCitiesStructures($__item["id"]);
			else
				$this->constructCitiesDistrictsStructures($__item["id"]);
		}
	}

	public function constructCitiesStructures($district)
	{
		$__cities = \GeoClass::i()->cities($district);

		if(count($__cities) > 0)
			foreach ($__cities as $__city)
				parent::addStructure($__city["id"], 5);
	}

	public function constructCitiesDistrictsStructures($city)
	{
		$__districts = \GeoClass::i()->cityDistricts($city);

		foreach ($__districts as $__district) {
			parent::addStructure($__district["id"], 4);
		}
	}
}