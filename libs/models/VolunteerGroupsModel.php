<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class VolunteerGroupsModel extends ExtendedModel
{
	protected $table = "volunteer_groups";
	protected $_specificFields = array(
			"date" => array("created_at","modified_at:force"),
			"serialized" => array("name")
	);
	
	/**
	 * @param string $peer
	 * @return VolunteersGroupsModel
	 */
	public static function i($peer = "VolunteerGroupsModel")
	{
		return parent::i($peer);
	}
}
