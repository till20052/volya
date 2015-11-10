<?php

namespace libs\models\structures;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class StructuresModel extends \ExtendedModel
{
	protected $table = "structures";
	protected $_specificFields = array(
		"date" => array("modified_at:force")
	);

	/**
	 * @param string $instance
	 * @return StructuresModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 