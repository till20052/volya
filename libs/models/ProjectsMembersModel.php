<?php

Loader::loadModel("ExtendedModel");

class ProjectsMembersModel extends ExtendedModel
{
	protected $table = "projects_members";
	
	/**
	 * @param string $instance
	 * @return ProjectsMembersModel
	 */
	public static function i($instance = "ProjectsMembersModel")
	{
		return parent::i($instance);
	}
}
