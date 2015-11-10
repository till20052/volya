<?php

Loader::loadModule("Admin");

Loader::loadModel("PMGroupsModel");
Loader::loadModel("PMFilesModel");

class PartyMaterialsAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Партійні матеріали";
	public static $modAHref = "/admin/party_materials";
	public static $modImgSrc = "party_materials";

	private function __getGroups()
	{
		$__list = [];

		foreach(PMGroupsModel::i()->getList() as $__id)
			$__list[] = PMGroupsModel::i()->getItem($__id, ["id", "name"]);

		return $__list;
	}

	private function __getFiles($pmgid = null)
	{
		$__list = [];

		$__cond = [];
		$__bind = [];

		if( ! is_null($pmgid))
		{
			$__cond[] = "pmgid = :pmgid";
			$__bind["pmgid"] = $pmgid;
		}

		foreach(PMFilesModel::i()->getList($__cond, $__bind) as $__id)
		{
			$__item = PMFilesModel::i()->getItem($__id);

			$__list[] = $__item;
		}

		return $__list;
	}

	public function execute()
	{
		parent::execute();
		parent::setView("party_materials");
		parent::loadKendo(true);
		parent::loadFileupload(true);
		parent::loadWindow([
			"admin/party_materials/confirm",
			"admin/party_materials/group_form"
		]);

		HeadClass::addJs([
			"/js/form.js",
			"/js/frontend/admin/party_materials.js"
		]);

		HeadClass::addLess([
			"/less/frontend/admin/party_materials.less"
		]);

		$this->groups = $this->__getGroups();
	}

	public function jGetGroup()
	{
		parent::setViewer("json");

		$__rnd = rand(-999, -1);

		if(($__id = Request::getInt("id", $__rnd)) == $__rnd)
			return false;

		$this->json["item"] = PMGroupsModel::i()->getItem($__id, ["id", "name"]);

		return true;
	}

	public function jGroupSave()
	{
		parent::setViewer("json");

		$__rnd = rand(-999, -1);
		$__data = [];
		$__id = Request::getInt("id");

		if(
			($__name = stripslashes(Request::getString("name", $__rnd))) == strval($__rnd)
			|| empty($__name)
		)
			return false;

		$__data["name"] = $__name;

		if( ! ($__id > 0) || ! PMGroupsModel::i()->update(["id" => $__id] + $__data))
			$__id = PMGroupsModel::i()->insert($__data);

		$this->json["item"] = [
			"id" => $__id,
			"name" => $__name
		];

		return true;
	}

	public function jGroupRemove()
	{
		parent::setViewer("json");

		$__rnd = rand(-999, -1);

		if(($__id = Request::getInt("id", $__rnd)) == $__rnd)
			return false;

		PMGroupsModel::i()->deleteItem($__id);

		return true;
	}

	public function jGetFiles()
	{
		parent::setViewer("json");

		$__rnd = rand(-999, -1);

		if(($__pmgid = Request::getInt("group_id", $__rnd)) == $__rnd)
			return false;

		$this->json["list"] = $this->__getFiles($__pmgid);

		return true;
	}

	public function jFileSave()
	{
		parent::setViewer("json");

		$__rnd = rand(-999, -1);

		$__data = [
			"uid" => UserClass::i()->getId()
		];

		$__id = Request::getInt("id");

		if(($__pmgid = Request::getInt("group_id", $__rnd)) != $__rnd)
			$__data["pmgid"] = $__pmgid;

		if(
			($__hash = stripslashes(Request::getString("hash", $__rnd))) != strval($__rnd)
			&& strlen($__hash) == 32
		)
			$__data["hash"] = $__hash;


		if(($__name = stripslashes(Request::getString("name", $__rnd))) == strval($__rnd))
			return false;

		$__data += [
			"name" => $__name
		];

		if( ! ($__id > 0) || ! PMFilesModel::i()->update(["id" => $__id] + $__data))
			$__id = PMFilesModel::i()->insert($__data);

		$this->json["item"] = PMFilesModel::i()->getItem($__id, ["id", "hash", "name"]);

		return true;
	}

	public function jFileRemove()
	{
		parent::setViewer("json");

		$__rnd = rand(-999, -1);

		if(($__id = Request::getInt("id", $__rnd)) == $__rnd)
			return false;

		PMFilesModel::i()->deleteItem($__id);

		return true;
	}
}