<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class AgitationsCategoriesModel extends ExtendedModel
{
	protected $table = "agitations_categories";
	protected $_specificFields = array(
			"date" => array("created_at","modified_at:force"),
			"serialized" => array("name")
	);
	
	/**
	 * @param string $peer
	 * @return NewsCategoriesModel
	 */
	public static function i($peer = "AgitationsCategoriesModel")
	{
		return parent::i($peer);
	}
	
	public function getItemBySymlink($symlink)
	{
		return parent::getItemByField("symlink", $symlink);
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
