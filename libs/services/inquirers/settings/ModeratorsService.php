<?php

namespace libs\services\inquirers\settings;

\Loader::loadModel("inquirers.settings.ModeratorsModel");
\Loader::loadModel("UsersModel");

use \libs\models\inquirers\settings\ModeratorsModel;

class ModeratorsService extends \Keeper
{

	/**
	 * @return ModeratorsModel
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getList()
	{
		$__list = [];

		foreach(ModeratorsModel::i()->getCompiledList([], [], ["id DESC"]) as $__item)
			$__list[] = array_merge(
				$__item,
				[
					"title" => \GeoClass::i()->location($__item["geo"])["location"]
				]
			);

		return $__list;
	}

	public function getItem($id)
	{
		$__item = ModeratorsModel::i()->getItem($id);
		$__item["user"] = \UsersModel::i()->getItem($__item["uid"]);

		return array_merge(
			$__item,
			[
				"title" => \GeoClass::i()->location($__item["geo"])["location"]
			]
		);
	}

	public function save($data)
	{
		list($fname, $lname) = explode(" ", $data["user"]);

		$uid = \UsersModel::i()->getCompiledList(["first_name = :fname", "last_name = :lname"], ["fname" => $fname, "lname" => $lname])[0]["id"];

		unset($data["user"]);
		$data["uid"] = $uid;

		if( ! ModeratorsModel::i()->update($data))
			return ModeratorsModel::i()->insert($data);

		return $data["id"];
	}

	public function delete($id)
	{
		ModeratorsModel::i()->deleteItem($id);
	}
}