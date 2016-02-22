<?php

namespace libs\services\supporters;

\Loader::loadClass("GeoClass");

\Loader::loadModel("supporters.DataModel");
\Loader::loadModel("supporters.FieldsModel");

use \libs\models\supporters\DataModel;
use \libs\models\supporters\FieldsModel;

class DataService extends \Keeper
{

	/**
	 * @return DataService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getDataBySupporterId($sid)
	{
		$__list["name"] = [
			"value" => "",
			"field_title" => ""
		];
		foreach (DataModel::i()->getCompiledListByField("sid", $sid) as $__item)
		{
			$__filed = FieldsModel::i()->getItem($__item["fid"]);

			switch($__filed["key"]) {
				case "lname":
					$__list["name"] = [
						"value" => $__item["value"] . " " . $__list["name"]["value"],
						"field_title" => $__filed["title"] . " " . $__list["name"]["field_title"]
					];

					break;

				case "fname":
					$__list["name"] = [
						"value" => $__list["name"]["value"] . $__item["value"],
						"field_title" => $__list["name"]["field_title"] . $__filed["title"]
					];

					break;

				default:
					$__list[$__filed["key"]] = [
						"value" => $__item["value"],
						"field_title" => $__filed["title"]
					];

					break;
			}
		}

		return $__list;
	}

	public function save($data)
	{
		if( ! isset($data["id"]))
			return DataModel::i()->insert($data);
		else
			DataModel::i()->update($data);

		return $data["id"];
	}
}