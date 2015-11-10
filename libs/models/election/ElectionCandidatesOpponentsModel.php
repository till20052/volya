<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class ElectionCandidatesOpponentsModel extends ExtendedModel
{
	protected $table = "election_candidates_opponents";
	protected $_specificFields = [
		"date" => ["created_at", "modified_at:force"]
	];
	/**
	 * @param string $instance
	 * @return ElectionCandidatesOpponentsModel
	 */
	public static function i($instance = "ElectionCandidatesOpponentsModel")
	{
		return parent::i($instance);
	}
}
