<?php

Loader::loadModule("Admin");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadModel("materials.PagesMaterialsModel");

class PagesAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Статичні сторінки";
	public static $modAHref = "/admin/pages";
	public static $modImgSrc = "pages";
	
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadCKEditor(true);
		parent::loadWindow("admin/pages/form");
		parent::loadWindow("admin/pages/confirm");

		HeadClass::addJs(array(
			"/js/i18n.js",
			"/js/form.js",
			"/js/frontend/admin/pages.js"
		));
		
		$__list = PagesMaterialsModel::i()->getCompiledList(array(), array(), array("created_at DESC"));
	
		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->list = $__pager->getList();
		$this->pager = $__pager;
	}
	
	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = PagesMaterialsModel::i()->getItem($__id))
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
			"symlink" => Request::getString("symlink"),
			"title" => Request::getArray("title"),
			"text" => Request::getArray("text")
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
				|| ! (PagesMaterialsModel::i()->update(array_merge(array("id" => $__id), $__data)))
		){
			$__id = PagesMaterialsModel::i()->insert($__data);
		}
				
		$this->json["item"] = PagesMaterialsModel::i()->getItem($__id);
		
		return true;
	}
	
	public function jDelete()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = PagesMaterialsModel::i()->getItem($__id))
		){
			return false;
		}
		
		PagesMaterialsModel::i()->deleteItem($__id);
		
		return true;
	}
}
