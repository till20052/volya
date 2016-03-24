<?php

namespace libs\models\register\documents;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class CategoriesModel extends \ExtendedModel
{
	protected $table = "register_documents_categories";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	/**
	 * @param string $instance
	 * @return CategoriesModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
}
