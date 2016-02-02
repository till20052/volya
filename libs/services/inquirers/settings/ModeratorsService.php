<?php

namespace libs\services\inquirers\settings;

\Loader::loadModel("inquirers.settings.ModeratorsModel");

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

		return array_merge(
			$__item,
			[
				"title" => \GeoClass::i()->location($__item["geo"])["location"]
			]
		);
	}

	public function save($data)
	{
		if( ! QuestionsModel::i()->update($data))
			return QuestionsModel::i()->insert($data);

		return $data["id"];
	}

	public function delete($id)
	{
		ModeratorsModel::i()->deleteItem($id);
	}
}