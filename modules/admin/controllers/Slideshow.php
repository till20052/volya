<?php

Loader::loadModule("Admin");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadModel("HomeSlidesModel");

class SlideshowAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Слайдер";
	public static $modAHref = "/admin/slideshow";
	public static $modImgSrc = "slideshow";
	
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadWindow("admin/slideshow/form");
		parent::loadWindow("admin/slideshow/confirm");
		parent::loadWindow("admin/image_uploader");

		HeadClass::addJs(array(
			"/js/i18n.js",
			"/js/form.js",
			"/js/frontend/admin/slideshow.js"
		));
		
		$__list = HomeSlidesModel::i()->getCompiledList(array(), array(), array("created_at DESC"));
		
		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->list = $__pager->getList();
		$this->pager = $__pager;
	}
	
	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = HomeSlidesModel::i()->getItem($__id))
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
			"href" => Request::getString("href"),
			"title" => Request::getArray("title"),
			"description" => Request::getArray("description"),
			"image" => stripslashes(Request::getString("image"))
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
				|| ! (HomeSlidesModel::i()->update(array_merge(array("id" => $__id), $__data)))
		){
			$__id = HomeSlidesModel::i()->insert($__data);
		}
				
		$this->json["item"] = HomeSlidesModel::i()->getItem($__id);
		
		return true;
	}
	
	public function jPublicate()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = HomeSlidesModel::i()->getItem($__id))
		){
			return false;
		}
		
		HomeSlidesModel::i()->update(array(
			"id" => $__id,
			"is_public" => (bool) Request::getInt("state")
		));
		
		return true;
	}
	
	public function jDelete()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = HomeSlidesModel::i()->getItem($__id))
		){
			return false;
		}
		
		HomeSlidesModel::i()->deleteItem($__id);
		
		return true;
	}
}

