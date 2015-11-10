<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class CellsPollingPlacesModel extends ExtendedModel
{
	protected $table = "cells_polling_places";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	
	/**
	 * @param string $instance
	 * @return CellsPollingPlacesModel
	 */
	public static function i($instance = "CellsPollingPlacesModel")
	{
		return parent::i($instance);
	}
}
