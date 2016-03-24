<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class CellsDocumentsModel extends ExtendedModel
{
	private static $__types = array(
		1 => "Тип №1",
		2 => "Тип №2",
		3 => "Тип №3"
	);
	
	protected $table = "cells_documents";
	/**
	 * @param string $instance
	 * @return CellsDocumentsModel
	 */
	public static function i($instance = "CellsDocumentsModel")
	{
		return parent::i($instance);
	}
	
	public static function getTypes()
	{
		$__list = array();
		
		foreach(self::$__types as $__typeId => $__type)
			$__list[$__typeId] = t($__type);
		
		return $__list;
	}
	
	public function getListByCellId($cellId, $options = array())
	{
		$__cond = array("cell_id = :cell_id");
		$__bind = array(
			"cell_id" => $cellId
		);
		$__order = array();
		
		if(isset($options["order"]) && is_array($options["order"]))
			$__order = $options["order"];
		
		return parent::getList($__cond, $__bind, $__order);
	}
	
	public function getCompiledListByCellId($cellId, $options = array())
	{
		$__list = array();
		
		foreach($this->getListByCellId($cellId, $options) as $__id)
			$__list[] = parent::getItem($__id);
		
		return $__list;
	}
}
