<?php

namespace libs\models\inquirers\settings;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class ModeratorsModel extends \ExtendedModel
{
	protected $table = "inquirers_moderators";
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