<?php

Loader::loadModule("Admin");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadModel("MenuModel");

class MenuAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Головне меню";
	public static $modAHref = "/admin/menu";
	public static $modImgSrc = "menu";
	
	private function __getItem($id)
	{
		return MenuModel::i()->getItem($id);
	}
	
	private function __getTree($list, $parent = 0)
	{
		$__tree = array();
		
		foreach($list as $__item)
		{
			if($__item["parent"] != $parent)
				continue;
			
			$__subTree = $this->__getTree($list, $__item["id"]);
			
			if(count($__subTree) > 0)
				$__item["sub_tree"] = $__subTree;
			
			$__tree[] = $__item;
		}
		
		return $__tree;
	}
	
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadWindow("admin/menu/confirm");
		
		HeadClass::addJs(array(
			"/js/form.js",
			"/js/i18n.js",
			"/js/window.js",
			"/js/frontend/admin/menu.js"
		));
	}
	
	public function jGetData()
	{
		parent::setViewer("json");
		
		$__cond = array();
		$__bind = array();
		$__order = array("priority ASC");
		
		$this->json["tree"] = $this->__getTree(MenuModel::i()->getCompiledList($__cond, $__bind, $__order));
		
		return true;
	}

	public function jSave()
	{
		parent::setViewer("json");
		
		$__id	= Request::getInt("id");
		
		$__data = array(
			"href" => Request::getString("href"),
			"name" => Request::getArray("name"),
			"is_public" => Request::getInt("is_public")
		);
		
		if(($__parent = Request::getInt("parent", -1)) != -1)
				$__data["parent"] = $__parent;
		
		foreach(array("name") as $__field)
		{
			foreach(Router::getLangs() as $__lang)
				if(
						! isset($__data[$__field])
						|| ! isset($__data[$__field][$__lang])
						|| ! is_string($__data[$__field][$__lang])
				)
					$__data[$__field][$__lang] = "";
		}
		
		if(
				! ($__id > 0)
				|| ! (MenuModel::i()->update(array_merge(array("id" => $__id), $__data)))
		)
			$__id = MenuModel::i()->insert($__data);
				
		$this->json["item"] = $this->__getItem($__id);
		
		return true;
	}
	
	public function jOnDragend()
	{
		parent::setViewer("json");
		
		$__data = array(
			"id" => Request::getInt("id"),
			"parent" => Request::getInt("parent")
		);
		
		if( ! ($__data["id"] > 0))
			return false;
		
		MenuModel::i()->update($__data);
		
		foreach(Request::getArray("order") as $__order)
		{
			if(
					! isset($__order["id"])
					|| ! isset($__order["priority"])
					|| ! ($__order["id"] > 0)
			)
				continue;
			
			MenuModel::i()->update(array(
				"id" => $__order["id"],
				"priority" => $__order["priority"]
			));
		}
		
		$this->json["item"] = $this->__getItem($__data["id"]);
		
		return true;
	}
	
	public function jDelete()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		$__selectedId = Request::get("id");
		
		if (!is_array($__selectedId))
			$__selectedId = array($__selectedId);
			
		foreach($__selectedId as $id) 
			MenuModel::i()->deleteItem($id);	
	}
}
