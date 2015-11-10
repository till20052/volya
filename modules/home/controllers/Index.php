<?php

Loader::loadModule("Home");
Loader::loadModel("materials.NewsMaterialsModel");
Loader::loadModel("ProjectsModel");
Loader::loadModel("NewsCategoriesModel");
Loader::loadModel("NewsImagesModel");
Loader::loadModel("HomeSlidesModel");

class IndexHomeController extends HomeController
{
	private function __getNews()
	{
		$__list = array();

		$__cond = [
			"is_public = 1",
//			"category_id > 0",
			["OR" => [
				"category_id <> :category_id",
				"AND" => ["category_id = :category_id", "in_main_block = 1"]
			]],
			["OR" => ["author_id IS NULL", "author_id = 0"]]
		];
		$__bind = [
			"category_id" => NewsCategoriesModel::i()->getItemBySymlink("by_regions", ["id"])["id"]
		];
		
		foreach(NewsMaterialsModel::i()->getCompiledList($__cond, $__bind, array("created_at DESC"), 10) as $__item)
		{
			$__item["images"] = NewsImagesModel::i()->getImagesByMaterialId($__item["id"]);
			
			$__list[] = $__item;
		}
		
		return $__list;
	}
	
	private function __getProjects()
	{
		$__list = array();
		
		$__cond = array("is_public = 1");
		$__bind = array();
		
		return ProjectsModel::i()->getCompiledList($__cond, $__bind, array("created_at DESC"), 10);
	}
	
	private function __getSlides()
	{
		$__list = array();
		
		$__cond = array("is_public = 1");
		$__bind = array();
		
		foreach(HomeSlidesModel::i()->getList($__cond, $__bind, array("id DESC"), 10) as $__id)
		{
			$__item = HomeSlidesModel::i()->getItem($__id, ["href", "image", "title", "description"]);
			
			foreach(["title", "description"] as $__field)
				$__item[$__field] = $__item[$__field][Router::getLang()];
			
			$__list[] = $__item;
		}
		
		return $__list;
	}

	private function __getRegionalNews()
	{
		$__list = [];

		$__cond = [
			"geo_koatuu_code IS NOT NULL",
			"category_id = :category_id",
			"is_public = 1"
		];
		$__bind = [
			"category_id" => NewsCategoriesModel::i()->getItemBySymlink("by_regions", ["id"])["id"]
		];
		$__order = ["created_at DESC"];

		foreach(NewsMaterialsModel::i()->getList($__cond, $__bind, $__order, 9) as $__id)
		{
			$__item = NewsMaterialsModel::i()->getItem($__id);

			$__item["images"] = NewsImagesModel::i()->getImagesByMaterialId($__item["id"]);

			$__list[] = $__item;
		}

		return $__list;
	}
	
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		HeadClass::addJs("/js/frontend/home/index.js");
		HeadClass::addLess("/less/frontend/home/index.less");
		
		$this->news = $this->__getNews();
		$this->slides = $this->__getSlides();
		$this->projects = $this->__getProjects();

		$this->cellsWork = [
			"news" => $this->__getRegionalNews()
		];
	}
}
