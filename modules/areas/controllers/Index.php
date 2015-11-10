<?php

Loader::loadModule("Areas");
Loader::loadModel("RoepRegionsModel");
Loader::loadModel("RoepDistrictsModel");
Loader::loadModel("RoepPlotsModel");
Loader::loadModel("RoepCountriesModel");

class IndexAreasController extends AreasController
{
	
	public function execute()
	{
		parent::execute();
		
		HeadClass::addJs("/js/frontend/areas/index.js");
		
		$this->test = file_get_contents( "https://www.drv.gov.ua/portal/!cm_core.cm_index?option=ext_dvk&prejim=3&pmn_id=132" );
		$this->test = iconv("windows-1251", "utf-8", $this->test);
	}
	
	public function setRegions()
	{
		$__plotsList = RoepPlotsModel::i()->getCompiledList();
		
		foreach ($__plotsList as $plot)
		{
			$region = RoepDistrictsModel::i()->getItem( $plot["roep_district_id"] );
			
			$data = array(
				"roep_region_id" => $region["roep_region_id"]
			);
			
			RoepPlotsModel::i()->update(array_merge(array("id" => $plot["id"]), $data) );
		}
	}

	public function jAddCountry()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		$__country = RoepCountriesModel::i()->getItemByField("name", Request::getString("country"));
		
		$__data = array(
			"name" => Request::getString("country")
		);

		$__country_id = $__country["id"];
		
		if( ! $__country && Request::getString("country") != "" )
			$__country_id = RoepCountriesModel::i()->insert($__data);

		$__data = array(
			"number" => Request::getString("plot"),
			"borders" => Request::getString("borders"),
			"address" => Request::getString("address"),
			"size" => strtolower(Request::getString("type")),
			"roep_country_id" => $__country_id
		);

		RoepPlotsModel::i()->insert($__data);
	}
	
	public function jAddRegion()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		if( Request::getString("link") ){
			$content = file_get_contents( "https://www.drv.gov.ua/portal/".Request::getString("link") );
			$this->json["content"] = iconv("windows-1251", "utf-8", $content);
		}
	}
	
	public function jAddDistrict()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		if( Request::getString("link") ){
			$__data = array(
				"name" => Request::getString("name"),
				"description" => Request::getString("descr"),
				"region" => Request::getInt("region")
			);

			$this->json["id"] = DistrictsModel::i()->insert($__data);
		
			$content = file_get_contents( "https://www.drv.gov.ua/portal/".Request::getString("link") );
			$this->json["content"] = iconv("windows-1251", "utf-8", $content);
		}
	}
	
	public function jAddArea()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
				
		if( Request::getString("name") && Request::getString("district") ){
			$__data = array(
				"name" => Request::getString("name"),
				"borders" => Request::getString("borders"),
				"address" => Request::getString("address"),
				"type" => strtolower(Request::getString("type")),
				"district" => Request::getInt("district")
			);

			AreasModel::i()->insert($__data);
		}
	}
}
