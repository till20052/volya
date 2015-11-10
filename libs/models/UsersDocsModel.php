<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class UsersDocsModel extends ExtendedModel
{
	private $__types = array(
		"PassportPage1" => 0,
		"PassportPage2" => 1,
		"PassportPage11" => 2,
		"Tin" => 3,
		"ApplicationForMembership" => 4,
		"LustrationDeclaration" => 5,
	);

	protected $table = "users_docs";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);

	/**
	 * 
	 * @param string $instance
	 * @return UsersDocsModel
	 */
	public static function i($instance = "UsersDocsModel")
	{
		return parent::i($instance);
	}
	
	public function getTypeIdByKey($key)
	{
		return isset($this->__types[$key]) ? $this->__types[$key] : -1;
	}

	public function getDocsByUserId($userId)
	{
		$__cond = array("user_id = :user_id");
		$__bind = array("user_id" => $userId);
		
		$__list = parent::getCompiledList($__cond, $__bind);
		$__docs = array();
		$__types = array_flip($this->__types);
		
		foreach($__list as $__item)
			$__docs[$__types[$__item["type"]]] = $__item["file"];
		
		return $__docs;
	}
	
	public function insert($data, $ignoreDubplicate = false)
	{
		if(isset($data["type"]))
			$data["type"] = $this->__types[$data["type"]];
		return parent::insert($data, $ignoreDubplicate);
	}
	
	public function update($data, $where = array()) {
		if(isset($data["type"]))
			$data["type"] = $this->__types[$data["type"]];
		return parent::update($data, $where);
	}

	public function deleteDocByType($userId, $type)
	{
		$cond = array("user_id = :user_id", "type = :type");
		$bind = array("user_id" => $userId, "type" => $this->__types[$type]);
		
		$list = parent::getCompiledList($cond, $bind);
		
		parent::deleteItem( $list[0]["id"] );
	}
	
	public function isAllDocs($userId)
	{
		$cond = array("user_id = :user_id");
		$bind = array("user_id" => $userId);
		
		$list = parent::getList($cond, $bind);
		
		return count($list) == count( $this->__types ) ? true : false;
	}
}
