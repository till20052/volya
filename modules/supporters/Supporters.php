<?php

Loader::loadAppliaction("Frontend");

class SupportersController extends Frontend
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

		parent::addBreadcrumb("/supporters", t("Анкета прихильника"));
	}
}
