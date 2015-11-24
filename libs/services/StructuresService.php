<?php

namespace libs\services;

\Loader::loadModel("structures.StructuresModel");
\Loader::loadModel("structures.DocumentsModel");
\Loader::loadModel("structures.MembersModel");
\Loader::loadModel("structures.VerificationsModel");

\Loader::loadModel("register.documents.DocumentsModel");
\Loader::loadModel("register.documents.ImagesModel");

\Loader::loadModel("UsersModel");
\Loader::loadClass("GeoClass");
\Loader::loadClass("UserClass");

use libs\models\structures\MembersModel;
use libs\models\structures\StructuresModel;
use libs\models\structures\DocumentsModel;
use libs\models\structures\VerificationsModel;
use libs\models\register\documents\ImagesModel;

class StructuresService extends \Keeper
{
	const DOCUMENT_CATEGORY = 3;

	const LEVEL_REGION = 1;
	const LEVEL_CITY_WITH_DISTRICTS = 2;
	const LEVEL_DISTRICT = 3;
	const LEVEL_CITY_DISTRICT = 4;
	const LEVEL_CITY_WITHOUTH_DISTRICTS = 5;
	const LEVEL_PRIMARY = 6;

	protected static $levels = [
		self::LEVEL_REGION => [
			"long" => "Обласна партійна огранізація",
			"short" => "Обласна",
			"type" => "region"
		],
		self::LEVEL_CITY_WITH_DISTRICTS => [
			"long" => "Міська партійна огранізація з поділом на райони",
			"short" => "Міська обласного значення",
			"type" => "city"
		],
		self::LEVEL_DISTRICT => [
			"long" => "Районна партійна огранізація",
			"short" => "Районна",
			"type" => "district"
		],
		self::LEVEL_CITY_DISTRICT => [
			"long" => "Районна в місті партійна огранізація",
			"short" => "Районна в місті",
			"type" => "city_district"
		],
		self::LEVEL_CITY_WITHOUTH_DISTRICTS => [
			"long" => "Міська партійна огранізація без поділу на райони",
			"short" => "Міська",
			"type" => "city"
		],
		self::LEVEL_PRIMARY => [
			"long" => "Первинна партійна огранізація",
			"short" => "Первинна"
		]
	];

	protected static $rules = [
		self::LEVEL_PRIMARY => [
			[
				"type" => "members",
				"level" => "creators",
				"status" => ["99", "100"],
				"count" => 3
			]
		],
		self::LEVEL_CITY_WITHOUTH_DISTRICTS => [
			[
				"type" => "members",
				"level" => "creators",
				"status" => ["100"],
				"count" => 3
			],
			[
				"type" => "structures",
				"level" => self::LEVEL_PRIMARY,
				"count" => 3
			]
		],
		self::LEVEL_CITY_DISTRICT => [
			[
				"type" => "members",
				"level" => "creators",
				"status" => ["100"],
				"count" => 3
			],
			[
				"type" => "structures",
				"level" => self::LEVEL_PRIMARY,
				"count" => 3
			]
		],
		self::LEVEL_DISTRICT => [
			[
				"type" => "members",
				"level" => "creators",
				"status" => ["100"],
				"count" => 3
			],
			[
				"type" => "structures",
				"level" => self::LEVEL_CITY_WITHOUTH_DISTRICTS,
				"count" => 3
			]
		],
		self::LEVEL_CITY_WITH_DISTRICTS => [
			[
				"type" => "members",
				"level" => "creators",
				"status" => ["100"],
				"count" => 6
			],
			"OR" => [
				[
					"type" => "structures",
					"level" => self::LEVEL_CITY_DISTRICT,
					"count" => 3
				],
				"AND" => [
					[
						"type" => "structures",
						"level" => self::LEVEL_CITY_DISTRICT,
						"count" => 2
					],
					[
						"type" => "members",
						"level" => "free",
						"status" => ["100"],
						"count" => 3
					]
				]
			]
		],
		self::LEVEL_REGION => [
			[
				"type" => "members",
				"level" => "creators",
				"status" => ["100"],
				"count" => 9
			],
			[
				"type" => "structures",
				"level" => [self::LEVEL_DISTRICT, self::LEVEL_CITY_WITH_DISTRICTS, [
					"level" => self::LEVEL_CITY_WITHOUTH_DISTRICTS,
					"option" => "not_in_area"
				]],
				"count" => 2
			]
		]
	];

	private function __getStructureByGeo($geo)
	{
		return StructuresModel::i()->getItemByField("geo", $geo);
	}

	private function __addMembers($sid, $members, $head, $coordinator)
	{
		if( ! is_array($members))
			$members = [$members];

		foreach($members as $__member)
			MembersModel::i()->insert([
				"sid" => $sid,
				"uid" => $__member,
				"is_head" => $__member == $head ? 1 : 0,
				"is_coordinator" => $__member == $coordinator ? 1 : 0
			]);
	}

	private function __addDocuments($sid, $documents)
	{
		$__did = \libs\models\register\documents\DocumentsModel::i()->insert(["cid" => self::DOCUMENT_CATEGORY]);

		foreach ($documents as $__hash)
			ImagesModel::i()->insert([
				"did" => $__did,
				"hash" => $__hash
			]);

		DocumentsModel::i()->insert(["sid" => $sid, "did" => $__did]);
	}

	private function __getDocuments($sid)
	{
		$__documents = [];
		foreach (\Model::getRows("SELECT `did` FROM `structures_documents` WHERE `sid` = :sid", ["sid" => $sid]) as $__did)
			foreach(ImagesModel::i()->getCompiledList(["did = :did"], ["did" => $__did["did"]]) as $__document)
				$__documents[] = $__document;

		return $__documents;
	}

	private function __getMembers($sid)
	{
		$__members = [];
		foreach (MembersModel::i()->getCompiledListByField("sid", $sid) as $__member)
			$__members[] = array_merge(\UsersModel::i()->getItem($__member["uid"]), $__member);

		return $__members;
	}

	private function __getStructeruHead($sid)
	{
		$__bind["sid"] = $sid;

		return \UsersModel::i()->getItem(MembersModel::i()->getRow("SELECT `uid` FROM `structures_members` WHERE sid = :sid AND is_head = 1", $__bind)["uid"]);
	}

	private function __getStructeruCoordinator($sid)
	{
		$__bind["sid"] = $sid;

		return \UsersModel::i()->getItem(MembersModel::i()->getRow("SELECT `uid` FROM `structures_members` WHERE sid = :sid AND is_coordinator = 1", $__bind)["uid"]);
	}

	private function __getRules($type)
	{
		return self::$rules[$type];
	}

	private function __checkRule($structure, $rules, $logic = "AND")
	{

		$__results = [];

		if(isset($rules["type"])){
			$__newRules = $rules;
			$rules = [];
			$rules[$__newRules["type"]] = $__newRules;
		}

		foreach ($rules as $__key => $__rule)
		{

			if(
				is_string($__key)
				&& in_array($__key, ["AND", "OR"])
			)
				$__results[] = $this->__checkRule($structure, $__rule, $__key);
			else
				switch ($__rule["type"]) {
					case "structures":
						if(is_array($__rule["level"]))
						{
							$__levelCond = [];

							foreach ($__rule["level"] as $__level)
								if ( ! is_array($__level))
									$__levelCond[] = "level = " . $__level;
								else
									$__levelCond[] = ["level = " . $__level["level"], $__level["option"] . " = 1"];
						}
						else
							$__levelCond = "level = " . $__rule["level"];

						if(is_array($__levelCond))
							$__levelCond = [
								"OR" => $__levelCond
							];

						$__code = rtrim($structure["geo"], '0');
						$__cond = ["geo REGEXP :regexp", $__levelCond, "status = 1"];
						$__bind["regexp"] = $__code . "[0-9]{" . (10 - strlen($__code)) . "}";

						if(count(StructuresModel::i()->getList($__cond, $__bind)) < $__rule["count"])
							$__results[] = [
								"type" => "error",
								"message" => t("На території дії осередку недостатньо підлеглих осередків")
							];
						else
							$__results[] = ["type" => "success"];

						break;
					case "members":
						if($__rule["level"] == "free")
						{
							$__code = rtrim($structure["geo"], '0');
							$__cond = ["geo_koatuu_code REGEXP :regexp", "type IN (".implode(", ", $__rule["status"]).")"];
							$__bind["regexp"] = $__code . "[0-9]{" . (10 - strlen($__code)) . "}";

							if(count(\UsersModel::i()->getList($__cond, $__bind)) < $__rule["count"])
								$__results[] = [
									"type" => "error",
									"message" => t("На території дії осередку недостатньо членів")
								];
							else
								$__results[] = ["type" => "success"];
						}
						else
						{
							$__col = 0;

							foreach ($structure["members"] as $__member)
								if(in_array($__member["type"], $__rule["status"]))
									$__col++;

							if(count($__rule["status"]) == 2)
								$__message = t("Недостатньо членів партії або кандидатів в члени партії");
							else
								$__message = t("Недостатньо членів партії");

							if($__col < $__rule["count"])
								$__results[] = [
									"type" => "error",
									"message" => $__message,
									"count" => $__col
								];
							else
								$__results[] = ["type" => "success"];
						}
						break;
				}

		}

		$__response = [];
		if($logic == "AND")
		{
			$__response["type"] = "success";
			$__response["message"] = [];
			foreach ($__results as $__result)
				if($__result["type"] == "error")
				{
					$__response["type"] = "error";
					if(is_array($__result["message"]))
						$__response["message"] = array_merge($__response["message"], $__result["message"]);
					else
						$__response["message"][] = $__result["message"];

					if(isset($__result["count"]))
						$__response["count"] = $__result["count"];
				}
		}
		elseif($logic == "OR")
		{
			$__response["type"] = "error";
			$__response["message"] = [];
			foreach ($__results as $__result)
				if ($__result["type"] == "success")
					$__response["type"] = "success";
				else
					if (is_array($__result["message"]))
						$__response["message"] = array_merge($__response["message"], $__result["message"]);
					else
						$__response["message"][] = $__result["message"];
		}

		$__response["message"] = array_unique($__response["message"]);

		return $__response;
	}

	private function __checkStructure($structure)
	{
		$__rules = $this->__getRules($structure["level"]);

		return $this->__checkRule($structure, $__rules);
	}

	/**
	 * @return StructuresService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function isInStructure($uid)
	{
		return (bool) MembersModel::i()->getItemByField("uid", $uid);
	}

	public function getLevels()
	{
		return self::$levels;
	}

	public function getLevel($level)
	{
		return self::$levels[$level];
	}

	public function addStructure($geo, $type, $options = [])
	{
		StructuresModel::i()->insert(array_merge(["geo" => $geo, "level" => $type], $options));
	}

	public function getStructures($__cond = [], $__bind = [])
	{
		return StructuresModel::i()->getList(array_merge($__cond, ["status <> 0"]), $__bind);
	}

	public function getStructure($id, $fullInfo = false)
	{
		$__structure = StructuresModel::i()->getItem($id);
		$__level = self::$levels[$__structure["level"]];

		$__location = \GeoClass::i()->location($__structure["geo"]);

		if( ! isset($__level["type"]))
		{
			$__locationTitle = explode("/", $__location["location"]);
			$__locationTitle = $__locationTitle[count($__locationTitle) - 1];
		}
		else
			$__locationTitle = $__location[$__level["type"]]["title"];

		$__structure["title"] = $__level["long"] . " " . t("у") . " " . $__locationTitle;

		$__structure["verification"] = $this->getLastVerification($id);

		if($fullInfo)
		{
			$__structure["documents"] = $this->__getDocuments($id);
			$__structure["members"] = $this->__getMembers($id);
			$__structure["locality"] = $__location["location"];
			$__structure["level"] = $__level["long"];
			$__structure["mcount"] = count($__structure["members"]);
		}
		else
			$__structure["mcount"] = count(MembersModel::i()->getListByField("sid", $id));

		return $__structure;
	}

	public function getStructureByGeo($geo)
	{
		return $this->__getStructureByGeo($geo);
	}

	public function getStructureHead($sid)
	{
		return $this->__getStructeruHead($sid);
	}

	public function getStructureCoordinator($sid)
	{
		return $this->__getStructeruCoordinator($sid);
	}

	public function setVerification($sid, $uvid, $type, $comment)
	{
		$__data = [
			"sid" => $sid,
			"uvid" => $uvid,
			"type" => $type,
			"comment" => $comment
		];

		VerificationsModel::i()->insert($__data);
	}

	public function getStructureLevel($geo)
	{
		$__structure = StructuresModel::getRow("SELECT * FROM `structures` WHERE `geo` LIKE '".$geo."' AND level < 6");

		return $__structure["level"] ? array_merge(self::$levels[$__structure["level"]], ["level" => $__structure["level"]]) : array_merge(self::$levels[self::LEVEL_PRIMARY], ["level" => self::LEVEL_PRIMARY]);
	}

	public function getLastVerification($id)
	{
		$__cond = array("sid = :sid");
		$__bind = array(
			"sid" => $id
		);
		$__order = array("created_at DESC");

		$__verification = null;
		foreach(VerificationsModel::i()->getList($__cond, $__bind, $__order, 1) as $__id)
			$__verification = VerificationsModel::i()->getItem($__id);

		if( ! is_null($__verification))
			$__verification["user_verifier"] = \UsersModel::i()->getItem($__verification["uvid"], array(
				"id",
				"avatar",
				"first_name",
				"last_name",
				"middle_name"
			));

		return $__verification;
	}

	public function save($data)
	{
		$__structure = StructuresModel::getRow("SELECT * FROM `structures` WHERE `geo` LIKE '".$data["geo"]."' AND level < 6");

		if( ! is_array($__structure))
			$__sid = StructuresModel::i()->insert([
				"geo" => $data["geo"],
				"address" => $data["address"],
				"level" => $data["level"],
				"status" => 1
			]);
		else
		{
			$__sid = $__structure["id"];
			StructuresModel::i()->update([
				"id" => $__sid,
				"address" => $data["address"],
				"status" => 1
			]);
		}

		if(is_array($data["members"]))
			$this->__addMembers($__sid, $data["members"], $data["head"], $data["coordinator"]);

		if(is_array($data["images"]))
			$this->__addDocuments($__sid, $data["images"]);

		return $this->getStructure($__sid);
	}

	public function checkStructure($data)
	{
		$__structure = $this->__getStructureByGeo($data["geo"]);
		$__structure["level"] = $data["level"];

		if(
			$__structure["level"] < self::LEVEL_PRIMARY
			&& $__structure["status"] == 1
		)
			return [
				"type" => "error",
				"sid" => $__structure["id"],
				"messages" => [
					t("Така партійна організація вже існує")
				]
			];

		$__members = [];
		foreach ($data["members"] as $__uid)
			$__members[] = \UsersModel::i()->getItem($__uid);

		$__structure["members"] = $__members;

		return $this->__checkStructure($__structure);
	}

	public function addMember($sid, $uid, $isHead = false, $isCoordinator = false)
	{
		$this->__addMembers($sid, $uid, $isHead, $isCoordinator);
	}
}