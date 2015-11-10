<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class ElectionCandidatesSupportersModel extends ExtendedModel
{
	protected $table = "election_candidates_supporters";
	/**
	 * @param string $instance
	 * @return ElectionCandidatesSupportersModel
	 */
	public static function i($instance = "ElectionCandidatesSupportersModel")
	{
		return parent::i($instance);
	}
}
