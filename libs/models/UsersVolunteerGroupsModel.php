<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class UsersVolunteerGroupsModel extends ExtendedModel
{
	protected $table = "users_volunteer_groups";
	
	/**
	 * @param string $peer
	 * @return UsersVolunteerGroupsModel
	 */
	public static function i($peer = "UsersVolunteerGroupsModel")
	{
		return parent::i($peer);
	}
	
	public function setUserVolunteerGroups($userId, $volunteerGroups)
	{
		$__cond = array("user_id = :user_id");
		$__bind = array(
			"user_id" => $userId
		);
		
		foreach(parent::getList($__cond, $__bind) as $__id)
			parent::deleteItem($__id);
		
		foreach((array) $volunteerGroups as $__volunteerGroupId)
			parent::insert(array(
				"user_id" => $userId,
				"volunteer_group_id" => $__volunteerGroupId
			));
	}
	
	public function set($userId, $volunteerGroups)
	{
		$this->setUserVolunteerGroups($userId, $volunteerGroups);
	}
	
	public function getVolunteersGroupsByUserId($__userId)
	{
		$__where[] = "user_id = :user_id";
		$__bind["user_id"] = $__userId;
		
		$__list = parent::getCompiledList($__where, $__bind);
		$compiledList = array();
		
		foreach ($__list as $__item)
			$compiledList[] = $__item["volunteer_group_id"];
		
		return $compiledList;
	}
	
	public function setVolunteersGroups($__userId, $__groups)
	{
		$__where[] = "user_id = :user_id";
		$__bind["user_id"] = $__userId;
		
		$__list = parent::getList($__where, $__bind);
		$__cleanedList = array();
		
		foreach ($__list as $__item)
		{
			$item = parent::getItem($__item);
			
			if( ! in_array($item["volunteer_group_id"], $__groups) )
				parent::deleteItem($item["id"]);
			else
				$__cleanedList[] = $item["volunteer_group_id"];
		}
		
		foreach ($__groups as $__group)
			if ( ! in_array($__group, $__cleanedList) )
				parent::insert(array("user_id" => $__userId, "volunteer_group_id" => $__group));
	}
}
