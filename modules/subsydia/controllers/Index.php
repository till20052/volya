<?php

Loader::loadModule("Subsydia");

class IndexSubsydiaController extends SubsydiaController
{
	public function execute()
	{
		parent::execute();

		HeadClass::addJs([
			"/js/frontend/subsydia/index.js"
		]);

		HeadClass::addLess([
			"/less/frontend/subsydia/index.less"
		]);
	}
}