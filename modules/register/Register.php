<?php

Loader::loadAppliaction("Frontend");
Loader::loadService("register.DocumentsService", Loader::APPLICATION);

use \libs\services\register\documents\DocumentsService;

class RegisterController extends Frontend
{
	public static $documents;

	function __construct()
	{
		parent::__construct();

		$this->addAccessHandler(function(){
			echo "RegisterController\n<br/>";
		});
	}

	public function execute()
	{
		parent::execute();

//		$this->hasAccess();

		HeadClass::addLess(array(
			"/less/frontend/register/main.less"
		));

		self::$documents = new DocumentsService();

		parent::addBreadcrumb("/register", t("Єдиний реєстр"));
	}
}
