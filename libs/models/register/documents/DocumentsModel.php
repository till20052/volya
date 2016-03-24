<?php

namespace libs\models\register\documents;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class DocumentsModel extends \ExtendedModel
{
	protected $table = "register_documents";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	/**
	 * @param string $instance
	 * @return DocumentsModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
}
