<?php

Loader::loadModel("MaterialsModel");

class ProjectsMaterialsModel extends MaterialsModel
{
	protected $_type = "projects";
	protected $_dateFormat = "Y-m-d H:i:s";
	protected $_specificFields = array(
		"serialized" => array("description", "title", "text"),
	);
	
	public static function i($instance = "ProjectsMaterialsModel")
	{
		return parent::i($instance);
	}
}
