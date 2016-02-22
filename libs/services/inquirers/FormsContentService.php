<?php

namespace libs\services\inquirers;

\Loader::loadModel("inquirers.FormsContentModel");

\Loader::loadService("inquirers.FormsService");
\Loader::loadService("inquirers.BlocksService");
\Loader::loadService("inquirers.QuestionsService");
\Loader::loadService("inquirers.AnswersService");

use \libs\models\inquirers\FormsContentModel;

class FormsContentService extends \Keeper
{

	/**
	 * @return FormsContentService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function addBlock($fid, $bid)
	{
		FormsContentModel::i()->insert([
			"fid" => $fid,
			"bid" => $bid,
			"qid" => 0,
			"aid" => 0
		]);
	}

	public function addQuestion($fid, $bid, $qid)
	{
		\Model::exec("DELETE FROM inquirers_forms_content WHERE `fid` = '" . $fid . "' AND `bid` = '" . $bid . "' AND `qid` = 0");

		FormsContentModel::i()->insert([
			"fid" => $fid,
			"bid" => $bid,
			"qid" => $qid,
			"aid" => 0
		]);
	}

	public function addAnswer($fid, $bid, $qid, $aid)
	{
		\Model::exec("DELETE FROM inquirers_forms_content WHERE `fid` = '" . $fid . "' AND `qid` = '" . $qid . "' AND `aid` = 0");

		FormsContentModel::i()->insert([
			"fid" => $fid,
			"bid" => $bid,
			"qid" => $qid,
			"aid" => $aid
		]);
	}

	public function getBlock($fid, $bid)
	{

	}
	
	public function getBlocks($fid)
	{
		$__blocks = [];
		$__sql = "SELECT `bid` FROM inquirers_forms_content WHERE `fid` = '$fid' GROUP BY `bid`";

		foreach (\Model::getCols($__sql) as $__bid)
			$__blocks[] = BlocksService::i()->getItem($__bid);

		return $__blocks;
	}

	public function getQuestions($fid, $bid)
	{
		$__blocks = [];
		$__sql = "SELECT `qid` FROM inquirers_forms_content WHERE `fid` = '$fid' AND `bid` = '$bid' AND `qid` > 0 GROUP BY `qid`";

		foreach (\Model::getCols($__sql) as $__qid)
			$__blocks[] = QuestionsService::i()->getItem($__qid);

		return $__blocks;
	}

	public function getAnswers($fid, $qid)
	{
		$__answers = [];
		$__sql = "SELECT `aid` FROM inquirers_forms_content WHERE `fid` = '$fid' AND `qid` = '$qid' AND `aid` > 0";

		foreach (\Model::getCols($__sql) as $__aid)
			$__answers[] = AnswersService::i()->getItem($__aid);

		return $__answers;
	}

	public function deleteBlock($fid, $bid)
	{
		\Model::exec("DELETE FROM inquirers_forms_content WHERE `fid` = '$fid' AND `bid` = '$bid'");

		return true;
	}

	public function deleteQuestion($fid, $qid)
	{
		\Model::exec("DELETE FROM inquirers_forms_content WHERE `fid` = '$fid' AND `qid` = '$qid'");

		return true;
	}

	public function getInquirer($fid)
	{
		$__item = [];
		foreach ($this->getBlocks($fid) as $__block) {
			$__questions = [];

			foreach ($this->getQuestions($fid, $__block["id"]) as $__question) {
				foreach ($this->getAnswers($fid, $__question["id"]) as $__answer)
					$__question["answers"][$__answer["id"]] = $__answer;

				$__questions[$__question["id"]] = $__question;
			}

			$__item["blocks"][$__block["id"]] = array_merge(
				$__block,
				[
					"questions" => $__questions
				]
			);
		}

		return $__item;
	}
}