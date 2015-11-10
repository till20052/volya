<?php

Loader::loadModule("Cells");
Loader::loadClass("OldGeoClass");
Loader::loadClass("UserClass");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadClass("CellClass");
Loader::loadModel("roep.RoepRegionsModel");
Loader::loadModel("roep.RoepPlotsModel");
Loader::loadModel("CellsModel");
Loader::loadModel("CellsMembersModel");
Loader::loadModel("CellsDocumentsModel");
Loader::loadModel("CellsVerifiedModel");
Loader::loadModel("CellsPollingPlacesModel");
Loader::loadModel("UsersVerifiedModel");
Loader::loadModel("PollingPlacesModel");

class ListCellsController extends CellsController
{
	
	private function __viewList()
	{
		parent::setView("index/list");
		parent::loadKendo(true);
		parent::loadWindow("cells/index/list/new_cell");
		parent::loadWindow("cells/index/list/roep_selection");
		parent::loadWindow("cells/index/users_finder");
		parent::loadWindow("cells/scan_uploader");
		
		HeadClass::addJs(array(
			"/js/frontend/cells/index/list.js"
		));
		
		HeadClass::addLess("/less/frontend/cells/index/list.less");
		
		$this->geo = array(
			"regions" => OldGeoClass::i()->getRegions(2)
		);
		
		$__regions = OldGeoClass::i()->getRegions(2);
		
		$this->roep = array(
			"regions" => $__regions
		);
		
		$__cond = null;
		$this->list = array();
		$this->filter = array();
		$this->geo["areas"] = array();
		$this->geo["areas_city"] = array();
		
		$this->filter["hide_filter"] = false;
		$this->filter["hide_areas"] = true;
		$this->filter["hide_cities"] = true;
		
		if(($__region = Request::getString("region", 0)) > 0)
		{
			$this->geo["areas"] = OldGeoClass::i()->getAreas(2, $__region);
			$this->filter["region"] = OldGeoClass::i()->getCity($__region);
			$this->filter["hide_filter"] = true;
			$this->filter["hide_areas"] = false;
			$this->filter["var"] = "region=".$__region;
			
			$__cond = array(
				"type" => "region",
				"value" => $__region
			);
			
			parent::addBreadcrumb("/cells/list/?region=".$__region, $this->filter["region"]["title"]);
		}
		
		if(($__area = Request::getString("area", 0)) > 0)
		{
			$this->geo["areas_city"] = OldGeoClass::i()->getAreaCities(2, $__area);
			$this->filter["region"] = OldGeoClass::i()->getCity($__area);
			$this->filter["hide_filter"] = true;
			$this->filter["hide_cities"] = false;
			$this->filter["var"] = "area=".$__area;
			
			$__cond = array(
				"type" => "area",
				"value" => $__area
			);
			
			$__region = OldGeoClass::i()->getRegion($__area);
			parent::addBreadcrumb("/cells/list/?region=".$__region["id"], $__region["title"]);
			parent::addBreadcrumb("/cells/list/?area=".$__area, $this->filter["region"]["title"]);
		}
		
		if(($__areaCity = Request::getString("area_city", 0)) > 0)
		{
			$this->filter["region"] = OldGeoClass::i()->getCity($__areaCity);
			$this->filter["hide_filter"] = true;
			$this->filter["var"] = "area_city=".$__areaCity;
			
			$__cond = $__areaCity;
			
			$__region = OldGeoClass::i()->getRegion($__areaCity);
			$__area = OldGeoClass::i()->getArea($__areaCity);
			parent::addBreadcrumb("/cells/list/?region=".$__region["id"], $__region["title"]);
			parent::addBreadcrumb("/cells/list/?area=".$__area["id"], $__area["title"]);
			parent::addBreadcrumb("/cells/list/?area_city=".$__areaCity, $this->filter["region"]["title"]);
		}
		
		if(($__city = Request::getString("city", 0)) > 0)
		{
			$this->filter["region"] = OldGeoClass::i()->getCity($__city);
			$this->filter["hide_filter"] = true;
			$this->filter["var"] = "area_city=".$__city;
			
			$__cond = array(
				"type" => "city",
				"value" => $__city
			);
			
			$__region = OldGeoClass::i()->getRegion($__city);
			parent::addBreadcrumb("/cells/list/?region=".$__region["id"], $__region["title"]);
			parent::addBreadcrumb("/cells/list/?city=".$__city, $this->filter["region"]["title"]);
		}
		
		if(($__cityDistrict = Request::getString("city_district", 0)) > 0)
		{
			$this->filter["region"] = OldGeoClass::i()->getCity($__cityDistrict);
			$this->filter["hide_filter"] = true;
			$this->filter["var"] = "city_district=".$__cityDistrict;
			
			$__cond = array(
				"type" => "city_district",
				"value" => $__cityDistrict
			);
		}
		
		$this->filter["verified"] = Request::getString("verified", 0);
		
		if( ! is_null($__cond) )
		{
			if(is_array($__cond))
			{
				$__sql = "SELECT `id` FROM cells WHERE ".OldGeoClass::getRegexp($__cond["type"], $__cond["value"], "geo_koatuu_code");
				
				$__col = CellsModel::i()->getRows($__sql);
				
				if($this->filter["verified"] == 1)
					$__sql .= " AND `id` IN (SELECT `cell_id` FROM `cells_verified`)";
				elseif($this->filter["verified"] == 2)
					$__sql .= " AND `id` NOT IN (SELECT `cell_id` FROM `cells_verified`)";
				
				if($this->filter["verified"] > 0)
					$__list = CellsModel::i()->getRows($__sql);
				else
					$__list = $__col;
				
				$this->verified = count(CellsModel::i()->getRows("SELECT `id` FROM `cells` WHERE `id` IN (SELECT `cell_id` FROM `cells_verified`) AND ".OldGeoClass::getRegexp($__cond["type"], $__cond["value"], "geo_koatuu_code")));
			}
			else
			{
				$__sql = "SELECT `id` FROM cells WHERE `geo_koatuu_code` = ".$__cond;
				
				$__col = CellsModel::i()->getRows($__sql);
				
				if($this->filter["verified"] == 1)
					$__sql .= " AND `id` IN (SELECT `cell_id` FROM `cells_verified`)";
				elseif($this->filter["verified"] == 2)
					$__sql .= " AND `id` NOT IN (SELECT `cell_id` FROM `cells_verified`)";
				
				if($this->filter["verified"] > 0)
					$__list = CellsModel::i()->getRows($__sql);
				else
					$__list = $__col;
				
				$this->verified = count(CellsModel::i()->getRows("SELECT `id` FROM `cells` WHERE `id` IN (SELECT `cell_id` FROM `cells_verified`) AND `geo_koatuu_code` = ".$__cond));
			}
			
			$this->unverified = count($__col) - $this->verified;
			$__pager = new PagerClass($__list, Request::getInt("page"), 15);
			foreach($__pager->getList() as $__item)
			{	
				$__item["verified"] = empty(CellsVerifiedModel::i()->getItemByField("cell_id", $__item["id"])) ? false : true;
				
				$__item["users"] = count(CellsMembersModel::i()->getListByField("cell_id", $__item["id"]));
				
				$__item["borders"] = "";
				foreach(CellsPollingPlacesModel::i()->getCompiledListByField("cell_id", $__item["id"]) as $__pollingPlace)
				{
					$__pollingPlace = PollingPlacesModel::i()->getItem($__pollingPlace["polling_place_id"]);
					$__item["borders"] .= $__pollingPlace["borders"];
				}
				
				$this->list[] = $__item;
			}
			
			$this->pager = $__pager;
		}
	}
	
	public function execute($args = array())
	{
		parent::execute();
		parent::addBreadcrumb("/cells", t("Осередки"));
		
		if( ! (count(UsersVerifiedModel::i()->getList(array("user_id = :user_id"), array("user_id" => UserClass::i()->getId()))) > 0))
			parent::redirect("/");
		
		$this->__viewList();
	}
}
