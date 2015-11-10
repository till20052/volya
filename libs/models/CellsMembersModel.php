<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);
Loader::loadModel("UsersModel");

class CellsMembersModel extends ExtendedModel
{
	protected $table = "cells_members";
	protected $_specificFields = array(
		"date" => array("created_at")
	);
	/**
	 * @param string $instance
	 * @return CellsMembersModel
	 */
	public static function i($instance = "CellsMembersModel")
	{
		return parent::i($instance);
	}
	
	public function deleteUser($userId, $cellId)
	{	
		$__cond = array("user_id = :user_id", "cell_id = :cell_id");
		$__bind = array("user_id" => $userId, "cell_id" => $cellId);
		
		$__list = parent::getCompiledList($__cond, $__bind, array(), 1);
		
		parent::deleteItem($__list[0]["id"]);
	}

	public function getUsersByCellId($cellId)
	{
		$__cond = array("cell_id = :cell_id");
		$__bind["cell_id"] = $cellId;
		
		$__list = parent::getCompiledList($__cond, $__bind);
		$__users = array();
		
		foreach ($__list as $__item)
			$__users[] = UsersModel::i()->getItem($__item["user_id"]);
		
		return $__users;
	}
}
