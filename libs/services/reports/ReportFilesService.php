<?php

namespace libs\services\reports;

\Loader::loadModel("reports.ReportFilesModel");

use libs\models\reports\ReportFilesModel;

class ReportFilesService extends \Keeper
{

	/**
	 * @return ReportFilesService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getList($rid)
	{
		return ReportFilesModel::i()->getCompiledListByField("rid", $rid);
	}

//	public function getItem($cid)
//	{
//		return ReportFilesModel::i()->getItem($cid);
//	}

	public function save($hash, $rid)
	{
		return ReportFilesModel::i()->insert([
			"rid" => $rid,
			"hash" => $hash
		]);
	}

	public function delete($rid)
	{
		foreach (ReportFilesModel::i()->getCompiledListByField("rid", $rid) as $report)
			ReportFilesModel::i()->deleteItem($report["id"]);
	}
}