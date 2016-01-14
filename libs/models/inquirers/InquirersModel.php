<?php

namespace libs\models\inquirers;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class InquirersModel extends \ExtendedModel
{
	protected $table = "inquirers";
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