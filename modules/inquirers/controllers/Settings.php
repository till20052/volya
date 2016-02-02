<?php

Loader::loadModule("Inquirers");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadClass("GeoClass", Loader::APPLICATION);

\Loader::loadService("InquirersService");

use \libs\services\InquirersService;

class SettingsInquirersController extends InquirersController
{

	protected function __init()
	{
		parent::execute();
		parent::loadKendo(TRUE);
		parent::addBreadcrumb("/inquirers/settings", t("Налаштування"));

		HeadClass::addLess(array(
			"/less/frontend/register/admin.less"
		));
	}

	public function execute()
	{
		$this->__init();
	}

	public function moderators($args = array())
	{
		$this->__init();

		parent::addBreadcrumb("/inquirers/settings/moderators", t("Модератори"));

		HeadClass::addJs([
			"/js/form.js",
			"/js/frontend/inquirers/settings/moderators.js"
		]);

		parent::loadWindow([
			"inquirers/settings/moderators/form"
		]);

		if(isset($args[0]))
			$subController = $args[0];
		else
			$subController = "get_list";

		if($subController == "get_list")
		{
			$this->pager = new PagerClass(InquirersService::i()->getModerators(), Request::getInt("page"), 14);
			$this->list = $this->pager->getList();
			return;
		}

		if($subController == "get_moderator")
		{
			parent::setViewer("json");

			$this->json["item"] = InquirersService::i()->getModerator(Request::getInt("id"));

			return true;
		}

		if($subController == "save_moderator")
		{
			parent::setViewer("json");

			$__id = InquirersService::i()->saveModerator([
				'id' => Request::getInt("id"),
				'geo' => Request::getString("geo"),
				'uid' => Request::getInt('uid')
			]);

			$this->json["item"] = InquirersService::i()->getModerator($__id);

			return true;
		}
	}
}
