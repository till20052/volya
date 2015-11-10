<?php

Loader::loadAppliaction("Frontend");

class PartyController extends Frontend
{
	public function execute()
	{
		parent::execute();
		
		HeadClass::addLess("/less/frontend/party/index.less");
		
		$this->selected = "";
	}
}
