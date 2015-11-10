<?php

Loader::loadModule("Admin");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadClass("OldGeoClass");
Loader::loadClass("UserClass");
Loader::loadModel("trainings.*");
Loader::loadModel("UsersModel");

class TrainingsAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Менеджер тренінгів";
	public static $modAHref = "/admin/trainings";
	public static $modImgSrc = "trainings";
	
	private function __getItem($id)
	{
		if( ! ($__item = TrainingsListModel::i()->getItem($id)))
			return $__item;
		
		$__cond = array("training_id = :training_id", "status = 0");
		$__bind["training_id"] = $id;

		$__item["members"]["new"] = count(TrainingsMembersModel::i()->getList($__cond, $__bind));

		$__cond = array("training_id = :training_id", "status = 1");
		$__bind["training_id"] = $id;

		$__item["members"]["connected"] = count(TrainingsMembersModel::i()->getList($__cond, $__bind));

		$__item["members"]["all"] = $__item["members"]["connected"] + $__item["members"]["new"];
			
		return $__item;
	}
	
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadCKEditor(true);
		parent::loadWindow("admin/trainings/form");
		parent::loadWindow("admin/trainings/confirm");
		parent::loadWindow("admin/trainings/members");
		parent::loadWindow("admin/trainings/member_confirm");
		parent::loadWindow("admin/image_uploader");

		HeadClass::addJs(array(
			"/js/i18n.js",
			"/js/form.js",
			"/js/frontend/admin/trainings.js"
		));
		
		$__list = array();
		foreach(TrainingsListModel::i()->getList(array(), array(), array("created_at DESC")) as $__id)
		{
			$__item = $this->__getItem($__id);
			
			$__list[] = $__item;
		}
		
		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->list = $__pager->getList();
		$this->pager = $__pager;
		
		$this->regions = OldGeoClass::i()->getRegions(2);
	}
	
	public function jGetMembers()
	{
		parent::setViewer("json");
		
		$__status = Request::getInt("status");
		
		$__cond = array("training_id = :training_id", "status = :status");
		$__bind["training_id"] = Request::getInt("training_id");
		$__bind["status"] = Request::getInt("status");
		
		$this->json["list"] = array();
		foreach (TrainingsMembersModel::i()->getCompiledList($__cond, $__bind) as $__training)
		{
			$__item = $__training;
			
			$__item["user_name"] = UserClass::getNameByItem(UsersModel::i()->getItem($__training["user_id"]));
			
			$this->json["list"][] = $__item;
		}
		
		$this->json["status"] = Request::getInt("status");
		
		return true;
	}
	
	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = TrainingsListModel::i()->getItem($__id))
		){
			return false;
		}
		
		$this->json["item"] = $__item;
		
		$__fields = array("meta_title", "meta_description", "meta_keywords");
		foreach ($__fields as $__field)
			if( ! is_array($this->json["item"][$__field]))
			{
				$this->json["item"][$__field] = array();

				foreach (Router::getLangs() as $__lang)
					$this->json["item"][$__field][$__lang] = "";
			}
					
		return true;
	}
	
	public function jSave()
	{
		parent::setViewer("json");
		
		$__id = Request::getInt("id");
		
		$__data = array(
			"title" => Request::getArray("title"),
			"meta_title" => Request::getArray("meta_title"),
			"meta_description" => Request::getArray("meta_description"),
			"meta_keywords" => Request::getArray("meta_keywords"),
			"text" => Request::getArray("text"),
			"happen_at" => date("Y-m-d H:i:s", strtotime(Request::getString("happen_at"))),
			"region_id" => Request::getInt("rid"),
			"area_id" => Request::getInt("aid"),
			"city_id" => Request::getInt("cid"),
			"image" => stripslashes(Request::getString("image")),
			"address" => Request::getString("address")
		);
		
		if( Request::getInt("rid") > 0 )
			$__data["region_id"] = Request::getInt("rid");
		
		foreach(array("title", "text", "meta_title", "meta_description", "meta_keywords") as $__field)
		{
			foreach(Router::getLangs() as $__lang)
			{
				if(
						! isset($__data[$__field])
						|| ! isset($__data[$__field][$__lang])
						|| ! is_string($__data[$__field][$__lang])
				){
					$__data[$__field][$__lang] = "";
				}
			}
		}
		
		if(
				! ($__id > 0)
				|| ! (TrainingsListModel::i()->update(array_merge(array("id" => $__id), $__data)))
		){
			$__id = TrainingsListModel::i()->insert($__data);
		}
				
		$this->json["item"] = $this->__getItem($__id);
		
		return true;
	}
	
	public function jDelete()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = TrainingsListModel::i()->getItem($__id))
		){
			return false;
		}
		
		TrainingsListModel::i()->deleteItem($__id);
		
		return true;
	}
	
	public function jPublicate()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = TrainingsListModel::i()->getItem($__id))
		){
			return false;
		}
		
		TrainingsListModel::i()->update(array(
			"id" => $__id,
			"is_public" => (bool) Request::getInt("state")
		));
		
		return true;
	}
	
	public function jValidate()
	{
		parent::setViewer("json");
		
		$training = TrainingsMembersModel::i()->getItem(Request::getInt("member_id"), array("training_id"));
		
		TrainingsMembersModel::i()->update(array(
			"id" => Request::getInt("member_id"),
			"status" => Request::getInt("member_status")
		));
		
		$__data = array(
			"user_validator_id" => UserClass::i()->getId(),
			"trainings_member_id" => Request::getInt("member_id"),
			"trainings_member_status" => Request::getInt("member_status")
		);
		
		$this->json["item"] = $this->__getItem($training["training_id"]);
		
		TrainingsMembersValidationsModel::i()->insert($__data);
		
		return true;
	}
}
