<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class ConversationsMessagesModel extends ExtendedModel
{
	protected $table = "conversations_messages";
	protected $_specificFields = array(
		"date" => array("created_at")
	);
	protected $_dateFormat = "Y-m-d H:i:s";
	/**
	 * @param string $instance
	 * @return ConversationsMessagesModel
	 */
	public static function i($instance = "ConversationsMessagesModel")
	{
		return parent::i($instance);
	}
}
