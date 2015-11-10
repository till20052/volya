<?php

Loader::loadModule("Admin");
Loader::loadModel("TeamModel");
Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadModel("materials.PagesMaterialsModel");

class TeamAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Менеджер команди";
	public static $modAHref = "/admin/team";
	public static $modImgSrc = "team";
	
	private function __getItem($id)
	{
		return TeamModel::i()->getItem($id);
	}
	
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadCKEditor(true);
		parent::loadWindow("admin/team/form");
		parent::loadWindow("admin/team/confirm");
		parent::loadWindow("admin/image_uploader");

		HeadClass::addJs(array(
			"/jquery/js/jquery-ui.min.js",
			"/js/i18n.js",
			"/js/form.js",
			"/js/frontend/admin/team.js"
		));
		
		$__list = TeamModel::i()->getCompiledList(array(), array(), array("priority ASC"));
		
		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->list = $__pager->getList();
		$this->pager = $__pager;
	}
	
	public function page()
	{
		parent::execute();
		parent::setView("/team/page");
		parent::loadKendo(true);
		parent::loadCKEditor(true);
		
		HeadClass::addJs(array(
			"/js/i18n.js",
			"/js/frontend/admin/team/index.js"
		));
	}
	
	public function jGetTeamPage()
	{
		parent::setViewer("json");
		
		$this->json["item"] = PagesMaterialsModel::i()->getItemBySymlink("team");
		
		return true;
	}

	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = TeamModel::i()->getItem($__id))
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
		
		$__links = @split(",", str_replace(" ", "", Request::getString("links")));
		
		$__data = array(
			"name" => Request::getArray("name"),
			"job" => Request::getArray("job"),
			"slogan" => Request::getArray("slogan"),
			"bio" => Request::getArray("bio"),
			"links" => $__links,
			"age" => date("Y-m-d H:i:s", strtotime(Request::getString("age"))),
			"photo" => stripslashes(Request::getString("photo"))
		);
		
		foreach(array("name", "job", "slogan", "bio") as $__field)
		{
			foreach(Router::getLangs() as $__lang)
			{
				if(
						! isset($__data[$__field])
						|| ! isset($__data[$__field][$__lang])
						|| ! is_string($__data[$__field][$__lang])
				){
					$__data[$__field][$__lang] = "";
				}
			}
		}
		
		if(
				! ($__id > 0)
				|| ! (TeamModel::i()->update(array_merge(array("id" => $__id), $__data)))
		){
			$__id = TeamModel::i()->insert($__data);
		}
				
		$this->json["item"] = $this->__getItem($__id);
		
		return true;
	}
	
	public function jSetPriority()
	{
		parent::setViewer("json");
		
		$__priority = Request::getArray("priority");
		
		foreach($__priority as $__index => $__id)
		{
			TeamModel::i()->update(array(
				"id" => $__id,
				"priority" => $__index
			));
		}
		
		$this->json["data"] = TeamModel::i()->getCompiledList(array(), array(), array("priority ASC"));
		
		return true;
	}
	
	public function jDelete()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = TeamModel::i()->getItem($__id))
		){
			return false;
		}
		
		TeamModel::i()->deleteItem($__id);
		
		return true;
	}
	
	public function jPublicate()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = TeamModel::i()->getItem($__id))
		){
			return false;
		}
		
		TeamModel::i()->update(array(
			"id" => $__id,
			"is_public" => (bool) Request::getInt("state")
		));
		
		return true;
	}
}
