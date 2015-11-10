<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class ConversationsModel extends ExtendedModel
{
	protected $table = "conversations";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);
	/**
	 * @param string $instance
	 * @return ConversationsModel
	 */
	public static function i($instance = "ConversationsModel")
	{
		return parent::i($instance);
	}
}
