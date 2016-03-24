<?php

namespace libs\models\supporters;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class ProfileModel extends \ExtendedModel
{
	private static $types = [
		"inquirers" => [
			"id" => 1,
			"title" => "Учасники опитування"
		]
	];

	protected $table = "supporters_profile";
	protected $_specificFields = array(
		"date" => array("modified_at:force")
	);

	/**
	 * @param string $instance
	 * @return ProfileModel
	 */
	public static function i()
	{
		return parent::i(get_class());
	}

	public function getTypeByKey($key)
	{
		return self::$types[$key];
	}

	public function getTypeById($id)
	{
		foreach (self::$types as $type)
			if($type["id"] == $id)
				return $type;

		return false;
	}
}