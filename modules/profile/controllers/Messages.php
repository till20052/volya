<?php

Loader::loadModule("Profile");
Loader::loadClass("UserClass");
Loader::loadModel("ConversationsModel");
Loader::loadModel("ConversationsUsersModel");
Loader::loadModel("ConversationsMessagesModel");
Loader::loadModel("UsersFriendsModel");

class MessagesProfileController extends ProfileController
{
	public function execute()
	{
		parent::execute();
		
		if( ! UserClass::i()->isAuthorized())
			parent::redirect("/");
		
		parent::loadKendo(true);
		parent::loadWindow("profile/messages/message_creator");
		
		HeadClass::addJs(array(
			"/js/form.js",
			"/js/frontend/profile/messages.js"
		));
		HeadClass::addCss("/css/frontend/profile/messages.css");
		
		$__list = ConversationsUsersModel::i()->getConversationsByUserId(UserClass::i()->getId());
		
		$__sql = "SELECT id "
				."FROM conversations "
				."WHERE id IN (".implode(",", $__list).") "
				."ORDER BY modified_at DESC";
		
		$__list = DB::getCols($__sql);
		
		$__length = 10;
		$__step = Request::getInt("step") * $__length;
		
		if($__step > 0)
		{
			parent::setLayout(false);
			parent::setView("messages/conversations_rows");
		}
		else
		{
			$this->friends = array();
			foreach(UsersFriendsModel::i()->getFriends(UserClass::i()->getId()) as $__id)
				$this->friends[] = UsersModel::i()->getItem($__id, array("id", "first_name", "middle_name", "last_name", "avatar"));
		}
		
		$this->conversations = array();
		$this->countConversations = count($__list);
		
		foreach(array_splice($__list, $__step, $__length) as $__conversationId)
		{
			$__conversation = ConversationsModel::i()->getItem($__conversationId, array("id", "subject"));
			
			$__cond = array("conversation_id = :conversation_id");
			$__bind = array(
				"conversation_id" => $__conversationId
			);
			
			$__conversation["messages"] = array();
			foreach(ConversationsMessagesModel::i()->getList($__cond, $__bind, array("created_at DESC"), 1) as $__id)
				$__conversation["messages"][] = ConversationsMessagesModel::i()->getItem($__id, array("message", "created_at"));
			
			$__conversation["users"] = array();
			foreach(ConversationsUsersModel::i()->getList($__cond, $__bind) as $__id)
			{
				$__item = ConversationsUsersModel::i()->getItem($__id, array("user_id"));
				
				if(in_array($__item["user_id"], array(0, UserClass::i()->getId())))
					continue;
				
				$__conversation["users"][] = UsersModel::i()->getItem($__item["user_id"], array("id", "first_name", "middle_name", "last_name", "avatar"));
			}
			
			$this->conversations[] = $__conversation;
		}
	}
	
	public function getConversation()
	{
		parent::execute();
		
		if( ! UserClass::i()->isAuthorized())
			parent::redirect("/");
		
		parent::setLayout(false);
		parent::setView("messages/messages_rows");
		
		$__conversationId = Request::getInt("id");
		
		$this->messages = array();
		
		$__cond = array("conversation_id = :conversation_id");
		$__bind = array(
			"conversation_id" => $__conversationId
		);
		
		foreach(ConversationsMessagesModel::i()->getList($__cond, $__bind, array("created_at ASC")) as $__id)
		{
			$__message = ConversationsMessagesModel::i()->getItem($__id, array("user_id", "message", "created_at"));
			
			$__message["user"] = UsersModel::i()->getItem($__message["user_id"], array("id", "first_name", "middle_name", "last_name", "avatar"));
			
			$this->messages[] = $__message;
		}
	}
	
	public function getMessage()
	{
		parent::execute();
		
		if( ! UserClass::i()->isAuthorized())
			parent::redirect("/");
		
		parent::setLayout(false);
		parent::setView("messages/messages_rows");
		
		$__messageId = Request::getInt("id");
		
		$__message = ConversationsMessagesModel::i()->getItem($__messageId, array("user_id", "message", "created_at"));

		$__message["user"] = UsersModel::i()->getItem($__message["user_id"], array("id", "first_name", "middle_name", "last_name", "avatar"));
		
		$this->messages = array($__message);
	}
	
	public function jAddMessage()
	{
		parent::setViewer("json");
		
		if( ! UserClass::i()->isAuthorized())
			return false;
		
		$__userId = Request::get("user_id");
		if( ! is_array($__userId))
			$__userId = array($__userId);
		
		$__users = array_merge($__userId, array(UserClass::i()->getId()));
		
		$__conversationId = ConversationsUsersModel::i()->getConversationIdByUsers($__users);
		
		if( ! $__conversationId)
		{
			$__conversationId = ConversationsModel::i()->insert(array(
				"subject" => stripslashes(Request::getString("subject"))
			));
			
			foreach($__users as $__userId)
			{
				ConversationsUsersModel::i()->insert(array(
					"conversation_id" => $__conversationId,
					"user_id" => $__userId
				));
			}
		}
		else
		{
			ConversationsModel::i()->update(array(
				"id" => $__conversationId
			));
		}
		
		$__messageId = ConversationsMessagesModel::i()->insert(array(
			"conversation_id" => $__conversationId,
			"user_id" => UserClass::i()->getId(),
			"message" => stripslashes(Request::getString("message"))
		));
		
		$this->json = array(
			"conversation_id" => $__conversationId,
			"message_id" => $__messageId
		);
		
		return true;
	}
}
