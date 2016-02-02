<?php

\Loader::loadModule("Inquirers");
\Loader::loadService("InquirersService");

\Loader::loadClass("PagerClass", Loader::SYSTEM);

use \libs\services\InquirersService;

class AdminInquirersController extends InquirersController
{
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadWindow([
			"inquirers/admin/inquirer",
			"inquirers/admin/windows/blocks",
			"inquirers/admin/windows/answers"
		]);

		HeadClass::addLess("/less/frontend/inquirers/admin.less");

		HeadClass::addJs("/js/frontend/inquirers/admin.js");

		$__list = InquirersService::i()->getForms();

		$__pager = new PagerClass($__list, Request::getInt("page"), 14);

		$this->list = $__pager->getList();
		$this->pager = $__pager;
	}

	// FORMS
	public function saveForm()
	{
		parent::setViewer("json");

		$this->json["item"] = InquirersService::i()->saveForm(Request::getInt("fid", 0), Request::getString("geo"));

		return true;
	}

	public function getForm()
	{
		parent::setViewer("json");

		$this->json["item"] = InquirersService::i()->getForm(Request::getInt("fid"));

		return true;
	}

	public function publicateForm()
	{
		parent::setViewer("json");

		InquirersService::i()->publicateForm(Request::getInt("fid"), Request::getInt("is_public"));

		return true;
	}

	public function deleteForm()
	{
		parent::setViewer("json");

		InquirersService::i()->deleteForm(Request::getInt("fid"));

		return true;
	}

	// BLOCKS
	public function getBlocks()
	{
		parent::setViewer("json");

		$this->json["list"] = InquirersService::i()->getBlocks(Request::getInt("fid"));

		return true;
	}

	public function getBlock()
	{
		parent::setViewer("json");

		$this->json["item"] = InquirersService::i()->getBlock(Request::getInt("bid"));

		return true;
	}

	public function saveBlock()
	{
		parent::setViewer("json");

		$__bid = InquirersService::i()->saveBlock(Request::getInt("id", 0), Request::getInt("fid"), Request::getString("title"));

		$this->json["item"] = InquirersService::i()->getBlock($__bid);

		return true;
	}

	public function deleteBlock()
	{
		parent::setViewer("json");

		InquirersService::i()->deleteBlock(Request::getInt("bid"));

		return true;
	}

	public function publicateBlock()
	{
		parent::setViewer("json");

		InquirersService::i()->publicateBlock(Request::getInt("bid"), Request::getInt("is_public"));

		return true;
	}

	// QUESTIONS
	public function getQuestions()
	{
		parent::setViewer("json");

		$this->json["list"] = InquirersService::i()->getQuestions(Request::getInt("bid"));

		return true;
	}

	public function saveQuestion()
	{
		parent::setViewer("json");

		$__data = [
			"id" => Request::getInt("qid", 0),
			"bid" => Request::getInt("bid"),
			"title" => Request::getString("title"),
			"type" => Request::getInt("type", 0),
			"num" => Request::getInt("num", 0)
		];

		$__qid = InquirersService::i()->saveQuestion($__data);

		$this->json["item"] = InquirersService::i()->getQuestion($__qid);

		return true;
	}

	public function getQuestion()
	{
		parent::setViewer("json");

		$this->json["item"] = InquirersService::i()->getQuestion(Request::getInt("qid"));

		return true;
	}

	public function publicateQuestion()
	{
		parent::setViewer("json");

		InquirersService::i()->publicateQuestion(Request::getInt("qid"), Request::getInt("is_public"));

		return true;
	}

	public function deleteQuestion()
	{
		parent::setViewer("json");

		InquirersService::i()->deleteQuestion(Request::getInt("qid"));

		return true;
	}

	// ANSWERS
	public function getAnswers()
	{
		parent::setViewer("json");

		$this->json["list"] = InquirersService::i()->getAnswers(Request::getInt("qid"));

		return true;
	}

	public function getAnswer()
	{
		parent::setViewer("json");

		$this->json["item"] = InquirersService::i()->getAnswer(Request::getInt("aid"));

		return true;
	}

	public function saveAnswer()
	{
		parent::setViewer("json");

		$__qid = InquirersService::i()->saveAnswer(Request::getInt("aid", 0), Request::getInt("qid"), Request::getString("title"));

		$this->json["item"] = InquirersService::i()->getAnswer($__qid);

		return true;
	}

	public function isProblemAnswer()
	{
		parent::setViewer("json");

		InquirersService::i()->isProblemAnswer(Request::getInt("aid"), Request::getInt("is_problem"));

		return true;
	}

	public function publicateAnswer()
	{
		parent::setViewer("json");

		InquirersService::i()->publicateAnswer(Request::getInt("aid"), Request::getInt("is_public"));

		return true;
	}

	public function deleteAnswer()
	{
		parent::setViewer("json");

		InquirersService::i()->deleteAnswer(Request::getInt("aid"));

		return true;
	}
}
