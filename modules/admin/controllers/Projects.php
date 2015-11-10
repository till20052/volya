<?php

Loader::loadModule("Admin");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadModel("materials.ProjectsMaterialsModel");

class ProjectsAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Менеджер проектів";
	public static $modAHref = "/admin/projects";
	public static $modImgSrc = "projects";
	
	private function __getItem($id)
	{
		return ProjectsMaterialsModel::i()->getItem($id);
	}
	
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadCKEditor(true);
		parent::loadWindow("admin/projects/form");
		parent::loadWindow("admin/projects/confirm");
		parent::loadWindow("admin/image_uploader");

		HeadClass::addJs(array(
			"/js/i18n.js",
			"/js/form.js",
			"/js/frontend/admin/projects.js"
		));
		
		$__list = array();
		foreach(ProjectsMaterialsModel::i()->getList(array(), array(), array("created_at DESC")) as $__id)
		{
			$__list[] = $this->__getItem($__id);
		}
		
		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->list = $__pager->getList();
		$this->pager = $__pager;
	}
	
	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = ProjectsMaterialsModel::i()->getItem($__id))
		){
			return false;
		}
		
		$this->json["item"] = $__item;
		
		return true;
	}
	
	public function jSave()
	{
		parent::setViewer("json");
		
		$__id = Request::getInt("id");
		
		$__data = array(
			"category_id" => Request::getInt("category_id"),
			"author_id" => UserClass::i()->getId(),
			"title" => Request::getArray("title"),
			"text" => Request::getArray("text"),
			"created_at" => date("Y-m-d H:i:s", strtotime(Request::getString("created_at"))),
			"image" => stripslashes(Request::getString("image"))
		);
		
		foreach(array("title", "text") as $__field)
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
				|| ! (ProjectsMaterialsModel::i()->update(array_merge(array("id" => $__id), $__data)))
		){
			$__id = ProjectsMaterialsModel::i()->insert($__data);
		}
				
		$this->json["item"] = $this->__getItem($__id);
		
		return true;
	}
	
	public function jDelete()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = ProjectsMaterialsModel::i()->getItem($__id))
		){
			return false;
		}
		
		ProjectsMaterialsModel::i()->deleteItem($__id);
		
		return true;
	}
	
	public function jPublicate()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = ProjectsMaterialsModel::i()->getItem($__id))
		){
			return false;
		}
		
		ProjectsMaterialsModel::i()->update(array(
			"id" => $__id,
			"is_public" => (bool) Request::getInt("state")
		));
		
		return true;
	}
}
