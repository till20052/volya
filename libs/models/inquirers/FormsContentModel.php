<?php

namespace libs\models\inquirers;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class FormsContentModel extends \ExtendedModel
{
	protected $table = "inquirers_forms_content";

	/**
	 * @return mixed
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 