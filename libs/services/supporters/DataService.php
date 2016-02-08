<?php

namespace libs\services\supporters;

\Loader::loadModel("supporters.DataModel");

use \libs\models\supporters\DataModel;

class DataService extends \Keeper
{

	/**
	 * @return DataService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function save($data)
	{
		if( ! isset($data["id"]))
			return DataModel::i()->insert($data);
		else
			DataModel::i()->update($data);

		return $data["id"];
	}
}