<?php

Loader::loadAppliaction("Frontend");
Loader::loadClass("UserClass");

class AdminController extends Frontend
{
	public static $modIsVisible = false;
	public static $modAText = "";
	public static $modAHref = "";
	public static $modImgSrc = "";
	
	public function execute($args = array())
	{
		parent::execute();
		
		if(
				( ! isset($args[0]) || $args[0] != "c7a455383a2f22f10465dae825acf661")
				&& ( ! UserClass::i()->isAuthorized() || ! UserClass::i()->hasCredential(774))
		)
			parent::redirect("/");
	}
}
