<?php

namespace libs\models\structures;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class DocumentsModel extends \ExtendedModel
{
	protected $table = "structures_documents";

	/**
	 * @param string $instance
	 * @return DocumentsModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 