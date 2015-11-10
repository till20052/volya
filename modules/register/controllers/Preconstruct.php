<?php

Loader::loadModule("Register");
Loader::loadClass("GeoClass");
Loader::loadService("structures.InitService");

use \libs\services\structures\InitService;

class PreconstructRegisterController extends RegisterController
{
	public function execute()
	{
		parent::execute();

		Console::log( InitService::i()->constructRerionsStructures() );
	}
}
