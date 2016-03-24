<?php

Loader::loadModule('Cells1');

Loader::loadModel('materials.PagesMaterialsModel');
Loader::loadModel('materials.NewsMaterialsModel');
Loader::loadModel('NewsImagesModel');
Loader::loadModel('OrganizationsContactsModel');

class IndexCells1Controller extends Cells1Controller
{
	private function __getNews($from = 0, $volya_people = false, $topNews = false)
	{
		$__list = [];
		$__cond = ["geo_koatuu_code REGEXP '26[0-9]{8}'", "is_public = 1"];

		$count = 9;
		if($volya_people){
			$count = 100;
			$__cond = array_merge($__cond, ["in_volya_people = 1"]);
		}

		if($topNews){
			$count = 100;
			$__cond = array_merge($__cond, ["in_top = 1"]);
		}

		$this->application->intlDateFormatter->setPattern("d MMMM");

		foreach(array_slice(NewsMaterialsModel::i()->getList($__cond, [], ['created_at DESC']), $from, $count) as $__id)
		{
			$__item = NewsMaterialsModel::i()->getItem($__id);

			$__item["images"] = array();
			foreach(NewsImagesModel::i()->getList(["material_id = :material_id"], ["material_id" => $__item["id"]]) as $__id)
				$__item["images"][] = NewsImagesModel::i()->getItem($__id, ["symlink"])["symlink"];

			$__item['created_at'] = $this->application->intlDateFormatter->format(strtotime($__item["created_at"]));

			$__list[] = $__item;
		}

		return $__list;
	}

	private function __getContacts(){
		//@TODO: В админке сделать возможность делать контакт публичным и наоборот
		$__cond = ["region = 2600000000"]; //, "is_public = 1"

		return OrganizationsContactsModel::i()->getCompiledList($__cond, [], [], null, true);
	}

	public function execute()
	{
		parent::execute();

		parent::loadWindow("cells1/index/video_viewer");

		HeadClass::addJs([
			'/js/frontend/cells1/index.js',
			'/jquery/js/jquery.jshowoff.min.js'
		]);

		HeadClass::addLess([
			'/less/frontend/cells1/index.less',
			'/less/frontend/cells1/jshowoff.less'
		]);

		$this->page = PagesMaterialsModel::i()->getItemBySymlink('cell1.index');
		$this->news = $this->__getNews();
		$this->volya_people = $this->__getNews(0, true);
		$this->topNews = $this->__getNews(0, false, true);
		$__contacts = $this->__getContacts();

		if(count($__contacts) < 5)
			$this->contacts = $__contacts;
		else
		{
			$__keys = array_rand($__contacts, 5);
			$__list = [];
			foreach ($__keys as $__key) {
				$__list[] = $__contacts[$__key];
			}

			$this->contacts = $__list;
		}
	}

	public function loadNextNews()
	{
		parent::execute();
		parent::setViewer('json');

		$__step = Request::getInt('step');

		$this->json['list'] = $this->__getNews($__step * 9);

		return true;
	}

	public function loadNextVolyaPeople()
	{
		parent::execute();
		parent::setViewer('json');

		$__step = Request::getInt('step');

		$this->json['list'] = $this->__getNews($__step * 9, true);

		return true;
	}
}