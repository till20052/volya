<?php

namespace libs\services;

\Loader::loadModel("inquirers.AnswersModel");

\Loader::loadModel("UsersModel");
\Loader::loadClass("GeoClass");
\Loader::loadClass("UserClass");

\Loader::loadService("inquirers.FormsService");
\Loader::loadService("inquirers.FormsContentService");
\Loader::loadService("inquirers.BlocksService");
\Loader::loadService("inquirers.QuestionsService");
\Loader::loadService("inquirers.AnswersService");
\Loader::loadService("inquirers.settings.ModeratorsService");
\Loader::loadService("inquirers.ResultsService");
\Loader::loadService("SupportersService");

use libs\models\inquirers\FormsContentModel;
use libs\models\inquirers\FormsModel;
use libs\services\inquirers\FormsContentService;
use libs\services\inquirers\FormsService;
use libs\services\inquirers\BlocksService;
use libs\services\inquirers\QuestionsService;
use libs\services\inquirers\AnswersService;
use libs\services\inquirers\ResultsService;
use libs\services\inquirers\settings\ModeratorsService;

class InquirersService extends \Keeper
{

	/**
	 * @return InquirersService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	// FORMS
	public function getForms()
	{
		return FormsService::i()->getList();
	}

	public function getForm($id, $geo = null)
	{
		return FormsService::i()->getItem($id, $geo);
	}

	public function saveForm($id, $geo)
	{
		return FormsService::i()->save($id, $geo);
	}

	public function publicateForm($id, $value)
	{
		FormsService::i()->publicate($id, $value);
	}

	public function deleteForm($id)
	{
		FormsService::i()->delete($id);
	}

	public function getFormsByGeo($geo)
	{
		return FormsService::i()->getListByGeo($geo);
	}

	// BLOCKS
	public function getBlocks($fid)
	{
		if($fid > 0)
			return FormsContentService::i()->getBlocks($fid);

		return BlocksService::i()->getList($fid);
	}

	public function getBlock($bid, $btitle = "")
	{
		return BlocksService::i()->getItem($bid, $btitle);
	}

	public function saveBlock($fid, $title)
	{
		$__bid = BlocksService::i()->save($fid, $title);
		FormsContentService::i()->addBlock($fid, $__bid);

		return $__bid;
	}

	public function publicateBlock($id, $state)
	{
		BlocksService::i()->publicate($id, $state);
	}

	public function deleteBlock($fid, $bid)
	{
		FormsContentService::i()->deleteBlock($fid, $bid);
	}

	public function getBlocksByFormId($fid)
	{
		return BlocksService::i()->getListByFormId($fid);
	}

	public function getBlocksByGeo($geo)
	{
		$__list = [];
		foreach ($this->getFormsByGeo($geo) as $form)
			$__list = array_merge($__list, $this->getBlocksByFormId($form["id"]));

		return $__list;
	}

	// QUESTIONS
	public function getQuestions($fid, $bid)
	{
		$__list = [];
		$__list["existing"] = [];
		$__list["available"] = [];

		$__list["existing"] = FormsContentService::i()->getQuestions($fid, $bid);
		$__list["available"] = QuestionsService::i()->getList($bid, true);

		return $__list;
	}

	public function getQuestion($qid)
	{
		return QuestionsService::i()->getItem($qid);
	}

	public function saveQuestion($fid, $bid, $qid, $title, $type, $num)
	{
		$qid = QuestionsService::i()->save($bid, $qid, $title, $type, $num);
		FormsContentService::i()->addQuestion($fid, $bid, $qid);

		return $qid;
	}

	public function publicateQuestion($id, $state)
	{
		QuestionsService::i()->publicate($id, $state);
	}

	public function isTextQuestion($id, $state)
	{
		QuestionsService::i()->isText($id, $state);
	}

	public function isProblemQuestion($id, $state)
	{
		QuestionsService::i()->isProblem($id, $state);
	}

	public function deleteQuestion($fid, $bid)
	{
		FormsContentService::i()->deleteQuestion($fid, $bid);
	}

	// ANSWERS
	public function getAnswers($fid, $qid)
	{
		$__list = [];
		$__list["existing"] = [];
		$__list["available"] = [];

		$__list["existing"] = FormsContentService::i()->getAnswers($fid, $qid);
		$__list["available"] = AnswersService::i()->getList($qid, true);

		return $__list;
	}

	public function getAnswer($aid)
	{
		return AnswersService::i()->getItem($aid);
	}

	public function saveAnswer($fid, $bid, $qid, $aid, $title)
	{
		$aid = AnswersService::i()->save($aid, $qid, $title);
		FormsContentService::i()->addAnswer($fid, $bid, $qid, $aid);

		return $aid;
	}

	public function isProblemAnswer($aid, $state)
	{
		AnswersService::i()->isProblem($aid, $state);
	}

	public function isTextAnswer($id, $state)
	{
		AnswersService::i()->isText($id, $state);
	}

	public function publicateAnswer($aid, $state)
	{
		AnswersService::i()->publicate($aid, $state);
	}

	public function deleteAnswer($id)
	{
		AnswersService::i()->delete($id);
	}

	// SETTINGS

	// // MODERATORS

	public function getModerators()
	{
		return ModeratorsService::i()->getList();
	}

	public function getModerator($mid)
	{
		return ModeratorsService::i()->getItem($mid);
	}

	public function saveModerator($data)
	{
		return ModeratorsService::i()->save($data);
	}

	// ANSWERS

	public function getCompiledInquirer($id = 0)
	{
		if($id > 0)
			$geo = null;
		else
			$geo = \UserClass::i()->getGeo();

		$__item["form"] = $this->getForm($id, $geo);
		$__item = array_merge($__item, FormsContentService::i()->getInquirer($__item["form"]["id"]));

		return $__item;
	}

	// RESULTS

	public function saveResult($data)
	{
		return ResultsService::i()->save($data);
	}

	public function getResultsBySupporterId($pid)
	{
		$__profile = SupportersService::i()->getSupporter($pid);
		$__results = ResultsService::i()->getResultsBySupporterId($pid);
		$__form = $this->getCompiledInquirer($__results["fid"]);

		foreach ($__results["results"] as $__result) {
			if (
				isset($__form["blocks"][$__result["bid"]]["questions"][$__result["qid"]]["is_text"])
				&& $__form["blocks"][$__result["bid"]]["questions"][$__result["qid"]]["is_text"]
			)
				$__form["blocks"][$__result["bid"]]["questions"][$__result["qid"]]["answer"] = $__result["value"];
			else
				$__form["blocks"][$__result["bid"]]["questions"][$__result["qid"]]["answers"][$__result["aid"]]["selected"] = [
					"state" => true,
					"value" => $__result["value"]
				];
		}

		return [
			"profile" => $__profile,
			"form" => $__form
		];
	}

	// SUPPORTERS

	public function getSupporters()
	{
		return SupportersService::i()->getSupporters();
	}

	public function getSupportersByAnswers($answers)
	{
		return ResultsService::i()->getSupportersByAnswers($answers);
	}

	public function getSupportersByQuestion($question)
	{
		return ResultsService::i()->getSupportersByQuestion($question);
	}

	public function getSupportersByBlock($block)
	{
		return ResultsService::i()->getSupportersByBlock($block);
	}

	public function getSupportersByGeo($geo)
	{
		return SupportersService::i()->getSupportersByGeo($geo);
	}

	// ANALYTICS

	public function getAnalyticsData($options)
	{
		$data = [];
		switch ($options["type"]) {
			case "by_block":

				$data["categories"] = $this->getQuestions($options["bid"]);

				return $data["categories"];

				break;
		}
	}
}