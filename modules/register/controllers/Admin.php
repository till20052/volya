<?php

Loader::loadModule("Register");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadClass("GeoClass", Loader::APPLICATION);

Loader::loadService("register.admin.GroupsService", Loader::APPLICATION);

use \libs\services\register\admin\GroupsService;

class AdminRegisterController extends RegisterController
{

	protected function __init()
	{
		parent::execute();
		parent::loadKendo(TRUE);
		parent::addBreadcrumb("/register/admin", t("Налаштування"));

		HeadClass::addLess(array(
			"/less/frontend/register/admin.less"
		));
	}

	public function execute()
	{
		$this->__init();
	}

	public function krkManager($args = array())
	{
		$this->__init();

		parent::addBreadcrumb("/register/admin/krk_manager", t("Менеджер КРК"));

		HeadClass::addJs([
			"/js/form.js",
			"/js/frontend/register/admin/krk.js"
		]);

		parent::loadWindow([
			"register/admin/krk_manager/form"
		]);

		$groups = new GroupsService();

		if(isset($args[0]))
			$subController = $args[0];
		else
			$subController = "get_list";

		if($subController == "get_list")
		{
			$this->pager = new PagerClass($groups->getList(), Request::getInt("page"), 14);
			$this->list = $this->pager->getList();
			return;
		}

		if($subController == "j_get_group")
		{
			parent::setViewer("json");

			$this->json["item"] = $groups->getItem(Request::getInt("id"));

			return true;
		}

		if($subController == "j_save_group")
		{
			parent::setViewer("json");

			$__id = $groups->save([
				'id' => Request::getInt("id"),
				'geo' => Request::getString("geo"),
				'members' => Request::getArray('members')
			]);

			$this->json["item"] = $groups->getItem($__id);

			return true;
		}
	}
}
