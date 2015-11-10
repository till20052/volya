<?php

namespace libs\models\register\members;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class VerificationModel extends \ExtendedModel
{
	protected $table = "register_members_verifications";
	protected $_specificFields = array(
		"date" => array("created_at:force")
	);

	/**
	 * @param string $instance
	 * @return VarificationModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 