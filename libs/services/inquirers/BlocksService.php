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
		if($fid > 0)
			return BlocksModel::i()->getCompiledListByField("fid", $fid);
		else
			return BlocksModel::i()->getCompiledList();
	}

	public function getItem($id, $title = "")
	{
		if($id > 0)
			return BlocksModel::i()->getItem($id);
		elseif($title != "")
			return BlocksModel::i()->getItemByField("title", $title);

		return false;
	}

	public function save($fid, $bid, $title)
	{
		if( ! ($__block = $this->getItem(0, $title)))
			return BlocksModel::i()->insert([
				"fid" => $fid,
				"title" => $title
			]);

		BlocksModel::i()->update([
			"id" => $bid,
			"title" => $title
		]);

		return $__block["id"];
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