<?php

namespace libs\models\reports;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class ReportsModel extends \ExtendedModel
{
	protected $table = "reports";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);

	/**
	 * @return mixed
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
}
