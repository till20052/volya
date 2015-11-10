<?php

Loader::loadModule("Admin");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadModel("OrganizationsContactsModel");
Loader::loadModel("OrganizationsContactsValuesModel");

class OrganizationsContactsAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Контакти організацій";
	public static $modAHref = "/admin/organizations_contacts";
	public static $modImgSrc = "organizations_contacts";
	
	public function execute()
	{
		parent::execute();
		parent::setView("organizations_contacts");
		parent::loadKendo(true);
		parent::loadCKEditor(true);
		parent::loadWindow("admin/organizations_contacts/form");
		parent::loadWindow("admin/organizations_contacts/confirm");

		HeadClass::addJs(array(
			"/js/form.js",
			"/js/frontend/admin/organizations_contacts.js"
		));
		
		$__list = OrganizationsContactsModel::i()->getCompiledList(array(), array(), array("created_at DESC"));

		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->list = $__pager->getList();
		$this->pager = $__pager;
	}
	
	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = OrganizationsContactsModel::i()->getItem($__id))
		){
			return false;
		}
		
		$this->json["item"] = $__item;
		
		return true;
	}
	
	public function jSave()
	{
		parent::setViewer("json");
		
		$__id = Request::getInt("id");
		list($fname, $lname) = explode(" ", Request::getString("name"));

		$__data = array(
			"title" => Request::getString("title"),
			"address" => Request::getString("address"),
			"region" => Request::getString("region")
		);

		if($fname && $lname)
			$__data = array_merge(
				$__data,
				[
					"fname" => stripslashes($fname),
					"lname" => stripslashes($lname)
				]
			);

		if(
				! ($__id > 0)
				|| ! (OrganizationsContactsModel::i()->update(array_merge(array("id" => $__id), $__data)))
		){
			$__id = OrganizationsContactsModel::i()->insert($__data);
		}

		$__cond = array(
			"ocid = :ocid"
		);
		$__bind = array(
			"ocid" => $__id
		);

		foreach(OrganizationsContactsValuesModel::i()->getList($__cond, $__bind) as $__contactId)
			OrganizationsContactsValuesModel::i()->deleteItem($__contactId);

		foreach(Request::getArray("contacts") as $__type => $__contact)
		{
			foreach ($__contact as $__value)
				OrganizationsContactsValuesModel::i()->insert(array(
					"ocid" => $__id,
					"type" => $__type,
					"value" => $__value
				));
		}

		$this->json["item"] = OrganizationsContactsModel::i()->getItem($__id);
		
		return true;
	}
	
	public function jDelete()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = OrganizationsContactsModel::i()->getItem($__id))
		){
			return false;
		}

		OrganizationsContactsModel::i()->deleteItem($__id);
		
		return true;
	}
}
