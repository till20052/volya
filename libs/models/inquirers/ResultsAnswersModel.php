<?php

namespace libs\models\inquirers;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class ResultsModel extends \ExtendedModel
{
	protected $table = "inquirers_results";
	protected $_specificFields = array(
		"date" => array("modified_at:force")
	);

	/**
	 * @param string $instance
	 * @return ResultsModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 