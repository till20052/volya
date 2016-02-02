<?php

namespace libs\services;

\Loader::loadModel("inquirers.AnswersModel");

\Loader::loadModel("UsersModel");
\Loader::loadClass("GeoClass");
\Loader::loadClass("UserClass");

\Loader::loadService("inquirers.FormsService");
\Loader::loadService("inquirers.BlocksService");
\Loader::loadService("inquirers.QuestionsService");
\Loader::loadService("inquirers.AnswersService");
\Loader::loadService("inquirers.settings.ModeratorsService");

use libs\services\inquirers\FormsService;
use libs\services\inquirers\BlocksService;
use libs\services\inquirers\QuestionsService;
use libs\services\inquirers\AnswersService;
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

	public function getForm($id)
	{
		return FormsService::i()->getItem($id);
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

	// BLOCKS
	public function getBlocks($fid)
	{
		return BlocksService::i()->getList($fid);
	}

	public function getBlock($bid)
	{
		return BlocksService::i()->getItem($bid);
	}

	public function saveBlock($id, $fid, $title)
	{
		return BlocksService::i()->save($id, $fid, $title);
	}

	public function publicateBlock($id, $state)
	{
		BlocksService::i()->publicate($id, $state);
	}

	public function deleteBlock($id)
	{
		BlocksService::i()->delete($id);
	}

	// QUESTIONS
	public function getQuestions($bid)
	{
		return QuestionsService::i()->getList($bid);
	}

	public function getQuestion($qid)
	{
		return QuestionsService::i()->getItem($qid);
	}

	public function saveQuestion($data)
	{
		return QuestionsService::i()->save($data);
	}

	public function publicateQuestion($id, $state)
	{
		QuestionsService::i()->publicate($id, $state);
	}

	public function deleteQuestion($id)
	{
		QuestionsService::i()->delete($id);
	}

	// ANSWERS
	public function getAnswers($qid)
	{
		return AnswersService::i()->getList($qid);
	}

	public function getAnswer($aid)
	{
		return AnswersService::i()->getItem($aid);
	}

	public function saveAnswer($aid, $qid, $title)
	{
		return AnswersService::i()->save($aid, $qid, $title);
	}

	public function isProblemAnswer($aid, $state)
	{
		AnswersService::i()->isProblem($aid, $state);
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
}