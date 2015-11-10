<?php

Loader::loadModule("Admin");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadModel("EmailTemplatesModel");
Loader::loadClass("EmailClass", Loader::SYSTEM);

class EmailTemplatesAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Управління шаблонами повідомлень";
	public static $modAHref = "/admin/email_templates";
	public static $modImgSrc = "email_templates";
	
	public function execute()
	{
		parent::execute();
		parent::setView("email_templates");
		parent::loadKendo(true);
		parent::loadCKEditor(true);
		parent::loadWindow("admin/email_templates/form");
		parent::loadWindow("admin/email_templates/confirm");
		
		HeadClass::addJs(array(
			"/js/form.js",
			"/js/i18n.js",
			"/js/frontend/admin/email_templates.js"
		));
		
		$__list = EmailTemplatesModel::i()->getCompiledList(array(), array(), array("created_at DESC"));
		
		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->list = $__pager->getList();
		$this->pager = $__pager;
	}
	
	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! ($__item = EmailTemplatesModel::i()->getItem($__id))
		){
			return false;
		}
		
		$this->json['item'] = $__item;
		
		return true;
	}
	
	public function jSave()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		$__id	= Request::getInt("id");
		
		$__data = array(
			"symlink" => Request::getString("symlink"),
			"from" => Request::getArray("from"),
			"subject" => Request::getArray("subject"),
			"message" => Request::getArray("message")
		);
		
		foreach(array("from", "subject", "message") as $__field)
		{
			foreach(Router::getLangs() as $__lang)
				if(
						! isset($__data[$__field])
						|| ! isset($__data[$__field][$__lang])
						|| ! is_string($__data[$__field][$__lang])
				)
					$__data[$__field][$__lang] = "";
		}
		
		if(
				! ($__id > 0)
				|| ! (EmailTemplatesModel::i()->update(array_merge(array("id" => $__id), $__data)))
		)
			$__id = EmailTemplatesModel::i()->insert($__data);
				
		$this->json["item"] = EmailTemplatesModel::i()->getItem($__id);
	}
	
	public function jDelete()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		$__selectedId = Request::get("id");
		
		if (!is_array($__selectedId))
			$__selectedId = array($__selectedId);
			
		foreach ($__selectedId as $id) 
		{
			EmailTemplatesModel::i()->deleteItem($id);	
		}
	}
	
	public function jMakeMailing()
	{
		parent::setViewer("json");
		$this->json["success"] = true;
		
		$__templateId = Request::getInt("id");
		$__emailsList = Request::getArray("emails");
		$__template = $this->__getEmailTemplate($__templateId);
		
		foreach($__emailsList as $email)
		{
			$__email = new EmailClass();
			
			$__email->addRecipient($email);
			
			$__email->setSender($__template["from"][Router::getLang()]);
			$__email->subject($__template["subject"][Router::getLang()]);
			$__email->message($__template["message"][Router::getLang()]);
			$__email->send();
		}
		
	}
}
