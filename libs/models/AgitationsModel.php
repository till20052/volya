<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class AgitationsModel extends ExtendedModel
{
	protected $table = "agitations";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force"),
		"serialized" => array("name", "description", "categories_ids")
	);
	/**
	 * @param string $instance
	 * @return AgitationsModel
	 */
	public static function i($instance = "AgitationsModel")
	{
		return parent::i($instance);
	}
	
	public function getItemByAuthorId($authorId)
	{
		return parent::getItemByField("author_id", $authorId);
	}
	
	public function getListByCategoryId($categoryId, $isPublic = null)
	{
		$__cond = array("category_id = :category_id");
		$__bind = array("category_id" => $categoryId);
		$__list = parent::getList($__cond, $__bind);
		
		$compiledList = array();
		
		foreach ($__list as $__item)
			$compiledList[] = parent::getItem($__item);
		
		return $compiledList;
	}
	
	public static function getItemDescrFromText($item)
	{
		$__text = $item["description"][Router::getLang()];
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
}
