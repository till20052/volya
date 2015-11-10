<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);
Loader::loadModel("CellsUsersModel");

class CellsModel extends ExtendedModel
{
	protected $table = "cells";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force", "started_at")
	);
	/**
	 * @param string $instance
	 * @return CellsModel
	 */
	public static function i($instance = "CellsModel")
	{
		return parent::i($instance);
	}
	
	public function isCreator($userId)
	{
		$__cond = array("user_creator_id = :user_id");
		$__bind = array("user_id" => $userId);
		
		return (bool) (count(parent::getList($__cond, $__bind, array(), 1)) > 0);
	}
	
	public function isMember($userId, $cellId = null)
	{
		$__cond[] = array("user_id = :user_id");
		$__bind["user_id"] = $userId;
		
		if( ! is_null($cellId))
		{
			$__cond[] = array("cell_id = :cell_id");
			$__bind["cell_id"] = $cellId;
		}
		
		return (count(CellsUsersModel::i()->getList($__cond, $__bind, array(), 1)) > 0);
	}
}
