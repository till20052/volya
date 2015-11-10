<?php

Loader::loadClass("ExtendedClass", Loader::SYSTEM);
Loader::loadClass("EmailClass", Loader::SYSTEM);
Loader::loadModel("EmailTemplatesModel");

class EmailTemplateClass extends ExtendedClass
{
	/**
	 * @param string $instance
	 * @return EmailTemplateClass
	 */
	public static function i($instance = "EmailTemplateClass")
	{
		return parent::i($instance);
	}
	
	public function send($emailTemplateSymlink, $recipient, $varValues = array(), $options = array())
	{
		$__sender = null;
		if(isset($options["sender"]) && is_array($options["sender"]))
			$__sender = array(
				$options["sender"][0],
				isset($options["sender"][1]) ? $options["sender"] : ""
			);
		
		if( ! ($__emailTemplate = EmailTemplatesModel::i()->getItemBySymlink($emailTemplateSymlink)))
			return false;
		
		if(is_null($__sender))
			$__sender = array($__emailTemplate["from"][Router::getLang()]);
		
		$__emailClass = new EmailClass();
		$__emailClass->varTemplates('{$', '}');
		$__emailClass->setSender($__sender[0], isset($__sender[1]) ? $__sender[1] : "");
		
		if(is_array($recipient))
		{
			foreach($recipient as $__recipient)
				$__emailClass->addRecipient($__recipient);
		}
		else
			$__emailClass->addRecipient($recipient);
		
		$__emailClass->subject($__emailTemplate["subject"][Router::getLang()]);
		$__emailClass->message($__emailTemplate["message"][Router::getLang()]);
		$__emailClass->assign($varValues);
		
		return $__emailClass->send();
	}
}
