<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class MailerRecipientsModel extends ExtendedModel
{
	protected $table = "mailer_recipients";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	/**
	 * @param string $instance
	 * @return MailerRecipientsModel
	 */
	public static function i($instance = "MailerRecipientsModel")
	{
		return parent::i($instance);
	}
}
