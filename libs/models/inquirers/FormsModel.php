<?php

namespace libs\models\inquirers;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class FormsModel extends \ExtendedModel
{
	protected $table = "inquirers_forms";
	protected $_specificFields = array(
		"date" => array("modified_at:force")
	);

	/**
	 * @return mixed
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 