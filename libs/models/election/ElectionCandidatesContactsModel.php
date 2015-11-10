<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class ElectionCandidatesContactsModel extends ExtendedModel
{
	protected $table = "election_candidates_contacts";
	/**
	 * @param string $instance
	 * @return ElectionCandidatesContactsModel
	 */
	public static function i($instance = "ElectionCandidatesContactsModel")
	{
		return parent::i($instance);
	}
}
