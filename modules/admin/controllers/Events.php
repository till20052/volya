<?php

Loader::loadModule("Admin");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadClass("OldGeoClass");
Loader::loadModel("EventsModel");

class EventsAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Менеджер подiй";
	public static $modAHref = "/admin/events";
	public static $modImgSrc = "events";

	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadCKEditor(true);
		parent::loadWindow("admin/events/form");
		parent::loadWindow("admin/events/confirm");
		
		HeadClass::addJs(array(
			"/js/i18n.js",
			"/js/form.js",
			"/js/frontend/admin/events.js"
		));
		
		$this->pager = array();
		
		$this->geo = array(
			"regions" => OldGeoClass::i()->getRegions(2)
		);
		
		$__list = array();
		foreach(EventsModel::i()->getList(array(), array(), array("created_at DESC")) as $__id)
			$__list[] = EventsModel::i()->getItem($__id);
		
		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->list = $__pager->getList();
		$this->pager = $__pager;
	}
	
	public function jSave()
	{
		parent::setViewer("json");
		
		$__id = Request::getInt("id");
		
		$__data = array(
			"title" => Request::getArray("title"),
			"description" => Request::getArray("description"),
			"happen_at" => date("Y-m-d H:i:s", strtotime(Request::getString("happen_at"))),
			"region_id" => Request::getInt("rid"),
			"area_id" => Request::getInt("aid"),
			"city_id" => Request::getInt("cid"),
		);
		
		foreach(array("title", "description") as $__field)
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
				|| ! (EventsModel::i()->update(array_merge(array("id" => $__id), $__data)))
		){
			$__id = EventsModel::i()->insert($__data);
		}
		
		$this->json["item"] = EventsModel::i()->getItem($__id);
		
		return true;
	}

	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! ($__item = EventsModel::i()->getItem($__id))
		){
			return false;
		}
		
		$this->json["item"] = $__item;
		
		return true;
	}
	
	public function jPublicate()
	{
		parent::setViewer("json");
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! ($__item = EventsModel::i()->getItem($__id))
		){
			return false;
		}
		
		EventsModel::i()->update(array(
			"id" => $__id,
			"is_public" => (bool) Request::getInt("state")
		));
		
		return true;
	}
	
	public function jDelete()
	{
		parent::setViewer("json");
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! ($__item = EventsModel::i()->getItem($__id))
		){
			return false;
		}
		
		EventsModel::i()->deleteItem($__id);
		
		return true;
	}
}
