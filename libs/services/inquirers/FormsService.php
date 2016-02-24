<?php

namespace libs\services\inquirers;

\Loader::loadModel("inquirers.FormsModel");

use \libs\models\inquirers\FormsModel;

class FormsService extends \Keeper
{

	/**
	 * @return FormsService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getList($cond = [], $bind = [])
	{
		$__list = [];

		foreach(FormsModel::i()->getCompiledList($cond, $bind, ["id DESC"]) as $__item)
			$__list[] = array_merge(
				$__item,
				[
					"title" => \GeoClass::i()->location($__item["geo"])["location"]
				]
			);

		return $__list;
	}

	public function getItem($id, $geo = null)
	{
		if(is_null($geo))
			$__item = FormsModel::i()->getItem($id);
		else
			$__item = FormsModel::i()->getItemByField("geo", $geo);

		if( ! $__item)
			return false;

		return array_merge(
			$__item,
			[
				"title" => \GeoClass::i()->location($__item["geo"])["location"]
			]
		);
	}

	public function publicate($id, $state)
	{
		FormsModel::i()->update([
			"id" => $id,
			"is_public" => $state
		]);
	}

	public function save($id, $geo)
	{
		if( ! $geo > 0)
			return false;

		if(
			! ($id > 0)
			|| ! FormsModel::i()->update([
					"id" => $id,
					"geo" => $geo
				])
		){
			$id = FormsModel::i()->insert([
				"geo" => $geo
			]);
		}

		return $this->getItem($id);
	}

	public function delete($id)
	{
		FormsModel::i()->deleteItem($id);
	}

	public function getListByGeo($geo)
	{
		$__code = rtrim($geo, '0');
		$__cond[] = "geo REGEXP :regexp";
		$__bind["regexp"] = $__code . "[0-9]{" . (10 - strlen($__code)) . "}";

		return $this->getList($__cond, $__bind);
	}
}