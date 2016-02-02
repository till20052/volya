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

	public function getList()
	{
		$__list = [];

		foreach(FormsModel::i()->getCompiledList([], [], ["id DESC"]) as $__item)
			$__list[] = array_merge(
				$__item,
				[
					"title" => \GeoClass::i()->location($__item["geo"])["location"]
				]
			);

		return $__list;
	}

	public function getItem($id)
	{
		$__item = FormsModel::i()->getItem($id);

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
}