<?php

namespace libs\models\supporters;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class StatusesModel extends \ExtendedModel
{
	protected $table = "supporters_statuses";
	protected $_specificFields = array(
		"date" => array("modified_at:force")
	);

	/**
	 * @param string $instance
	 * @return StatusesModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
}