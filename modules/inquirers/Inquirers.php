<?php

Loader::loadAppliaction("Frontend");

class InquirersController extends Frontend
{
	public static $documents;

	function __construct()
	{
		parent::__construct();

		$this->addAccessHandler(function($uid, $credentials = false){

			if( ! $credentials)
				return true;


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

		HeadClass::addJs(array(
			"/js/frontend/inquirers/admin.js",
			"/js/form.js",
		));

		parent::addBreadcrumb("/inquirers", t("Опитування"));
	}
}
