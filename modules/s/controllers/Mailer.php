<?php

Loader::loadModule("S");
Loader::loadModel("mailer.*");
Loader::loadModel("EmailTemplatesModel");
Loader::loadClass("EmailTemplateClass");

class MailerSController extends SController
{
	
	public function sendPlannedMailer($md5 = NULL)
	{
		parent::setViewer("json");
		
		Console::log(date("Y-m-d H:i:s", time()));
		
		$__cond[] = "sending_date < :sending_date";
		$__bind["sending_date"] = date("Y-m-d H:i:s", time());
		
		$__cond[] = "status = 0";
		
		$__list = array();
		
		Console::log(MailerListModel::i()->getCompiledList($__cond, $__bind));
		
		foreach (MailerListModel::i()->getCompiledList($__cond, $__bind) as $__item)
		{
			$__emailStatus = 0;
			MailerListModel::i()->update(array("id" => $__item["id"], "status" => 1));
			
			$__emailTemplate = EmailTemplatesModel::i()->getItem($__item["email_template_id"], array("symlink"));
			
			foreach (MailerRecipientsModel::i()->getCompiledList(array("mailer_id = :mailer_id"), array("mailer_id" => $__item["id"])) as $__recipient)
			{
				$__email = MailerContactsModel::i()->getItem($__recipient["mailer_contact_id"]);
				MailerRecipientsModel::i()->update(array("id" => $__recipient["id"], "status" => 1));
				
				if( ! EmailTemplateClass::i()->send($__emailTemplate["symlink"], $__email["value"]))
				{
					if($__emailStatus == 0)
						$__emailStatus = -2;
					
					MailerRecipientsModel::i()->update(array("id" => $__recipient["id"], "status" => -1));
				}
				else
				{
					$__emailStatus = -1;
					MailerRecipientsModel::i()->update(array("id" => $__recipient["id"], "status" => 2));
				}
			}
			
			if($__emailStatus < 0)
				MailerListModel::i()->update(array("id" => $__item["id"], "status" => $__emailStatus));
			
			if($__emailStatus == 0)
				MailerListModel::i()->update(array("id" => $__item["id"], "status" => 2));
			
			$__list[] = $__item;
		}
	}
	
}
