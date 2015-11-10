<?php

namespace libs\models\register\admin;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class GroupsModel extends \ExtendedModel
{
	protected $table = "register_admin_groups";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);

	/**
	 * @return \ExtendedModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
}
