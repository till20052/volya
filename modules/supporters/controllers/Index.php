<?php

Loader::loadModule("Supporters");

Loader::loadModel("SupportersModel");

class IndexSupportersController extends SupportersController
{
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);

		HeadClass::addLess("/less/frontend/supporters/index.less");

		HeadClass::addJs([
			"/js/frontend/supporters/index.js",
			"/js/form.js"
		]);
	}

	public function add()
	{
		parent::setViewer("json");

		if(
			Request::getString("fname") == ""
			|| Request::getString("lname") == ""
			|| Request::getString("mname") == ""
			|| Request::getString("phone") == ""
			|| Request::getString("email") == ""
			|| Request::getString("street") == ""
			|| Request::getString("area") == ""
			|| ! Request::getInt("bday")
			|| ! Request::getInt("bmonth")
			|| ! Request::getInt("byear")
			|| ! Request::getInt("house_number")
			|| ! Request::getInt("apartment_number")
		)
			return false;

		SupportersModel::i()->insert([
			"fname" => Request::getString("fname"),
			"lname" => Request::getString("lname"),
			"mname" => Request::getString("mname"),

			"bday" => Request::getInt("bday"),
			"bmonth" => Request::getInt("bmonth"),
			"byear" => Request::getInt("byear"),

			"phone" => Request::getString("phone"),
			"email" => Request::getString("email"),
			"address" => Request::getString("street") . ", буд. " . Request::getInt("house_number") . ", кв. " . Request::getInt("apartment_number"),

			"area" => Request::getString("area"),
			"ic" => Request::getString("ic")
		]);

		return true;
	}
}
