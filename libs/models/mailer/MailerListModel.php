<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class MailerListModel extends ExtendedModel
{
	protected $table = "mailer_list";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force", "sending_date")
	);
	/**
	 * @param string $instance
	 * @return MailerListModel
	 */
	public static function i($instance = "MailerListModel")
	{
		return parent::i($instance);
	}
}
