<?php

Loader::loadModule("Admin");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadModel("AgitationsModel");
Loader::loadModel("AgitationsCategoriesModel");

class AgitationsAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Менеджер агітацій";
	public static $modAHref = "/admin/agitations";
	public static $modImgSrc = "agitations";
	
	private function __getItem($id)
	{
		if( ! ($__item = AgitationsModel::i()->getItem($id)))
			return $__item;
		
		if($__item["category_id"] > 0)
			$__item["category"] = AgitationsCategoriesModel::i()->getItem($__item["category_id"], array("symlink"));
		else
			$__item["category"] = array("symlink" => "{unspecified}");
		
		return $__item;
	}
	
	private function __getAgitationCategories($options = [])
	{
		$__list = [];
		
		$__cond = [];
		$__bind = [];
		
		if(isset($options["is_public"]))
		{
			$__cond[] = "is_public = :is_public";
			$__bind["is_public"] = $options["is_public"];
		}
		
		if(isset($options["in_election"]))
			$__bind["in_election"] = $options["in_election"];
		
		foreach(AgitationsCategoriesModel::i()->getList($__cond, $__bind) as $__id)
		{
			$__item = AgitationsCategoriesModel::i()->getItem($__id, ["id", "name", "is_public"]);
			
			if(isset($options["use_current_lang"]) && $options["use_current_lang"] == 1)
				$__item["name"] = $__item["name"][Router::getLang()];
			
			$__list[] = $__item;
		}
		
		return $__list;
	}
	
	public function execute($args = array())
	{
		parent::execute();
		
		parent::loadKendo(true);
		parent::loadCKEditor(true);
		parent::loadFileupload(true);
		
		parent::loadWindow([
			"admin/agitations/form",
			"admin/agitations/categories_form"
		]);
		
		HeadClass::addJs(array(
			"/js/i18n.js",
			"/js/form.js",
			"/js/frontend/admin/agitations.js"
		));
		
		HeadClass::addLess([
			"/less/frontend/admin/agitations.less",
			"/less/frontend/admin/agitations/form.less",
		]);
		
		$this->filter = [
			"type" => ""
		];
		
		$__list = array();
		
		$__cond = ["in_election = :in_election", "election_candidate_id IS NULL"];
		$__bind = ["in_election" => 0];
		
		if(isset($args[0]) && in_array($args[0], ["election"]))
		{
			$__bind["in_election"] = 1;
			$this->filter["type"] = $args[0];
		}
		
		$__pager = new PagerClass(AgitationsModel::i()->getList($__cond, $__bind, array("created_at DESC")), Request::getInt("page"), 14);
		
		foreach($__pager->getList() as $__id)
		{
			$__item = $this->__getItem($__id);
			
			$__item["categories"] = array();
			
			if( ! is_array($__item["categories_ids"]))
				$__item["categories_ids"] = array($__item["category_id"]);
				
			foreach($__item["categories_ids"] as $__categoryId)
				$__item["categories"][] = AgitationsCategoriesModel::i()->getItem($__categoryId, ["name"])["name"][Router::getLang()];
			
			$__list[] = $__item;
		}
		
		$this->list = $__list;
		$this->pager = $__pager;
		
		$this->agitationCategories = $this->__getAgitationCategories([
			"use_current_lang" => 1,
			"is_public" => 1
		]);
	}
	
	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = AgitationsModel::i()->getItem($__id))
		)
			return false;
		
		if( ! is_array($__item["categories_ids"]))
			$__item["categories_ids"] = [$__item["category_id"]];
		
		if(Request::getInt("use_current_lang") == 1)
			$__item["name"] = $__item["name"][Router::getLang()];
		
		$this->json["item"] = $__item;
		
		return true;
	}
	
	public function jSave()
	{
		parent::setViewer("json");
		
		$__data = array(
			"categories_ids" => Request::getArray("categories_ids"),
			"name" => Request::getString("name"),
			"description" => "",
			"image" => Request::getString("image"),
			"file" => Request::getString("file"),
			"in_election" => Request::getInt("in_election")
		);
		
		foreach($__data as $__field => $__value)
		{
			if( ! is_string($__data[$__field]))
				continue;
			
			$__data[$__field] = str_replace("'", "\'", stripslashes($__value));
		}
		
		foreach(["name", "description"] as $__field)
		{
			$__value = $__data[$__field];
			foreach(Router::getLangs() as $__lang)
			{
				if( ! is_array($__data[$__field]))
					$__data[$__field] = [];
				
				$__data[$__field][$__lang] = $__value;
			}
		}
		
		if( ! (($__id = Request::getInt("id")) > 0) || ! AgitationsModel::i()->update(array_merge(["id" => $__id], $__data)))
			$__id = AgitationsModel::i()->insert($__data);
		
		$__item = AgitationsModel::i()->getItem($__id);
			
		$__item["categories"] = [];
		foreach($__item["categories_ids"] as $__categoryId)
			$__item["categories"][] = AgitationsCategoriesModel::i()->getItem($__categoryId, ["name"])["name"][Router::getLang()];
		
		$this->json["item"] = $__item;
		
		return true;
	}
	
	public function jUpdateItem()
	{
		parent::setViewer("json");
		
		$__data = array();
		
		$__tokens = [];
		foreach(["field", "value"] as $__token)
		{
			$__value = Request::get($__token);
			
			if(is_null($__value))
				continue;
			
			if(is_int($__value))
				$__value = (int) $__value;
			
			if(is_string($__value))
				$__value = str_replace("'", "\'", stripslashes(Request::getString($__token)));
			
			$__tokens[$__token] = $__value;
		}
		
		if( ! in_array($__tokens["field"], ["is_public"]))
			return false;
		
		$__data[$__tokens["field"]] = $__tokens["value"];
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! AgitationsModel::i()->update(array_merge(["id" => $__id], $__data))
		)
			return false;
		
		return true;
	}
	
	public function jDeleteItem()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! AgitationsModel::i()->getItem($__id)
		)
			return false;
		
		AgitationsModel::i()->deleteItem($__id);
		
		return true;
	}
	
	public function jGetCategories()
	{
		parent::setViewer("json");
		
		$__options = [];
		
		if(($__isPublic = Request::getInt("is_public", -1)) != -1)
			$__options["is_public"] = $__isPublic;
		
		if(Request::getInt("use_current_lang") == 1)
			$__options["use_current_lang"] = 1;
		
		$this->json["list"] = $this->__getAgitationCategories($__options);;
		
		return true;
	}
	
	public function jSaveCategory()
	{
		parent::setViewer("json");
		
		$__data = [];
		
		$__name = Request::get("name");
		if( ! is_null($__name))
			$__data["name"] = (string) $__name;
		
		$__isPublic = Request::get("is_public");
		if( ! is_null($__isPublic))
			$__data["is_public"] = (int) $__isPublic;
		
		foreach(["name"] as $__field)
		{
			if( ! isset($__data[$__field]))
				continue;
			
			$__value = str_replace("'", "\'", stripslashes($__data[$__field]));
			foreach(Router::getLangs() as $__lang)
			{
				if( ! is_array($__data[$__field]))
					$__data[$__field] = [];
				
				$__data[$__field][$__lang] = $__value;
			}
		}
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! AgitationsCategoriesModel::i()->update(array_merge(["id" => $__id], $__data))
		)
			$__id = AgitationsCategoriesModel::i()->insert($__data);
		
		$this->json["item"] = AgitationsCategoriesModel::i()->getItem($__id);
		
		return true;
	}
	
	public function jDeleteCategory()
	{
		parent::setViewer("json");
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! AgitationsCategoriesModel::i()->getItem($__id)
		)
			return false;
		
		AgitationsCategoriesModel::i()->deleteItem($__id);
		
		return true;
	}
}
