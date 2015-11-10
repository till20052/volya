<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class ProjectsModel extends ExtendedModel
{
	protected $table = "projects";
	protected $_specificFields = array(
		"serialized" => array("description", "title", "text"),
		"date" => array("created_at", "modified_at:force")
	);
	/**
	 * @param string $instance
	 * @return ProjectsModel
	 */
	public static function i($instance = "ProjectsModel")
	{
		return parent::i($instance);
	}
}
