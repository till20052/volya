<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class CommentsModel extends ExtendedModel
{
	protected $table = "comments";
	protected $_specificFields = array(
		"date" => array("created_at", "deleted_at", "modified_at:force"),
		"serialized" => array("__xtnd")
	);
	protected $_type = null;
	
	private function __buildTree($list, $parent = 0)
	{
		$__tree = array();
		
		foreach($list as $__item)
		{
			if($__item["parent_id"] != $parent)
				continue;
			
			$__children = $this->__buildTree($list, $__item["id"]);
			
			if(count($__children) > 0)
				$__item["children"] = $__children;
			
			$__tree[] = $__item;
		}
		
		return $__tree;
	}

	protected function _getTree($contentId)
	{
		$__cond = array("content_id = :content_id", "type = :type");
		$__bind = array("content_id" => $contentId, "type" => $this->_type);
		
		return $this->__buildTree(parent::getCompiledList($__cond, $__bind));
	}
	
	public static function i($instance = "CommentsModel")
	{
		return parent::i($instance);
	}
	
	public function getList($where = array(), $bind = array(), $order = array(), $limit = null)
	{
		if( ! is_null($this->_type))
		{
			$where[] = "type = :type";
			$bind["type"] = $this->_type;
		}
		
		return parent::getList($where, $bind, $order, $limit);
	}
	
	public function getListByContentId($contentId)
	{
		$__cond = array("content_id = :content_id");
		$__bind = array(
			"content_id" => $contentId
		);
		
		return $this->getList($__cond, $__bind);
	}
	
	public function getCompiledList($where = array(), $bind = array(), $order = array(), $limit = null)
	{
		if( ! is_null($this->_type))
		{
			$where[] = "type = :type";
			$bind["type"] = $this->_type;
		}
		
		return parent::getCompiledList($where, $bind, $order, $limit);
	}
	
	public function getCompiledListByContentId($contentId)
	{
		$__cond = array("content_id = :content_id");
		$__bind = array(
			"content_id" => $contentId
		);
		
		return $this->getCompiledList($__cond, $__bind);
	}

	public function buildTree($list)
	{
		return $this->__buildTree($list);
	}
	
	public function insert($data, $ignoreDubplicate = false)
	{
		if( ! is_null($this->_type))
			$data["type"] = $this->_type;
		
		return parent::insert($data, $ignoreDubplicate);
	}
	
	public function update($data, $where = array())
	{
		if( ! is_null($this->_type))
			$data["type"] = $this->_type;
		
		return parent::update($data, $where);
	}
}
