<?php

Loader::loadModule("Projects");
Loader::loadModel("ProjectsModel");
Loader::loadModel("materials.NewsMaterialsModel");
Loader::loadModel("NewsCategoriesModel");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadModel("comments.NewsCommentsModel");
//Loader::loadModel("users.UsersDataModel");

class IndexProjectsController extends ProjectsController
{	
	private function __compileCommentItem($item)
	{
		$item["date"] = $this->application->intlDateFormatter->format(strtotime($item["created_at"]));
		
		$item["author"] = array(
			"name" => ""
		);
		
		if($item["author_id"] > 0)
		{
			$__author = UsersModel::i()->getItem($item["author_id"]);
			$item["author"]["name"] = UserClass::getNameByItem($__author);
		}
		else
			$item["author"]["name"] = $item["__xtnd"]["name"];
		
		return $item;
	}
	
	private function __viewItem($item)
	{
		parent::setView("index/view_item");
		parent::loadKendo(true);
		
//		HeadClass::addCss("/css/frontend/projects/index/view_item.css");
		HeadClass::addLess("/less/frontend/projects/index/view_item.less");
		
		$__cond[] = array("project_id = :project_id");
		$__cond[] = array("is_public = :is_public");
		
		$__bind["project_id"] = $item["id"];
		$__bind["is_public"] = 1;
		
		$__list = NewsMaterialsModel::i()->getCompiledList($__cond, $__bind, array("created_at DESC"));
		$__pager = new PagerClass($__list, Request::getInt("page"),8);
		
		$this->indexProjectsController->newsList = $__pager->getList();
		$this->indexProjectsController->pager = $__pager;
		$this->indexProjectsController->item = $item;
		
		return true;
	}

	public function execute($args = array())
	{
		parent::execute();
		
		HeadClass::addCss("/css/frontend/projects/index.css");
		
		$this->indexProjectsController = new stdClass();
		
		if(
				isset($args[0])
				&& ($__item = ProjectsModel::i()->getItem($args[0]))
				&& $__item["is_public"] == 1
		){	
			return $this->__viewItem($__item);
		}
		
		return $this->__viewList();
	}
	
	public function jAddComment()
	{
		parent::execute();
		parent::setViewer("json");
		
		$__xtnd = array(
			"name" => stripslashes(Request::getString("name")),
			"email" => stripslashes(Request::getString("email"))
		);
		
		$__data = array(
			"content_id" => Request::getInt("content_id"),
			"text" => stripslashes(Request::getString("text")),
			"author_id" => Request::getInt("author_id"),
			"parent_id" => Request::getInt("parent_id"),
			"__xtnd" => $__xtnd
		);
		$__id = NewsCommentsModel::i()->insert($__data);
		
		$this->json["item"] = $this->__compileCommentItem(NewsCommentsModel::i()->getItem($__id));
		
		return true;
	}
}
