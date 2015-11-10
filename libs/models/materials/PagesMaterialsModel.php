<?php

Loader::loadModel("MaterialsModel");

class PagesMaterialsModel extends MaterialsModel
{
	protected $_type = "page";
	
	/**
	 * @param string $instance
	 * @return PagesMaterialsModel
	 */
	public static function i($instance = "PagesMaterialsModel")
	{
		return parent::i($instance);
	}
}
