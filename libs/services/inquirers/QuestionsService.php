<?php

namespace libs\services\inquirers;

\Loader::loadModel("inquirers.QuestionsModel");

\Loader::loadClass("GeoClass");

use \libs\models\inquirers\QuestionsModel;

class QuestionsService extends \Keeper
{

	/**
	 * @return QuestionsService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getList($bid)
	{
		return QuestionsModel::i()->getCompiledListByField("bid", $bid);
	}

	public function getItem($id)
	{
		return QuestionsModel::i()->getItem($id);
	}

	public function save($data)
	{
		if( ! QuestionsModel::i()->update($data))
			return QuestionsModel::i()->insert($data);

		return $data["id"];
	}

	public function publicate($id, $value)
	{
		QuestionsModel::i()->update([
			"id" => $id,
			"is_public" => $value
		]);
	}

	public function isText($id, $value)
	{
		QuestionsModel::i()->update([
			"id" => $id,
			"is_text" => $value
		]);
	}

	public function delete($id)
	{
		QuestionsModel::i()->deleteItem($id);
	}
}