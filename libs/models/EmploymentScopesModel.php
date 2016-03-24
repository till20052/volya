<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class EmploymentScopesModel extends ExtendedModel
{
	protected $table = "employment_scopes";
	
	/**
	 * @param string $instance
	 * @return EmploymentScopesModel
	 */
	public static function i($instance = "EmploymentScopesModel")
	{
		return parent::i($instance);
	}
}
