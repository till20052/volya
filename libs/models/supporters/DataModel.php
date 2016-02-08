<?php

namespace libs\models\supporters;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class DataModel extends \ExtendedModel
{
	protected $table = "supporters_data";
	protected $_specificFields = array(
		"date" => array("modified_at:force")
	);

	/**
	 * @param string $instance
	 * @return DataModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
}