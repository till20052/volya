<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class RegisterUsersModel extends ExtendedModel
{
	private $__credentialLevels = [
		0 => [
			"title" => "&mdash;"
		],
		1 => [
			"title" => "Член секретаріату"
		],
		775 => [
			"title" => "Член ЦКРК"
		],
		776 => [
			"title" => "Керівник ЦКРК"
		],
		777 => [
			"title" => "Член ради партії"
		]
	];

	protected $table = "register_users";
	protected $_specificFields = [
		"date" => ["created_at", "modified_at:force"],
		"serialized" => ["geo_koatuu_code"]
	];

	/**
	 * @param string $instance
	 * @return RegisterUsersModel
	 */
	public static function i($instance = "RegisterUsersModel")
	{
		return parent::i($instance);
	}

	public function getCredentialLevels()
	{
		return $this->__credentialLevels;
	}

	public function getCredentialLevelTitleById($credentialLevelId)
	{
		foreach($this->__credentialLevels as $__credentialLevelId => $__credentialLevel)
		{
			if($__credentialLevelId != $credentialLevelId)
				continue;

			return t($__credentialLevel["title"]);
		}

		return t("Невизначено");
	}

	public function getItemByUserId($userId)
	{
		return parent::getItemByField("user_id", $userId);
	}
} 