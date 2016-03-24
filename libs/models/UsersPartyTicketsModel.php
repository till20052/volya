<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class UsersPartyTicketsModel extends  ExtendedModel
{
	protected $table = "users_party_tickets";

	/**
	 * @param string $i
	 * @return UsersPartyTicketsModel
	 */
	public static function i($i = "UsersPartyTicketsModel")
	{
		return parent::i($i);
	}
}