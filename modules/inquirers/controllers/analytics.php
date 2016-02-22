<?php

Loader::loadModule("Inquirers");

\Loader::loadService("InquirersService");
\Loader::loadService("SupportersService");

use \libs\services\InquirersService;
use \libs\services\SupportersService;

class AnalyticsInquirersController extends InquirersController
{
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::addBreadcrumb("/inquirers/analytics", t("Аналіз результатів"));
		parent::loadWindow("inquirers/analytics/viewer");

		HeadClass::addLess("/less/frontend/inquirers/analytics.less");
		HeadClass::addJs([
			"/js/frontend/inquirers/analytics.js",
			"/js/frontend/inquirers/analytics/charts.js",
			"/jquery/js/jquery.masonry.js",
			"/jquery/js/charts/highcharts.js",
			"/jquery/js/charts/modules/data.js",
			"/jquery/js/charts/modules/drilldown.js",
		]);

		$this->blocks = InquirersService::i()->getBlocksByGeo("0000000000");
		$this->supporters = InquirersService::i()->getSupporters();
	}

	public function getForm()
	{
		parent::setViewer("json");

		$this->json["item"] = InquirersService::i()->getResultsBySupporterId( Request::getInt("id") );

		return true;
	}

	public function getBlocksByGeo()
	{
		parent::setViewer("json");

		$this->json["list"] = InquirersService::i()->getBlocksByGeo(Request::getString("geo"));

		return true;
	}

	public function getQuestionsByBlock()
	{
		parent::setViewer("json");

		$this->json["list"] = InquirersService::i()->getQuestions(Request::getInt("bid"));

		return true;
	}

	public function getAnswersByQuestion()
	{
		parent::setViewer("json");

		$this->json["list"] = InquirersService::i()->getAnswers(Request::getInt("qid"));

		return true;
	}

	public function filter()
	{
		parent::setViewer("json");

		if(count(Request::getArray("answers")) > 0) {

			$this->json["list"] = InquirersService::i()->getSupportersByAnswers(Request::getArray("answers"));
			$this->json["analytics"] = false;

		} elseif(Request::getInt("question")) {

			$this->json["list"] = InquirersService::i()->getSupportersByQuestion(Request::getInt("question"));


		} elseif(Request::getInt("block")) {

			$this->json["list"] = InquirersService::i()->getSupportersByBlock(Request::getInt("block"));
			$this->json["analytics"] = InquirersService::i()->getAnalyticsData([
				"type" => "block",
				"bid" => Request::getInt("block")
			]);

		} elseif(Request::getString("geo")) {
			$this->json["list"] = InquirersService::i()->getSupportersByGeo(Request::getString("geo"));
		} else
			$this->json["list"] = InquirersService::i()->getSupporters();

		return true;
	}
}
