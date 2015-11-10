<?php

Loader::loadAppliaction("Frontend");

class SeminarController extends Frontend
{
	public function execute()
	{
		parent::execute();
		HeadClass::addLess("/less/frontend/seminar.less");
	}
}