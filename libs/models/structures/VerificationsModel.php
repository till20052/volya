<?php

namespace libs\models\structures;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class VerificationsModel extends \ExtendedModel
{
	protected $table = "structures_verifications";
	protected $_specificFields = array(
		"date" => array("created_at:force")
	);

	/**
	 * @param string $instance
	 * @return VerificationsModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 