<?php

Loader::loadModule("Inquirers");

class IndexInquirersController extends InquirersController
{
	public function execute()
	{
		parent::execute();

		HeadClass::addLess("/less/frontend/inquirers/index.less");
	}
}
