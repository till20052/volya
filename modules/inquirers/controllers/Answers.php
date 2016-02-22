<?php

Loader::loadModule("Inquirers");

\Loader::loadService("InquirersService");

use \libs\services\InquirersService;

class AnswersInquirersController extends InquirersController
{
	public function execute($args = [])
	{
		parent::execute();
		parent::addBreadcrumb("/inquirers/answers", t("Внесення результатів"));

		HeadClass::addLess("/less/frontend/inquirers/answers.less");
		HeadClass::addJs([
			"/jquery/js/jquery.masonry.js",
			"/js/frontend/inquirers/answers.js"
		]);

		$id = 0;
		if(isset($args[0]))
			$id = $args[0];

		$this->inquirer = InquirersService::i()->getCompiledInquirer($id);
	}

	public function saveResult()
	{
		parent::setViewer("json");

		InquirersService::i()->saveResult(Request::getArray("data"));

		return true;
	}
}
