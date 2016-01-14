<?php

namespace libs\models\inquirers;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class QuestionsModel extends \ExtendedModel
{
	protected $table = "inquirers_questions";
	protected $_specificFields = array(
		"date" => array("modified_at:force")
	);

	/**
	 * @param string $instance
	 * @return QuestionsModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 