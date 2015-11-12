<?php

Loader::loadAppliaction("Frontend");
Loader::loadService("register.DocumentsService", Loader::APPLICATION);
Loader::loadService("register.admin.GroupsService");

use \libs\services\register\admin\GroupsService;
use \libs\services\register\documents\DocumentsService;

class RegisterController extends Frontend
{
	public static $documents;

	function __construct()
	{
		parent::__construct();

		$this->addAccessHandler(function($uid, $credentials = false){

			if( ! ($__group = GroupsService::i()->getGroupByUid($uid)))
				return false;

			if( ! $credentials)
				return true;

			$credentials->showSettings = false;

			if($__group["type"] == 0)
			{
				$credentials->filter["geo"] = $__group["geo"];
				$credentials->showRegionsFilter = false;
				$credentials->approver = false;
				$credentials->verifier = true;
			}

			if($__group["type"] == 1)
			{
				$credentials->showRegionsFilter = true;
				$credentials->approver = false;
				$credentials->verifier = true;
			}

			if($__group["type"] == 2)
			{
				$credentials->approver = true;
				$credentials->showSettings = true;
			}

			$credentials->showAddButton = true;
			return true;
		});
	}

	public function execute()
	{
		parent::execute();

		$credentials = new stdClass();

		if( ! $this->hasAccess(UserClass::i()->getId(), $credentials))
			$this->redirect('/');

		$this->cred = $credentials;

		HeadClass::addLess(array(
			"/less/frontend/register/main.less"
		));

		self::$documents = new DocumentsService();

		parent::addBreadcrumb("/register", t("Єдиний реєстр"));
	}
}
