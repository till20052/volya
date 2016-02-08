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

	public function save($data)
	{
		$sid = ProfileService::i()->save([
			"status" => 0,
			"type" => ProfileService::i()->getTypeByKey("inquirers")["id"]
		]);

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