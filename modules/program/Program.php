<?php

Loader::loadAppliaction("Frontend");

class ProgramController extends Frontend
{
	public function execute()
	{
		parent::execute();
		
		HeadClass::addLess("/less/frontend/program/index.less");
	}
}
