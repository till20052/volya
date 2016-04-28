<?php

namespace libs\services\reports;

\Loader::loadModel("reports.ReportCategoriesModel");

use libs\models\reports\ReportCategoriesModel;

class ReportCategoriesService extends \Keeper
{

	/**
	 * @return ReportCategoriesService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getList()
	{
		return ReportCategoriesModel::i()->getCompiledList();
	}

	public function getItem($cid)
	{
		return ReportCategoriesModel::i()->getItem($cid);
	}

	public function save($title, $cid = 0)
	{
		if(
				! ReportCategoriesModel::i()->update([
					"id" => $cid,
					"title" => $title
				])
		)
			$__category = ReportCategoriesModel::i()->insert([
				"title" => $title
			]);

		return $__category["id"];
	}

	public function delete($cid)
	{
		ReportCategoriesModel::i()->deleteItem($cid);
	}
}