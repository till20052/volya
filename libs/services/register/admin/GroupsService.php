<?php

namespace libs\services\register\admin;

use libs\models\register\admin\GroupsModel;
use libs\models\register\admin\GroupsUsersModel;

\Loader::loadModel("register.admin.GroupsModel");
\Loader::loadModel("register.admin.GroupsUsersModel");
\Loader::loadModel("UsersModel");
\Loader::loadClass("GeoClass");

class GroupsService extends \Keeper
{
	protected $types = [
		0 => "Контрольна Ревізійна комісія",
		1 => "Центральна Контрольна Ревізійна комісія",
		2 => "Рада Партій"
	];

	/**
	 * @return GroupsService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getList()
	{
		$__list = [];

		foreach(GroupsModel::i()->getCompiledList([], [], ["id ASC"]) as $__item)
		{
			if($__item["type"] == 0)
				$__item["title"] = $this->types[$__item["type"]]." ".t("у ").\GeoClass::i()->location($__item["geo"])["location"];
			else
				$__item["title"] = $this->types[$__item["type"]];

			$__list[] = $__item;
		}

		return $__list;
	}

	public function getItem($id){
		$__item = GroupsModel::i()->getItem($id);
		$__item["members"] = $this->getMembers($id);

		if($__item["type"] == 0)
			$__item["title"] = $this->types[$__item["type"]]." ".t("у ").\GeoClass::i()->location($__item["geo"])["location"];
		else
			$__item["title"] = $this->types[$__item["type"]];

		return $__item;
	}

	public function getMembers($gid)
	{
		$__list = [];
		$__fields = [
			"id", "first_name", "last_name", "middle_name"
		];
		foreach (GroupsUsersModel::i()->getCompiledList(['gid = :gid'], ['gid' => $gid]) as $__member)
			$__list[] = \UsersModel::i()->getItem($__member["uid"], $__fields);

		return $__list;
	}

	public function removeMembers($groupId)
	{
		foreach(GroupsUsersModel::i()->getList(['gid = :gid'], ['gid' => $groupId]) as $id)
			GroupsUsersModel::i()->deleteItem($id);
	}

	public function getGroupByUid($uid)
	{
		return GroupsModel::i()->getItem(GroupsUsersModel::i()->getItemByField("uid", $uid)["gid"]);
	}

	public function save($data)
	{
		$members = [];
		if(isset($data['members']))
		{
			$members = $data['members'];
			unset($data['members']);
		}

		if(
			! isset($data['id'])
			|| ! GroupsModel::i()->update($data)
		)
			$data['id'] = GroupsModel::i()->insert($data);

		$this->removeMembers($data['id']);

		foreach($members as $uid)
			GroupsUsersModel::i()->insert([
				'gid' => $data['id'],
				'uid' => $uid
			]);

		return $data['id'];
	}

}