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

	public function getList($qid, $fid, $uniq = false)
	{
		if($qid > 0)
			if( ! $uniq)
				return AnswersModel::i()->getCompiledListByField("qid", $qid);
			else{
				$__list = [];
				foreach (\Model::getCols("SELECT `id` FROM inquirers_answers WHERE `qid` = '$qid' AND `id` NOT IN (SELECT `aid` FROM inquirers_forms_content WHERE `qid` = '$qid' AND `fid` = '$fid')") as $__aid)
					$__list[] = $this->getItem($__aid);

				return $__list;
			}
		else
			return AnswersModel::i()->getCompiledList();
	}

	public function getItem($aid, $qid = 0, $title = "")
	{
		if($aid > 0)
			return AnswersModel::i()->getItem($aid);
		elseif($title != "")
		{
			$__list = AnswersModel::i()->getCompiledList(["title LIKE '$title'", "qid = $qid"]);

			return isset($__list[0]) ? $__list[0] : false;
		}

		return false;
	}

	public function save($aid, $qid, $title)
	{
		if( ! ($__answer = $this->getItem(0, $qid, $title)))
			return AnswersModel::i()->insert([
				"qid" => $qid,
				"title" => $title
			]);

		AnswersModel::i()->update([
			"id" => $aid,
			"qid" => $qid,
			"title" => $title
		]);

		return $__answer["id"];
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