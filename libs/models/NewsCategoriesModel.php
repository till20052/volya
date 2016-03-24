<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class NewsCategoriesModel extends ExtendedModel
{
	protected $table = "news_categories";
	protected $_specificFields = array(
			"date" => array("created_at","modified_at:force"),
			"serialized" => array("name")
	);
	
	/**
	 * @param string $peer
	 * @return NewsCategoriesModel
	 */
	public static function i($peer = "NewsCategoriesModel")
	{
		return parent::i($peer);
	}
	
	public function getItemBySymlink($symlink, $options = [])
	{
		return parent::getItemByField("symlink", $symlink, $options);
	}
	
	public function getDefaultCategory()
	{
		return $this->getDefault();
	}
	
	public function getDefault()
	{
		$__item = false;
		
		$__cond = array(
			"is_public = :is_public",
			"is_default = :is_default"
		);
		$__bind = array(
			"is_public" => true,
			"is_default" => 1
		);
		
		$__list = parent::getCompiledList($__cond, $__bind, array(), 1);
		if(count($__list) > 0)
			$__item = $__list[0];
		
		return $__item;
	}
	
	public function setDefaultCategory($__id)
	{
		$__old		=	parent::getItemByField("is_default", "1");
		
		$__data		=	array("is_default" => "0");
		$__where	=	array("is_default = 1");
		parent::update($__data, $__where);
		
		$__data		=	array("is_default" => "1");
		
		if( parent::update(array_merge(array("id" => $__id), $__data)) > 0 )
			return true;
		else
			return false;
	}
}
