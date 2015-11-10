<?php

Loader::loadModule("Admin");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadClass("EmailTemplateClass");
//Loader::loadClass("OldGeoClass");
Loader::loadModel("mailer.*");
Loader::loadModel("EmailTemplatesModel");

class MailerAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Менеджер розсилок";
	public static $modAHref = "/admin/mailer";
	public static $modImgSrc = "mailer";
	
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadCKEditor(true);
		parent::loadWindow("admin/mailer/form");
		parent::loadWindow("admin/mailer/confirm");
		parent::loadWindow("admin/mailer/add_contacts");
		parent::loadWindow("admin/mailer/recipients");

		HeadClass::addJs(array(
			"/js/form.js",
			"/js/frontend/admin/mailer.js"
		));
		
		$__list = array();
		foreach (MailerListModel::i()->getCompiledList(array(), array(), array("created_at DESC")) as $__item)
		{
			$__item["recipients_count"] = count(MailerRecipientsModel::i()->getList(array("mailer_id = :mailer_id"), array("mailer_id" => $__item["id"])));
			$__emailTemplate = EmailTemplatesModel::i()->getItem($__item["email_template_id"], array("subject"));
			$__item["subject"] = $__emailTemplate["subject"][Router::getLang()];
			
			$__list[] = $__item;
		}
		
		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->emailTemplates = EmailTemplatesModel::i()->getCompiledList();
		$this->contacts = MailerContactsModel::i()->getCompiledList(array(), array(), array("created_at DESC"));
		
		$this->list = $__pager->getList();
		$this->pager = $__pager;
	}
	
	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = MailerListModel::i()->getItem($__id))
		){
			return false;
		}
		
		$this->json["item"] = $__item;
		
		return true;
	}
	
	public function jSave()
	{
		parent::setViewer("json");
		
		$__id = Request::getInt("id");
		
		$__data = array(
			"email_template_id" => Request::getInt("email_template_id"),
			"user_author_id" => UserClass::i()->getId(),
			"sending_date" => date("Y-m-d H:i:s", strtotime(Request::getString("sending_date")))
		);
		
		if(
				! ($__id > 0)
				|| ! (MailerListModel::i()->update(array_merge(array("id" => $__id), $__data)))
		){
			$__id = MailerListModel::i()->insert($__data);
		}
		
		$__recipients = Request::getArray("contacts");
		foreach($__recipients as $__recipient)
			MailerRecipientsModel::i()->insert(array("mailer_id" => $__id, "mailer_contact_id" => $__recipient));
		
		$this->json["item"] = MailerListModel::i()->getItem($__id);
		
		$this->json["item"]["recipients_count"] = count(MailerRecipientsModel::i()->getList(array("mailer_id = :mailer_id"), array("mailer_id" => $this->json["item"]["id"])));
		
		$__emailTemplate = EmailTemplatesModel::i()->getItem($this->json["item"]["email_template_id"], array("subject"));
		$this->json["item"]["subject"] = $__emailTemplate["subject"][Router::getLang()];
		
		return true;
	}
	
	public function jGetErrorRecipients()
	{
		parent::setViewer("json");
		
		$__mailerId = Request::getInt("mailer_id");
		$__recipients = array();
		
		$__list = MailerRecipientsModel::i()->getCompiledListByField("mailer_id", $__mailerId, array("mailer_contact_id"));
		foreach($__list as $__item)
			$__recipients[] = MailerContactsModel::i()->getItem($__item["mailer_contact_id"], array("id","value"));
		
		$this->json["recipients"] = $__recipients;
		return true;
	}
	
	public function jGetEmailTemplates()
	{
		parent::setViewer("json");
		
		$this->json["email_templates"] = array();
		foreach (EmailTemplatesModel::i()->getList() as $__template)
			$this->json["email_templates"][] = EmailTemplatesModel::i()->getItem ($__template, array("id", "subject"));
		
		return true;
	}
	
	public function jGetMailerContacts()
	{
		parent::setViewer("json");
		
		$this->json["contacts"] = array();
		foreach (MailerContactsModel::i()->getList() as $__contact)
			$this->json["contacts"][] = MailerContactsModel::i()->getItem ($__contact, array("id", "value"));
		
		return true;
	}
	
	public function jDeleteContact()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = MailerContactsModel::i()->getItem($__id))
		){
			return false;
		}
		
		MailerContactsModel::i()->deleteItem($__id);
		
		return true;
	}
	
	public function jAddContacts()
	{
		parent::setViewer("json");
		
		$__contacts = preg_split('/\,|\s+|\n/i', stripslashes(Request::getString("contacts")));
		
		$this->json["array"] = $__contacts;
		$this->json["list"] = array();
		$this->json["errors"] = array();
		$__list = array();
		
		foreach ($__contacts as $__contact)
			if($__contact != '')
				if( ! filter_var($__contact, FILTER_VALIDATE_EMAIL))
					$this->json["errors"][] = $__contact;
				else
					$__list[] = MailerContactsModel::i()->insert(array("type" => "email", "value" => $__contact));
		
		foreach ($__list as $__item)
			$this->json["list"][] = MailerContactsModel::i()->getItem($__item);
		
		return true;
	}
}
