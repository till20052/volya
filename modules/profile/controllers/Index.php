<?php

Loader::loadModule("Profile");
Loader::loadClass("UserClass");
Loader::loadModel("UsersModel");
Loader::loadModel("UsersFriendsModel");
Loader::loadModel("MaterialsModel");
Loader::loadModel("UsersVerifiedModel");
Loader::loadModel("NewsCategoriesModel");
Loader::loadModel("EventsModel");

class IndexProfileController extends ProfileController
{
	private function __getUserMaterials($userId)
	{
		$__list = array();
		
		$__cond = array("author_id = :author_id");
		$__bind = array(
			"author_id" => $userId
		);
		$__order = array("created_at DESC");
		
		if($userId != UserClass::i()->getId())
			$__cond[] = "is_public = 1";
		
		foreach(MaterialsModel::i()->getCompiledList($__cond, $__bind, $__order, 10) as $__item)
		{
			$__list[] = $__item;
		}
		
		return $__list;
	}
	
	private function __getEventsDates()
	{
		$__list = array();
		
		$__cond = array("is_public = 1");
		$__bind = array();
		$__order = array("happen_at ASC");
		
		foreach(EventsModel::i()->getList($__cond, $__bind, $__order) as $__id)
		{
			$__eventItem = EventsModel::i()->getItem($__id, array(
				"date_format" => "d.m.Y",
				"happen_at"
			));
			
			$__list[] = $__eventItem["happen_at"];
		}
		
		return $__list;
	}
	
	public function execute($args = array())
	{
		parent::execute($args);
		parent::loadKendo(true);
		parent::loadWindow("profile/avatar_uploader");
		
		HeadClass::addJs("/js/frontend/profile/index.js");
		HeadClass::addLess(array(
			"/less/frontend/profile/index.less",
			"/less/frontend/profile/common/right_column.less",
			"/less/frontend/profile/index/avatar_uploader.less"
		));
		
		if($this->profile["id"] == UserClass::i()->getId())
		{
			HeadClass::addJs(array(
				"/js/form.js",
				"/js/frontend/profile/index/what_is_new.js",
				"/js/frontend/profile/index/calendar.js",
			));
		}

		if(
			$this->profile["id"] == UserClass::i()->getId()
			|| UserClass::i()->hasCredential(777)
		)
			HeadClass::addJs("/js/frontend/profile/index/avatar_uploader.js");
		
		$this->profile["news"] = $this->__getUserMaterials($this->profile["id"]);
		$this->profile["events_dates"] = $this->__getEventsDates();
	}
	
	public function jSetAvatar()
	{
		parent::setViewer("json");
		
		if( ! UserClass::i()->isAuthorized())
			return false;
		
		$__avatar = stripslashes(Request::getString("avatar"));
		
		UsersModel::i()->update(array(
			"id" => Request::getInt("id"),
			"avatar" => $__avatar
		));
		
		return true;
	}
	
	public function jCreateMaterial()
	{
		parent::setViewer("json");
		
		if(
				! UserClass::i()->isAuthorized()
				|| ($__title = stripslashes(Request::getString("title"))) == ""
				|| ($__type = stripslashes(Request::getString("type"))) == ""
				|| ! in_array($__type, array("blog", "news"))
		)
			return false;
		
		$__category = NewsCategoriesModel::i()->getItemBySymlink("users_news");
		
		$__data = array(
			"type" => $__type,
			"author_id" => UserClass::i()->getId(),
			"region_id" => UserClass::i()->get("region_id"),
			"title" => $__title,
			"text" => stripslashes(Request::getString("text")),
			"category_id" => $__category["id"]
		);
		
		foreach(array("title", "text") as $__field)
		{
			$__value = $__data[$__field];
			foreach(Router::getLangs() as $__lang)
			{
				if( ! is_array($__data[$__field]))
					$__data[$__field] = array();
				
				$__data[$__field][$__lang] = $__value;
			}	
		}
		
		if( ! (($__materialId = MaterialsModel::i()->insert($__data)) > 0))
			return false;
		
		$this->json["item"] = MaterialsModel::i()->getItem($__materialId);
		
		return true;
	}
	
	public function jGetEvents()
	{
		parent::setViewer("json");
		
		$__cond = array("is_public = 1");
		$__bind = array();
		
		if(($__from = stripslashes(Request::getString("from"))) != "")
		{
			$__cond[] = "happen_at >= :from";
			$__bind["from"] = date("Y-m-d", strtotime($__from))." 00:00:00";
		}
		
		if(($__to = stripslashes(Request::getString("to"))) != "")
		{
			$__cond[] = "happen_at <= :to";
			$__bind["to"] = date("Y-m-d", strtotime($__to))." 23:59:59";
		}
		
		$__list = array();
		foreach(EventsModel::i()->getList($__cond, $__bind, array("happen_at ASC")) as $__id)
		{
			$__list[] = EventsModel::i()->getItem($__id, array(
				"date_format" => "d.m.Y H:i:s"
			));
		}
		
		$this->json["events"] = $__list;
		
		return true;
	}
}
