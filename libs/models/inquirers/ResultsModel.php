<?php

namespace libs\models\inquirers;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class ResultsAnswersModel extends \ExtendedModel
{
	protected $table = "inquirers_results_answers";
	protected $_specificFields = array(
		"date" => array("modified_at:force")
	);

	/**
	 * @param string $instance
	 * @return ResultsAnswersModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 