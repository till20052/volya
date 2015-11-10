<?php

namespace libs\models\register\members;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class ApprovesModel extends \ExtendedModel
{
	protected $table = "register_members_approves";
	protected $_specificFields = array(
		"date" => array("created_at:force")
	);

	/**
	 * @param string $instance
	 * @return ApprovesModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 