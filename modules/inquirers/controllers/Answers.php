<?php

Loader::loadModule("Inquirers");

\Loader::loadService("InquirersService");

use \libs\services\InquirersService;

class AnswersInquirersController extends InquirersController
{
	public function execute()
	{
		parent::execute();
		parent::addBreadcrumb("/inquirers/answers", t("Внесення результатів"));

		HeadClass::addLess("/less/frontend/inquirers/answers.less");
		HeadClass::addJs([
			"/jquery/js/jquery.masonry.js",
			"/js/frontend/inquirers/answers.js"
		]);

		$this->inquirer = InquirersService::i()->getCompiledInquirer();
	}
}
