<?php

namespace libs\models\inquirers;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class AnswersModel extends \ExtendedModel
{
	protected $table = "inquirers_answers";
	protected $_specificFields = array(
		"date" => array("modified_at:force")
	);

	/**
	 * @param string $instance
	 * @return AnswersModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 