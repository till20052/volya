<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class MailerContactsModel extends ExtendedModel
{
	protected $table = "mailer_contacts";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	/**
	 * @param string $instance
	 * @return MailerContactsModel
	 */
	public static function i($instance = "MailerContactsModel")
	{
		return parent::i($instance);
	}
}
