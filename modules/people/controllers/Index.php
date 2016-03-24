<?php

Loader::loadModule("People");
Loader::loadModel("UsersModel");
Loader::loadModel("UsersFriendsModel");
Loader::loadClass("UserClass");
Loader::loadClass("VKApiClass", Loader::SYSTEM);
Loader::loadClass("OldGeoClass");

class IndexPeopleController extends PeopleController
{
	public function execute()
	{
		parent::execute();
		parent::loadKendo(TRUE);
		
		HeadClass::addJs("/js/frontend/people/index.js");
		HeadClass::addLess("/less/frontend/people/index.less");
		
		$__cond = array();
		$__bind = array();
		
		$this->regionId = 0;
		$this->areaId = 0;
		$this->cityId = 0;
		
		$this->regions = array();
		
		if(($this->regionId = Request::getInt("rid")) > 0)
		{
			$__cond[] = "region_id = :region_id";
			$__bind["region_id"] = $this->regionId;
		}
		
		if(($this->cityId = Request::getInt("cid")) > 0)
		{
			$__cond[] = "city_id = :city_id";
			$__bind["city_id"] = $this->cityId;
		}
		
		if(($this->areaId = Request::getInt("aid")) > 0 && ! ($this->cityId > 0))
		{
			$__city = OldGeoClass::i()->getCityById($this->areaId);
			
			$__citiesIds = array();
			foreach(OldGeoClass::i()->getCities(2, "", $this->regionId, $__city["area"]) as $__city)
				$__citiesIds[] = $__city["id"];
			
			$__cond[] = "city_id IN (".implode(",", $__citiesIds).")";
		}
		
		$__list = UsersModel::i()->getList($__cond, $__bind);
		
		$__length = 10;
		$__step = Request::getInt("step") * $__length;
		
		if($__step > 0)
		{
			parent::setLayout(false);
			parent::setView("index/table_rows");
		}
		else
		{
			$this->regions = OldGeoClass::i()->getRegions(2);
		}
		
		$this->list = array();
		$this->count = count($__list);
		
		foreach(array_slice($__list, $__step, $__length) as $__id)
		{
			if(
					UserClass::i()->isAuthorized()
					&& $__id == UserClass::i()->getId()
			){
				$this->count--;
				continue;
			}
			
			$this->list[] = UsersModel::i()->getItem($__id);
		}
	}
	
	public function jSubscribe()
	{
		parent::setViewer("json");
		
		$friendId = Request::getInt("friend_id");
		
		if(
				! UserClass::i()->isAuthorized()
				|| ! ($__item = UsersModel::i()->getItem($friendId))
		){
			return false;
		}
		
		$__cond = array("user_id = :user_id", "friend_id = :friend_id");
		$__bind = array(
			"user_id" => UserClass::i()->getId(),
			"friend_id" => $friendId
		);
		
		$__list = UsersFriendsModel::i()->getList($__cond, $__bind);
		
		if( ! (count($__list) > 0))
		{
			UsersFriendsModel::i()->insert(array(
				"user_id" => UserClass::i()->getId(),
				"friend_id" => $friendId
			));
		}
		
		return true;
	}
}
