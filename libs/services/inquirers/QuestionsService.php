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

	public function getList($bid, $fid, $uniq = false)
	{
		if($bid > 0)
			if( ! $uniq)
				return QuestionsModel::i()->getCompiledListByField("bid", $bid);
			else{
				$__list = [];
				foreach (\Model::getCols("SELECT `id` FROM inquirers_questions WHERE `bid` = '$bid' AND `id` NOT IN (SELECT `qid` FROM inquirers_forms_content WHERE `bid` = '$bid' AND `fid` = '$fid')") as $__qid)
					$__list[] = $this->getItem($__qid);

				return $__list;
			}
		else
			return QuestionsModel::i()->getCompiledList();
	}

	public function getItem($qid, $bid = 0, $title = "")
	{
		if($qid > 0)
			return QuestionsModel::i()->getItem($qid);
		elseif($title != "")
		{
			$__list = QuestionsModel::i()->getCompiledList(["title LIKE '$title'", "bid = $bid"]);

			return isset($__list[0]) ? $__list[0] : false;
		}

		return false;
	}

	public function save($bid, $qid, $title, $type, $num)
	{
		if( ! ($__question = $this->getItem(0, $bid, $title)))
			return QuestionsModel::i()->insert([
				"bid" => $bid,
				"title" => $title,
				"type" => $type,
				"num" => $num
			]);

		QuestionsModel::i()->update([
			"id" => $qid,
			"bid" => $bid,
			"title" => $title,
			"type" => $type,
			"num" => $num
		]);

		return $__question["id"];
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

	public function isProblem($id, $value)
	{
		QuestionsModel::i()->update([
			"id" => $id,
			"is_problem" => $value
		]);
	}

	public function delete($id)
	{
		QuestionsModel::i()->deleteItem($id);
	}
}