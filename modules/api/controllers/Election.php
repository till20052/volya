<?php

Loader::loadModule("Api");
Loader::loadClass("ElectionClass");

class ElectionApiController extends ApiController
{
	public function execute()
	{
		parent::execute();
	}
	
	public function jGetCountyNumbersByRegion()
	{
		parent::execute();
		
		if(
				($__geoKoatuuCode = stripslashes(Request::getString("geo_koatuu_code"))) == ""
				|| strlen($__geoKoatuuCode) != 10
		)
			return false;
		
		$this->json["list"] = ElectionClass::i()->getCountyNumbersByRegion($__geoKoatuuCode);
		
		return true;
	}
	
	public function jGetPollingPlacesByCountyNumber()
	{
		parent::execute();
		
		if( ! (($__countyNumber = Request::getInt("county_number")) > 0))
			return false;
		
		$this->json["list"] = ElectionClass::i()->getPollingPlacesByCountyNumber($__countyNumber);
		
		return true;
	}
}
