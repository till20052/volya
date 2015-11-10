<?php

Loader::loadModel("MaterialsModel");

class NewsMaterialsModel extends MaterialsModel
{
	protected $_type = "news";
	protected $_dateFormat = "Y-m-d H:i:s";
	/**
	 * 
	 * @param string $instance
	 * @return NewsMaterialsModel
	 */
	public static function i($instance = "NewsMaterialsModel")
	{
		return parent::i($instance);
	}
	
	public function getListByCellId($cellId, $options = array())
	{
		$__cond = array("cell_id = :cell_id");
		$__bind = array("cell_id" => $cellId);
		$__order = array();
		
		if(isset($options["cond"]) && is_array($options["cond"]))
			$__cond = array_merge($__cond, $options["cond"]);
		
		if(isset($options["bind"]) && is_array($options["bind"]))
			$__bind = array_merge($__bind, $options["bind"]);
		
		if(isset($options["order"]) && is_array($options["order"]))
			$__order = $options["order"];
		
		return parent::getList($__cond, $__bind, $__order);
	}
	
	public function getCompiledListByCellId($cellId, $options = array())
	{
		$__list = array();
		$__fields = array();
		
		if(isset($options["fields"]) && is_array($options["fields"]))
			$__fields = $options["fields"];
		
		foreach($this->getListByCellId($cellId, $options) as $__id)
			$__list[] = $this->getItem($__id, $__fields);
		
		return $__list;
	}
}
