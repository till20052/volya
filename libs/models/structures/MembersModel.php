<?php

namespace libs\models\structures;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class MembersModel extends \ExtendedModel
{
	protected $table = "structures_members";
	protected $_specificFields = array(
		"date" => array("created_at:force")
	);

	/**
	 * @param string $instance
	 * @return MembersModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 