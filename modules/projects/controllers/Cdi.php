<?php

Loader::loadModule('Projects');

Loader::loadModel('materials.PagesMaterialsModel');
Loader::loadModel('materials.NewsMaterialsModel');
Loader::loadModel('NewsImagesModel');

class CdiProjectsController extends ProjectsController
{
	private function __getNews()
	{
		$__list = [];

		$__cond = ["category_id = 11"];

		foreach(NewsMaterialsModel::i()->getList($__cond, [], ['created_at DESC'], 9) as $__id)
		{
			$__item = NewsMaterialsModel::i()->getItem($__id);

			$__item["images"] = array();
			foreach(NewsImagesModel::i()->getList(["material_id = :material_id"], ["material_id" => $__item["id"]]) as $__id)
				$__item["images"][] = NewsImagesModel::i()->getItem($__id, ["symlink"])["symlink"];

			$__list[] = $__item;
		}

		return $__list;
	}

	public function execute()
	{
		parent::execute();
		parent::loadCKEditor(true);
		parent::loadWindow([
			'projects/cdi/google_form'
		]);

		HeadClass::addJs([
			'/js/frontend/projects/cdi.js'
		]);

		HeadClass::addLess([
			'/less/frontend/projects/cdi.less'
		]);

		$this->about = PagesMaterialsModel::i()->getItemBySymlink('projects.cdi.about');

		$this->news = $this->__getNews();
	}

	public function program()
	{
		parent::execute();
		parent::setView('cdi/program');

		HeadClass::addLess([
			'/less/frontend/projects/cdi.less'
		]);

		$this->program = PagesMaterialsModel::i()->getItemBySymlink('projects.cdi.program');
	}
}