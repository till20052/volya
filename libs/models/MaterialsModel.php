<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class MaterialsModel extends ExtendedModel
{
	protected $table = "materials";
	protected $_specificFields = array(
		"serialized" => array("tags_ids", "title", "announcement", "text", "meta_title", "meta_description", "meta_keywords"),
		"date" => array("created_at", "modified_at:force")
	);
	protected $_type = null;
	
	/**
	 * @param string $instance
	 * @return MaterialsModel
	 */
	public static function i($instance = "MaterialsModel")
	{
		return parent::i($instance);
	}
	
	public static function getItemDescrFromText($item)
	{
		$__text = $item["text"][Router::getLang()];
		$__description = "";
		
		$__splitter = "<div style=\"page-break-after: always;\"><span style=\"display:none\">&nbsp;</span></div>";
		$__splitterCount = mb_substr_count($__text, $__splitter, "UTF-8");
		
		if($__splitterCount == 2)
		{
			$__fp = mb_strpos($__text, $__splitter, 0, "UTF-8") + mb_strlen($__splitter, "UTF-8");
			$__lp = mb_strpos($__text, $__splitter, $__fp, "UTF-8") - $__fp;
			$__description = mb_substr($__text, $__fp, $__lp, "UTF-8");
		}
		elseif($__splitterCount == 1)
		{
			$__lp = mb_strpos($__text, $__splitter, 0, "UTF-8");
			$__description = mb_substr($__text, 0, $__lp, "UTF-8");
		}
		
		return strip_tags($__description);
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
	
	public function getCompiledList($where = array(), $bind = array(), $order = array(), $limit = null)
	{
		if( ! is_null($this->_type))
		{
			$where[] = "type = :type";
			$bind["type"] = $this->_type;
		}
		
		return parent::getCompiledList($where, $bind, $order, $limit);
	}
	
	public function getCompiledListByCategoryId($categoryId, $isPublic = null)
	{
		$__list = array();
		
		$__cond = array("category_id = :category_id");
		$__bind = array("category_id" => $categoryId);
		
		if( ! is_null($isPublic))
		{
			$__cond[] = "is_public = :is_public";
			$__bind["is_public"] = $isPublic;
		}
		
		foreach (parent::getList($__cond, $__bind) as $__item)
			$__list[] = parent::getItem($__item);
		
		return $__list;
	}
	
	public function getItemByField($field, $value)
	{
		$__cond = array($field." = :".$field);
		$__bind = array($field => $value);
		
		if( ! is_null($this->_type))
		{
			$__cond[] = "type = :type";
			$__bind["type"] = $this->_type;
		}
		
		$__list = parent::getCompiledList($__cond, $__bind, array(), 1);
		
		return count($__list) > 0 ? $__list[0] : false;
	}
	
	public function getItemBySymlink($symlink)
	{
		return $this->getItemByField("symlink", $symlink);
	}
	
	public function getItemByAuthorId($authorId)
	{
		return $this->getItemByField("author_id", $authorId);
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
