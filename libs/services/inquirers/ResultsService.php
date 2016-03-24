<?php

namespace libs\services\inquirers;

\Loader::loadModel("inquirers.ResultsModel");
\Loader::loadModel("inquirers.ResultsAnswersModel");

\Loader::loadService("SupportersService");
\Loader::loadService("supporters.ProfileService");

\Loader::loadClass("GeoClass");

use \libs\models\inquirers\ResultsModel;
use \libs\models\inquirers\ResultsAnswersModel;
use libs\models\supporters\ProfileModel;
use libs\services\supporters\ProfileService;
use libs\services\SupportersService;

class ResultsService extends \Keeper
{

	/**
	 * @return ResultsService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getItem($rid)
	{
		return ResultsModel::i()->getItem($rid);
	}

	public function getResultsBySupporterId($sid)
	{
		$__result = ResultsModel::i()->getItemByField("sid", $sid);
		
		return array_merge(
			$__result,
			[
				"results" => ResultsAnswersModel::i()->getCompiledListByField("rid", $__result["id"])
			]
		);
	}

	public function getSupportersByAnswers($answers)
	{
		$__list = [];

		foreach ($answers as $answer)
			foreach (ResultsAnswersModel::i()->getCompiledListByField("aid", $answer) as $result)
				$__list[] = SupportersService::i()->getSupporter( ResultsModel::i()->getItem($result["rid"])["sid"] );

		return $__list;
	}

	public function getSupportersByQuestion($question)
	{
		$__list = [];

		foreach(\Model::getCols("SELECT rid FROM inquirers_results_answers WHERE qid = " . $question . " GROUP BY rid") as $__result){
			$__result = ResultsModel::i()->getItem($__result);

			$__list[] = SupportersService::i()->getSupporter( $__result["sid"] );
		}

		return $__list;
	}

	public function getSupportersByBlock($block)
	{
		$__list = [];

		foreach(\Model::getCols("SELECT rid FROM inquirers_results_answers WHERE bid = " . $block . " GROUP BY rid") as $__result){
			$__result = ResultsModel::i()->getItem($__result);

			$__list[] = SupportersService::i()->getSupporter( $__result["sid"] );
		}

		return $__list;
	}

	public function save($data)
	{
		$data["other_problem"] = $data["fields"]["other_problem"];
		unset($data["fields"]["other_problem"]);

		$sid = SupportersService::i()->save($data["fields"]);

		$rid = ResultsModel::i()->insert([
			"sid" => $sid,
			"fid" => $data["fid"]
		]);

		foreach ($data["answers"] as $answer)
			ResultsAnswersModel::i()->insert([
				"rid" => $rid,
				"bid" => $answer["bid"],
				"qid" => $answer["qid"],
				"aid" => isset($answer["aid"]) ? $answer["aid"] : 0,
				"value" => isset($answer["val"]) ? $answer["val"] : null
			]);

		return $rid;
	}
}