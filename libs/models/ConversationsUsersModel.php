<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);

class ConversationsUsersModel extends ExtendedModel
{
	protected $table = "conversations_users";
	/**
	 * @param string $instance
	 * @return ConversationsUsersModel
	 */
	public static function i($instance = "ConversationsUsersModel")
	{
		return parent::i($instance);
	}
	
	public function getConversationsByUserId($userId)
	{
		$__list = array();
		
		$__sql = "SELECT conversation_id "
				."FROM `".$this->table."` "
				."WHERE user_id = ".intval($userId)." "
				."GROUP BY conversation_id "
				."ORDER BY id DESC";
		
		foreach(parent::getRows($__sql) as $__row)
			$__list[] = $__row["conversation_id"];
		
		return $__list;
	}
	
	public function getConversationIdByUsers($users)
	{
		$__users = array();
		foreach($users as $__userId)
			$__users[] = intval($__userId);
		
		$__sql = "SELECT conversation_id, COUNT(*) AS c "
				."FROM `".$this->table."` "
				."WHERE user_id IN (".implode(", ", $__users).") "
				."GROUP BY 1 "
				."HAVING c = ".count($__users)." "
				."ORDER BY id DESC "
				."LIMIT 1";
		
		return	( ! ($__row = parent::getRow($__sql)) ? $__row : $__row["conversation_id"]);
	}
}
