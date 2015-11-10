<?php

Loader::loadModule("Trainings");
Loader::loadClass("TrainingClass");
Loader::loadClass("OldGeoClass");

class IndexTrainingsController extends TrainingsController
{
	private function __viewListByLocation($location = array())
	{
		parent::setView("index/view_list_by_location");
		
		HeadClass::addLess("/less/frontend/trainings/index/view_list_by_location.less");
		
//		$regionId = isset($location["region_id"]) ? $location["region_id"] : 1505578;
//		$areaId = isset($location["area_id"]) ? $location["area_id"] : 314;
//		$cityId = isset($location["city_id"]) ? $location["city_id"] : 314;
		
		$__cond = array("is_public = 1");
		$__bind = array();
		
		foreach(array("region_id", "area_id", "city_id") as $__field)
		{
			if( ! isset($location[$__field]))
				continue;
			
			$__cond[] = $__field." = :".$__field;
			$__bind[$__field] = $location[$__field];
		}
		
		$this->trainings->list = TrainingsListModel::i()->getCompiledList($__cond, $__bind, array("happen_at DESC"));
		
		return true;
	}
	
	private function __viewItem($training)
	{
		parent::setView("index/view_item");
		
		HeadClass::addJs("/js/frontend/trainings/index/view_item.js");
		HeadClass::addLess("/less/frontend/trainings/index/view_item.less");
		
		$this->trainings->item = $training;
		
		return true;
	}

	public function execute($args = array())
	{
		parent::execute();
		
		$this->trainings = new stdClass();
		
		HeadClass::addLess(array(
			"/less/frontend/trainings/index.less"
		));
		
		if(
				isset($args[3])
				&& $args[3] > 0
				&& ($__training = TrainingsListModel::i()->getItem($args[3]))
		)
			return $this->__viewItem($__training);
		
		$__location = array();
		
		if(isset($args[0]) && $args[0] > 0)
			$__location["region_id"] = intval($args[0]);
		
		if(isset($args[1]) && $args[1] > 0)
			$__location["area_id"] = intval($args[1]);
		
		if(isset($args[2]) && $args[2] > 0)
			$__location["city_id"] = intval($args[2]);
		
		return $this->__viewListByLocation($__location);
	}
}
