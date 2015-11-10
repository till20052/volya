<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class ElectionCandidatesModel extends ExtendedModel
{
	protected $table = "election_candidates";
	protected $_specificFields = [
		"date" => ["created_at", "modified_at:force"]
	];
	/**
	 * 
	 * @param string $instance
	 * @return ElectionCandidatesModel
	 */
	public static function i($instance = "ElectionCandidatesModel")
	{
		return parent::i($instance);
	}
}
