<?php

Loader::loadAppliaction("Frontend");

class ElectionController extends Frontend
{
	public function execute()
	{
		parent::execute();
		
		HeadClass::addLess("/less/frontend/election/index.less");
		
		parent::title(t("Вибори 2014")." | ".parent::title());
		parent::description("Вибори 2014");
		parent::keywords("Вибори 2014");
	}
}
