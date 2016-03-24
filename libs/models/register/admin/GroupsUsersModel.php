<?php

namespace libs\models\register\admin;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class GroupsUsersModel extends \ExtendedModel
{
	protected $table = "register_admin_groups_users";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);

	/**
	 * @param string $instance
	 * @return GroupsUsersModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
}
