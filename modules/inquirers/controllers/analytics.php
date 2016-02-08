<?php

Loader::loadModule("Inquirers");

\Loader::loadService("InquirersService");

use \libs\services\InquirersService;

class AnalyticsInquirersController extends InquirersController
{
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::addBreadcrumb("/inquirers/analytics", t("Аналіз результатів"));

		HeadClass::addLess("/less/frontend/inquirers/analytics.less");
		HeadClass::addJs([
			"/js/frontend/inquirers/analytics.js"
		]);

		$this->forms = InquirersService::i()->getBlocksByGeo("0000000000");
	}
}
