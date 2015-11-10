<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class OrganizationsContactsValuesModel extends ExtendedModel
{
	protected $table = "organizations_contacts_values";

	/**
	 * @param string $instance
	 * @return ExtendedModel
	 */
	public static function i($instance = "OrganizationsContactsValuesModel")
	{
		return parent::i($instance);
	}
}
