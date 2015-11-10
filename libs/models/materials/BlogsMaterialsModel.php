<?php

Loader::loadModel("MaterialsModel");

class BlogsMaterialsModel extends MaterialsModel
{
	protected $_type = "blog";
	/**
	 * @param string $instance
	 * @return BlogsMaterialsModel
	 */
	public static function i($instance = "BlogsMaterialsModel")
	{
		return parent::i($instance);
	}
}
