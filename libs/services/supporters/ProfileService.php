<?php

namespace libs\services\supporters;

use libs\models\supporters\ProfileModel;

\Loader::loadModel("supporters.ProfileModel");

class ProfileService extends \Keeper
{

	/**
	 * @return ProfileService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getList($cond, $bind)
	{
		return ProfileModel::i()->getCompiledList($cond, $bind);
	}

	public function getItem($id)
	{
		return ProfileModel::i()->getItem($id);
	}

	public function save($data)
	{
		if( ! isset($data["id"]))
			return ProfileModel::i()->insert($data);
		else
			ProfileModel::i()->update($data);

		return $data["id"];
	}

	public function getTypeByKey($key)
	{
		return ProfileModel::i()->getTypeByKey($key);
	}

	public function getTypeById($id)
	{
		return ProfileModel::i()->getTypeById($id);
	}
}