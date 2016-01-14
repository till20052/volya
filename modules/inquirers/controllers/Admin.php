<?php

\Loader::loadModule("Inquirers");
\Loader::loadService("InquirersService");

use \libs\services\InquirersService;

class AdminInquirersController extends InquirersController
{
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadWindow([
			"inquirers/admin/inquirer"
		]);

		HeadClass::addLess("/less/frontend/inquirers/admin.less");

		$this->list = InquirersService::i()->getInquirers();
	}

	public function save()
	{
		parent::setViewer("json");

		Console::log( Request::get("geo") );
	}
}
