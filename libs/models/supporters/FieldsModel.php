<?php

namespace libs\models\supporters;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class FieldsModel extends \ExtendedModel
{
	protected $table = "supporters_fields";
	protected $_specificFields = array(
		"date" => array("modified_at:force")
	);

	/**
	 * @param string $instance
	 * @return FieldsModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
}