<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class CellsVerifiedModel extends ExtendedModel
{
	protected $table = "cells_verified";
	protected $_specificFields = array(
		"date" => array("created_at:force")
	);
	
	/**
	 * @param string $instance
	 * @return CellsVerifiedModel
	 */
	public static function i($instance = "CellsVerifiedModel")
	{
		return parent::i($instance);
	}
}
