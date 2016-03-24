<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class ElectionExitpollsModel extends ExtendedModel
{
	protected $table = "election_exitpolls";
	protected $_specialFields = [
		"date" => ["created_at", "modified_at:force"]
	];
	/**
	 * @param string $instance
	 * @return ElectionExitpollsModel
	 */
	public static function i($instance = "ElectionExitpollsModel")
	{
		return parent::i($instance);
	}
}
