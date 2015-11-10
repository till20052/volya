<?php

Loader::loadAppliaction("Frontend");
Loader::loadClass("UserClass");
Loader::loadModel("UsersModel");
Loader::loadModel("UsersFriendsModel");

class ProfileController extends Frontend
{
	protected function initProfile($id = null)
	{
		$__userId = UserClass::i()->getId();
		
		if(
				! is_null($id)
				&& $id > 0
				&& ($__item = UsersModel::i()->getItem($id))
		)
			$__userId = $id;
		
		return ( ! isset($__item) ? UsersModel::i()->getItem($__userId) : $__item);
	}
	
	public function execute($args = array())
	{
		parent::execute();
		
		if(
				! UserClass::i()->isAuthorized()
				&& ! in_array(Router::getController(), array("Registration", "Activate"))
		){
			parent::redirect("/profile/registration");
		}
		
		if(
				UserClass::i()->isAuthorized()
				&& in_array(Router::getController(), array("Registration", "Activate"))
		)
			parent::redirect("/profile");
		
		$this->common = new stdClass();
		$this->common->friends = array();
		$this->common->peopleInMyCity = array();
		
		$this->profile = $this->initProfile(isset($args[0]) ? $args[0] : null);
		
		foreach(array_splice(UsersFriendsModel::i()->getFriends($this->profile["id"]), 0, 3) as $__id)
			$this->common->friends[] = UsersModel::i()->getItem($__id);
		
		
		if($this->profile["region_id"] > 0)
		{
			$__cond = array("region_id = :region_id", "id != :id");
			$__bind = array(
				"region_id" => $this->profile["region_id"],
				"id" => UserClass::i()->getId()
			);
			
			if($this->profile["city_id"] > 0)
			{
				$__cond[] = "city_id = :city_id";
				$__bind["city_id"] = $this->profile["city_id"];
			}
			
			foreach(UsersModel::i()->getList($__cond, $__bind, array("RAND()"), 3) as $__id)
			{
				if($__id == $this->profile["id"])
					continue;
					
				$this->common->peopleInMyCity[] = UsersModel::i()->getItem($__id);
			}
		}
	}
}
