<?php

namespace libs\services\supporters;

\Loader::loadModel("supporters.FieldsModel");

use \libs\models\supporters\FieldsModel;

class FieldsService extends \Keeper
{

	/**
	 * @return FieldsService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getFieldByKey($key)
	{
		return FieldsModel::i()->getItemByField("key", $key);
	}
}