<?php

Loader::loadModule("Admin");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadModel("CellsModel");
Loader::loadModel("CellsDocumentsModel");
Loader::loadModel("CellsMembersModel");
Loader::loadModel("CellsVerifiedModel");
Loader::loadModel("roep.RoepPlotsModel");
Loader::loadModel("UsersModel");

class CellsAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Єдиний реєстр осередків та організацій";
	public static $modAHref = "/admin/cells";
	public static $modImgSrc = "cells";
	
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadCKEditor(true);
		parent::loadWindow("admin/cells/viewer");
		parent::loadWindow("admin/cells/confirm");
		parent::loadWindow("admin/cells/viewer/scans/scans_viewer");

		HeadClass::addJs(array(
			"/js/form.js",
			"/js/frontend/admin/cells.js"
		));
		
		HeadClass::addLess(array(
			"/less/frontend/admin/cells/viewer/index.less"
		));
		
		$__list = array();
		
		foreach (CellsModel::i()->getCompiledList(array(), array(), array("created_at DESC")) as $__item)
		{
			$roep = RoepPlotsModel::i()->getItem($__item["roep_plot_id"]);
			$__list[] = array_merge($__item, array("roep_plot_number" => $roep["number"]));
		}
		
		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->list = $__pager->getList();
		$this->pager = $__pager;
	}
	
	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = CellsModel::i()->getItem($__id))
		){
			return false;
		}
		
		$roep = RoepPlotsModel::i()->getItem($__item["roep_plot_id"]);
		$this->json["item"] = array_merge($__item, array("roep_plot_number" => $roep["number"]));
		
		$this->json["users"] = array();
		
		$__cond = array("cell_id = :cell_id");
		$__bind = array("cell_id" => $__id);
		
		$users = CellsMembersModel::i()->getCompiledList($__cond, $__bind);
		
		foreach ($users as $user)
			$this->json["users"][] = UserClass::i()->getNameByItem (UsersModel::i()->getItem($user["user_id"]));
			
		$this->json["scans"] = CellsDocumentsModel::i()->getCompiledList($__cond, $__bind);
		
		$this->json["verification"] = CellsVerifiedModel::i()->getItemByField("cell_id", $__id);
		
		$__user_verified = UsersModel::i()->getItem($this->json["verification"]["user_verifier_id"]);
		$this->json["verification"]["user_verifier"] = $__user_verified["name"];
		
		return true;
	}
	
	public function jVerify()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		$__data = array(
			"cell_id" => Request::getInt("id"),
			"user_verifier_id" => UserClass::i()->getId()
		);
		
		CellsVerifiedModel::i()->insert($__data);
		
		$this->json["verification"] = CellsVerifiedModel::i()->getItemByField("cell_id", Request::getInt("id"));
		
		$__user_verified = UsersModel::i()->getItem($this->json["verification"]["user_verifier_id"]);
		$this->json["verification"]["user_verified"] = $__user_verified["name"];
	}
	
	public function jDelete()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = CellsModel::i()->getItem($__id))
		){
			return false;
		}
		
		CellsModel::i()->deleteItem($__id);
		
		return true;
	}
}
