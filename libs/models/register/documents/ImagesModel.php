<?php

namespace libs\models\register\documents;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class ImagesModel extends \ExtendedModel
{
	protected $table = "register_documents_images";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	/**
	 * @param string $instance
	 * @return ImagesModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
}
