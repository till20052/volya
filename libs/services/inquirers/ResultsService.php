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
				"aid" => $answer["aid"],
				"value" => isset($answer["val"]) ? $answer["val"] : null
			]);

		return $rid;
	}
}