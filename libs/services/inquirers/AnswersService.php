<?php

namespace libs\services\inquirers;

\Loader::loadModel("inquirers.AnswersModel");

\Loader::loadClass("GeoClass");

use \libs\models\inquirers\AnswersModel;

class AnswersService extends \Keeper
{

	/**
	 * @return AnswersService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getList($qid)
	{
		return AnswersModel::i()->getCompiledListByField("qid", $qid);
	}

	public function getItem($id)
	{
		return AnswersModel::i()->getItem($id);
	}

	public function save($aid, $qid, $title)
	{
		if( ! AnswersModel::i()->update([
			"id" => $aid,
			"qid" => $qid,
			"title" => $title
		]))
			return AnswersModel::i()->insert([
				"qid" => $qid,
				"title" => $title
			]);

		return $aid;
	}

	public function publicate($aid, $value)
	{
		AnswersModel::i()->update([
			"id" => $aid,
			"is_public" => $value
		]);
	}

	public function isProblem($aid, $value)
	{
		AnswersModel::i()->update([
			"id" => $aid,
			"is_problem" => $value
		]);
	}

	public function isText($aid, $value)
	{
		AnswersModel::i()->update([
			"id" => $aid,
			"is_text" => $value
		]);
	}

	public function delete($id)
	{
		AnswersModel::i()->deleteItem($id);
	}
}