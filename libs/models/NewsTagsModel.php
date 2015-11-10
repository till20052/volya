<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class NewsTagsModel extends ExtendedModel
{
	protected $table = "news_tags";
	protected $_specificFields = [
		"date" => ["created_at", "modified_at:force"]
	];
	/**
	 * @param string $instance
	 * @return NewsTagsModel
	 */
	public static function i($instance = "NewsTagsModel")
	{
		return parent::i($instance);
	}
}
