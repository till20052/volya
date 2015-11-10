<?php

Loader::loadModule("Api");
Loader::loadModel("roep.RoepCountriesModel");
Loader::loadModel("roep.RoepRegionsModel");
Loader::loadModel("roep.RoepDistrictsModel");
Loader::loadModel("roep.RoepPlotsModel");

class RoepApiController extends ApiController
{
	public function execute()
	{
		parent::execute();
	}
	
	public function jGetCountries()
	{
		parent::setViewer("json");
		
		$this->json["countries"] = RoepCountriesModel::i()->getCompiledList();
		
		return true;
	}
	
	public function jGetDistricts()
	{
		parent::setViewer("json");
		
		if(($__regionId = Request::getInt("region_id", -1)) == -1)
			return false;
		
		$__districts = array();
		
		$__cond = array("roep_region_id = :roep_region_id");
		$__bind = array("roep_region_id" => $__regionId);
		
		foreach(RoepDistrictsModel::i()->getList($__cond, $__bind) as $__id)
			$__districts[] = RoepDistrictsModel::i()->getItem($__id, array(
				"id",
				"number",
				"description"
			));
		
		$this->json["districts"] = $__districts;
		
		return true;
	}
	
	public function jGetPlots()
	{
		parent::setViewer("json");
		
		if(
				($__regionId = Request::getInt("region_id", -1)) == -1
				|| ($__districtId = Request::getInt("district_id", -1)) == -1
		)
			return false;
		
		$__plots = array();
		
		$__cond = array(
			"roep_region_id = :roep_region_id",
			"roep_district_id = :roep_district_id"
		);
		$__bind = array(
			"roep_region_id" => $__regionId,
			"roep_district_id" => $__districtId
		);
		
		foreach(RoepPlotsModel::i()->getList($__cond, $__bind) as $__id)
			$__plots[] = RoepPlotsModel::i()->getItem($__id, array(
				"id",
				"number",
				"borders",
				"address"
			));
		
		$this->json["plots"] = $__plots;
		
		return true;
	}
}
