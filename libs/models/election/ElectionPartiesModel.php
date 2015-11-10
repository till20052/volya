<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class ElectionPartiesModel extends ExtendedModel
{
	protected $table = "election_parties";
	protected $_specialFields = [
		"date" => ["created_at", "modified_at:force"]
	];
	/**
	 * @param string $instance
	 * @return ElectionPartiesModel
	 */
	public static function i($instance = "ElectionPartiesModel")
	{
		return parent::i($instance);
	}
}
