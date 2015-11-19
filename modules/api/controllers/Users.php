<?php

Loader::loadModule("Api");
Loader::loadModel("UsersModel");
Loader::loadModel("UsersVerifiedModel");
Loader::loadModel("CellsModel");

Loader::loadClass("PagerClass", Loader::SYSTEM);

class UsersApiController extends ApiController
{
	public function execute()
	{
		parent::execute();
	}
	
	public function jFind()
	{
		parent::setViewer("json");
		
		if(($__q = stripslashes(Request::getString("q"))) == "")
			return false;
		
		$__users = array();
		
		$__cond = array();
		$__bind = array();
		
		$__findBySting = array();
		
		foreach(explode(" ", $__q) as $__part)
		{
			$__findBySting[] = array("OR" => array(
				"login LIKE '".$__part."%'",
				"first_name LIKE '".$__part."%'",
				"last_name LIKE '".$__part."%'",
			));
		}
		
		$__cond = $__findBySting;
		
		if(($__type = Request::get("type", -1)) != -1)
		{
			$__typeFilter = array();
			
			if(is_array($__type))
			{
				$__typeFilter = array("OR" => array());
				
				foreach($__type as $__value)
					$__typeFilter["OR"][] = "type = ".intval($__value);
			}
			else if(intval($__type) > 0)
			{
				$__typeFilter = array("type = :type");
				$__bind["type"] = $__type;
			}
			
			$__cond[] = $__typeFilter;
		}
		
		foreach(UsersModel::i()->getList($__cond, $__bind) as $__id)
		{
			$__user = UsersModel::i()->getItem($__id);
			
//			if(
//					($__isMember = Request::getInt("is_member", -1)) != -1
//					&& $__isMember != intval(CellsModel::i()->isMember($__user["id"]))
//			)
//				continue;
			
//			if(
//					(Request::getInt("is_verified") == 1)
//					&& (count(UsersVerifiedModel::i()->getList(array("user_id = :user_id"), array("user_id" => $__user["id"]))) == 0)
//			)
//				continue;
			
			$__users[] = $__user;
		}
		
		$this->json["users"] = $__users;
		
		return true;
	}
	
	public function find()
	{
		parent::setViewer("json");
		
		$__offset = Request::getInt("offset", 1);
		$__count = ($__tmp = Request::getInt("count", -1)) != -1 && $__tmp > 0 && $__tmp < 10 ? $__tmp : 10;
		
		$__cond = ["is_active = 1"];
		$__bind = [];
		
		if(($__email = Request::getString("email", "&null;")) != "&null;")
			$__cond[] = "`login` LIKE '".$__email."%'";

		if(Request::getString("geo") != "")
		{
			$__code = rtrim(Request::getString("geo"), '0');
			$__cond[] = "geo_koatuu_code REGEXP :regexp";
			$__bind["regexp"] = $__code . "[0-9]{" . (10 - strlen($__code)) . "}";
		}

		if(Request::getBool("uniq_structure"))
			$__cond[] = "`id` NOT IN (SELECT `uid` FROM `structures_members`)";

		if(Request::getArray("status"))
			$__cond[] = "`type` IN (". implode(",", Request::getArray("status")) .")";

		$__list = array();
		foreach(UsersModel::i()->getList($__cond, $__bind) as $__id)
		{
			$__fields = [
				"id", "first_name", "last_name", "middle_name", "avatar"
			];
			
			if($__email != "&null;")
				$__fields[] = "login AS email";
			
			$__item = UsersModel::i()->getItem($__id, $__fields);
			
			$__list[] = $__item;
		}
		
		$this->json["list"] = (new PagerClass($__list, $__offset, $__count))->getList();
		
		return true;
	}
}
