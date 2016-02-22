<?php

namespace libs\services;

\Loader::loadModel("inquirers.AnswersModel");

\Loader::loadModel("UsersModel");
\Loader::loadClass("GeoClass");
\Loader::loadClass("UserClass");

\Loader::loadService("supporters.DataService");
\Loader::loadService("supporters.FieldsService");
\Loader::loadService("supporters.ProfileService");

use libs\services\supporters\DataService;
use libs\services\supporters\FieldsService;
use libs\services\supporters\ProfileService;

class SupportersService extends \Keeper
{

	/**
	 * @return SupportersService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getSupporters($cond = [], $bind = [])
	{
		$__list = [];

		foreach (ProfileService::i()->getList($cond, $bind) as $__profile) {
			$__list[] = array_merge(
				$__profile,
				DataService::i()->getDataBySupporterId($__profile["id"]),
				[
					"type" => ProfileService::i()->getTypeById($__profile["type"])["title"]
				]
			);
		}

		return $__list;
	}

	public function getSupporter($sid)
	{
		$__profile = ProfileService::i()->getItem($sid);

		return array_merge(
			$__profile,
			DataService::i()->getDataBySupporterId($sid),
			[
				"type" => ProfileService::i()->getTypeById($__profile["type"])["title"],
				"geo" => [
					"value" => \GeoClass::i()->location($__profile["geo"])["location"],
					"field_title" => t("Населений пункт")
				]
			]
		);
	}

	public function getSupportersByGeo($geo)
	{
		$__code = rtrim($geo, '0');
		$__cond[] = "geo REGEXP :regexp";
		$__bind["regexp"] = $__code . "[0-9]{" . (10 - strlen($__code)) . "}";

		return $this->getSupporters($__cond, $__bind);
	}

	public function save($data)
	{
		$sid = ProfileService::i()->save([
			"status" => 0,
			"type" => ProfileService::i()->getTypeByKey("inquirers")["id"],
			"geo" => $data["geo"]
		]);
		unset($data["geo"]);

		foreach ($data as $key => $val) {
			$data = [
				"sid" => $sid,
				"fid" => FieldsService::i()->getFieldByKey($key)["id"],
				"value" => $val
			];

			DataService::i()->save( $data );
		}

		return $sid;
	}
}