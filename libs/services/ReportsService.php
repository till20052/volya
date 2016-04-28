<?php

namespace libs\services;

use libs\models\reports\ReportsModel;
use libs\services\reports\ReportCategoriesService;
use libs\services\reports\ReportFilesService;

\Loader::loadModel("reports.ReportsModel");

\Loader::loadService("reports.ReportCategoriesService");
\Loader::loadService("reports.ReportFilesService");

class ReportsService extends \Keeper
{

	/**
	 * @return ReportsService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getCategories()
	{
		return ReportCategoriesService::i()->getList();
	}

	public function addDocument($files, $title, $cid)
	{
		$rid = ReportsModel::i()->insert([
			"title" => $title,
			"cid" => $cid
		]);

		foreach ($files as $file)
			ReportFilesService::i()->save($file, $rid);

		return $rid;
	}

	public function getDocuments()
	{
		$__list = [];

		foreach (ReportsModel::i()->getCompiledList() as $__report)
			$__list[] = array_merge(
				$__report,
				[
					"files" => ReportFilesService::i()->getList($__report["id"])
				]
			);

		return $__list;
	}

	public function deleteDocument($id)
	{
		ReportsModel::i()->deleteItem($id);
		ReportFilesService::i()->delete($id);
	}
}