<?php

namespace libs\models\inquirers;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class BlocksModel extends \ExtendedModel
{
	protected $table = "inquirers_blocks";
	protected $_specificFields = array(
		"date" => array("modified_at:force")
	);

	/**
	 * @param string $instance
	 * @return BlocksModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
} 