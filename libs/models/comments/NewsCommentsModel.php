<?php

Loader::loadModel("CommentsModel");

class NewsCommentsModel extends CommentsModel
{
	protected $_type = "news";
	protected $_dateFormat = "Y-m-d H:i:s";
	
	public static function i($instance = "NewsCommentsModel")
	{
		return parent::i($instance);
	}
	
	public function getTree($contentId)
	{
		return parent::_getTree($contentId);
	}
	
}
