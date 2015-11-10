<?php

Loader::loadModule("Page");
Loader::loadModel("materials.PagesMaterialsModel");

class IndexPageController extends PageController
{
	public function execute($args = array())
	{
		parent::execute();
		
		if(
				! isset($args[0])
				|| ! ($__item = PagesMaterialsModel::i()->getItemBySymlink($args[0]))
		){
			parent::redirect("/errors/404");
		}
		
		parent::title($__item["title"][Router::getLang()]." | ".parent::title());
		
		$this->item = $__item;
	}
}
