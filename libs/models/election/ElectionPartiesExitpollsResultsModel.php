<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class ElectionPartiesExitpollsResultsModel extends ExtendedModel
{
	protected $table = "election_parties_exitpolls_results";
	protected $_specialFields = [
		"date" => ["created_at", "modified_at:force"]
	];
	/**
	 * @param string $instance
	 * @return ElectionPartiesExitpollsResultsModel
	 */
	public static function i($instance = "ElectionPartiesExitpollsResultsModel")
	{
		return parent::i($instance);
	}
}
