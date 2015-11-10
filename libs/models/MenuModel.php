<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class MenuModel extends ExtendedModel
{
	protected $table = "menu";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force"),
		"serialized" => array("name")
	);
	
	private function __buildTree($list, $parent = 0)
	{
		$__tree = array();
		
		foreach($list as $__item)
		{
			if($__item["parent"] != $parent)
				continue;
			
			$__subTree = $this->__buildTree($list, $__item["id"]);
			
			if(count($__subTree) > 0)
				$__item["sub_tree"] = $__subTree;
			
			$__tree[] = $__item;
		}
		
		return $__tree;
	}
	
	/**
	 * @param string $instance
	 * @return MenuModel
	 */
	public static function i($instance = "MenuModel")
	{
		return parent::i($instance);
	}
	
	public function getItem($pkey, $fields = array())
	{
		if( ! ($__item = parent::getItem($pkey, $fields)))
			return $__item;
		
		$__item["name_".Router::getLang()] = $__item["name"][Router::getLang()];
		
		return $__item;
	}
	
	public function buildTree($list, $parent = 0)
	{
		return $this->__buildTree($list, $parent);
	}
	
	public function deleteItem($pkey)
	{
		$__cond = array("parent = :parent");
		$__bind = array("parent" => $pkey);
		
		foreach($this->getList($__cond, $__bind) as $__id)
			$this->deleteItem($__id);
		
		parent::deleteItem($pkey);
	}
}
