<?php

Loader::loadModule("Register");

class IndexRegisterController extends RegisterController
{
	public function execute()
	{
		parent::execute();

		HeadClass::addLess("/less/frontend/register/index.less");
	}
}
