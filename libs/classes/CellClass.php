<?php

Loader::loadClass("ExtendedClass", Loader::SYSTEM);
Loader::loadModel("CellsModel");
Loader::loadModel("CellsMembersModel");
Loader::loadModel("CellsDocumentsModel");
Loader::loadModel("roep.RoepPlotsModel");

class CellClass extends ExtendedClass
{
	private $__cell;
	/**
	 * 
	 * @param int $cellId
	 * @return CellClass
	 */
	public static function i($cellId)
	{
		return parent::i("CellClass", array($cellId));
	}
	
	public static function isCreator($userId, $cellId = null)
	{
		$__cond = array("user_creator_id = :user_id");
		$__bind = array("user_id" => $userId);
		
		if( ! is_null($cellId))
		{
			$__cond[] = "id = :cell_id";
			$__bind["cell_id"] = $cellId;
		}
		
		return (bool) (count(parent::getList($__cond, $__bind, array(), 1)) > 0);
	}
	
	public static function isMember($userId, $cellId)
	{
		$__cond[] = array("user_id = :user_id");
		$__bind["user_id"] = $userId;
		
		if( ! is_null($cellId))
		{
			$__cond[] = array("cell_id = :cell_id");
			$__bind["cell_id"] = $cellId;
		}
		
		return (bool) (count(CellsMembersModel::i()->getList($__cond, $__bind, array(), 1)) > 0);
	}
	
	public function __construct($cellId)
	{
		if( ! ($__cell = CellsModel::i()->getItem($cellId)))
			return $__cell;
		
		$this->__cell = $__cell;
	}
	
	public function isExists()
	{
		return isset($this->__cell);
	}
	
	public function getEntity()
	{
		return $this->__cell;
	}
	
	public function getNumber()
	{
		if( ! isset($this->__cell))
			return 0;
		
		return (10000 + $this->__cell["id"]);
	}
	
	public function getLocality($splitBy = " / ")
	{
		if(
				! isset($this->__cell)
				|| strlen($this->__cell["geo_koatuu_code"]) != 10
		)
			return false;
		
		$__tokens = array();
		$__city = OldGeoClass::i()->getCity($this->__cell["geo_koatuu_code"]);
		
		foreach(["region", "area", "title"] as $__field)
		{
			if(isset($__city[$__field]))
				$__tokens[] = $__city[$__field];
		}
		
		return implode($splitBy, $__tokens);
	}
	
	public function getCreator($fields = ["id", "first_name", "last_name", "middle_name"])
	{
		if(
				$this->__cell["user_creator_id"] > 0
				&& ($__item = UsersModel::i()->getItem($this->__cell["user_creator_id"], $fields))
		)
			return $__item;
		
		$__data = array();
		foreach($fields as $__field)
		{
			if($__field == "id")
				$__data[$__field] = 0;
			else
				$__data[$__field] = "";
		}
		
		return $__data;
	}
	
	public function getMembers($fields = ["id", "first_name", "last_name", "middle_name"])
	{
		$__list = array();
		
		if( ! isset($this->__cell))
			return $__list;
		
		$__cond = array("cell_id = :cell_id");
		$__bind = array(
			"cell_id" => $this->__cell["id"]
		);
		
		foreach(CellsMembersModel::i()->getCompiledList($__cond, $__bind) as $__item)
			$__list[] = UsersModel::i()->getItem($__item["user_id"], $fields);
		
		return $__list;
	}
	
	public function getDocuments()
	{
		$__list = array();
		
		if( ! isset($this->__cell))
			return $__list;
		
		$__cond = array("cell_id = :cell_id");
		$__bind = array(
			"cell_id" => $this->__cell["id"]
		);
		
		foreach(CellsDocumentsModel::i()->getList($__cond, $__bind) as $__id)
			$__list[] = CellsDocumentsModel::i()->getItem($__id, ["hash"])["hash"];
		
		return $__list;
	}
	
	public function getRoepPollingPlace()
	{
		if(
				! isset($this->__cell)
				|| ! ($__item = RoepPlotsModel::i()->getItem($this->__cell["roep_plot_id"]))
		)
			return false;
		
		return $__item;
	}
}
