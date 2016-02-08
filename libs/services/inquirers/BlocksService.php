<?php

namespace libs\services\inquirers;

\Loader::loadModel("inquirers.BlocksModel");

\Loader::loadClass("GeoClass");

use \libs\models\inquirers\BlocksModel;

class BlocksService extends \Keeper
{

	/**
	 * @return BlocksService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getList($fid)
	{
		return BlocksModel::i()->getCompiledListByField("fid", $fid);
	}

	public function getItem($id)
	{
		return BlocksModel::i()->getItem($id);
	}

	public function save($id, $fid, $title)
	{
		if( ! BlocksModel::i()->update([
			"id" => $id,
			"fid" => $fid,
			"title" => $title
		]))
			return BlocksModel::i()->insert([
				"fid" => $fid,
				"title" => $title
			]);

		return $id;
	}

	public function publicate($id, $value)
	{
		BlocksModel::i()->update([
			"id" => $id,
			"is_public" => $value
		]);
	}

	public function delete($id)
	{
		BlocksModel::i()->deleteItem($id);
	}

	public function getListByFormId($fid)
	{
		return BlocksModel::i()->getCompiledListByField("fid", $fid);
	}
}