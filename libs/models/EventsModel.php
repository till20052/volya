<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class EventsModel extends ExtendedModel
{
	protected $table = "events";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force", "happen_at"),
		"serialized" => array("title", "description")
	);
	/**
	 * @param string $instance
	 * @return EventsModel
	 */
	public static function i($instance = "EventsModel")
	{
		return parent::i($instance);
	}
	
	public function getListByCellId($cellId, $options = array())
	{
		return $this->getListByField("cell_id", $cellId, $options);
	}
	
	public function getCompiledListByCellId($cellId, $options = array()) {
		return parent::getCompiledListByField("cell_id", $cellId, $options);
	}
}
