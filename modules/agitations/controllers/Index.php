<?php

Loader::loadModule("Agitations");
Loader::loadModel("AgitationsModel");
Loader::loadModel("AgitationsCategoriesModel");
Loader::loadClass("PagerClass", Loader::SYSTEM);

class IndexAgitationsController extends AgitationsController
{
	private function __getCategory($id)
	{
		if( ! ($__item = AgitationsCategoriesModel::i()->getItem($id)))
			return $__item;
		
		return $__item;
	}
	
	private function __getCategories()
	{
		$__list = array();

		$__cond = array("is_public = :is_public");
		$__bind = array(
			"is_public" => true
		);

		foreach(AgitationsCategoriesModel::i()->getList($__cond, $__bind, array("is_default DESC")) as $__id)
		{
			$__list[] = $this->__getCategory($__id);
		}
		
		return $__list;
	}
	
	private function __viewListByCategory($category)
	{
		parent::setView("index/view_list_by_category");
		
		HeadClass::addCss("/css/frontend/agitation/index/view_list_by_category.css");
		
		$__cond = array(
			"category_id = :category_id",
			"is_public = :is_public"
		);
		$__bind = array(
			"category_id" => $category["id"],
			"is_public" => true
		);
		
		$__list = AgitationsModel::i()->getCompiledList($__cond, $__bind, array("created_at DESC"));
		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->indexNewsController->categories = $this->__getCategories();
		$this->indexNewsController->category = $category;
		$this->indexNewsController->list = $__pager->getList();
		$this->indexNewsController->pager = $__pager;
		
		return true;
	}

	public function execute($args = array())
	{
		parent::execute();
		parent::clearBreadcrumbs();
		parent::addBreadcrumb("/agitations", t("Агітації"));
		
		HeadClass::addCss("/css/frontend/agitations/index.css");
		
		$this->indexNewsController = new stdClass();
		
		if(
				isset($args[0])
				&& ($__category = AgitationsCategoriesModel::i()->getItemBySymlink($args[0]))
		){
			if(
					isset($args[1])
					&& ($__item = AgoitationsModel::i()->getItem($args[1]))
					&& $__item["is_public"] == 1
			)
				return $this->__viewItem($__item);
			
			return $this->__viewListByCategory($__category);
		}
		
		return $this->__viewListByCategory(AgitationsCategoriesModel::i()->getDefault());
	}
	
	public function downloadFile($args = array())
	{
		parent::setViewer("file");
		
		$__id = $args[0];
		
		$__item = AgitationsModel::i()->getItem($__id);
		
		header('Content-Disposition: attachment; filename="'.$__item["file"].'"');
		$this->fileName = Router::getAppFolder().DS."static".DS."upload".DS."agitations".DS.$__item["file"];
	}
}
