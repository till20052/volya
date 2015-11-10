<?php

Loader::loadModule("Admin");

Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadClass("OGeoClass");
Loader::loadClass("OldGeoClass");
Loader::loadClass("UserClass");

Loader::loadModel("materials.NewsMaterialsModel");
Loader::loadModel("NewsCategoriesModel");
Loader::loadModel("NewsTagsModel");
Loader::loadModel("NewsImagesModel");
Loader::loadModel("ProjectsModel");
Loader::loadModel("UsersModel");
Loader::loadModel("election.ElectionCandidatesModel");

class NewsAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Менеджер новин";
	public static $modAHref = "/admin/news";
	public static $modImgSrc = "news";
	
	private function __getItem($id)
	{
		if( ! ($__item = NewsMaterialsModel::i()->getItem($id)))
			return $__item;
		
		foreach(["title", "announcement", "text", "meta_title", "meta_description", "meta_keywords"] as $__field)
		{
			$__value = "";
			
			if(isset($__item[$__field][Router::getLang()]))
				$__value = $__item[$__field][Router::getLang()];
				
			$__item[$__field] = $__value;
		}

		$__item["region"] = 0;
		if(strlen($__item["geo_koatuu_code"]) == 10)
			$__item["region"] = substr($__item["geo_koatuu_code"], 0, 2).str_repeat("0", 8);

		$__item["city"] = ["id" => 0, "title" => ""];

		if(strlen($__item["geo_koatuu_code"]) == 10 && ! preg_match("/([0-9]{2})0{8}/i", $__item["geo_koatuu_code"]))
		{
			$__item["city"]["id"] = $__item["geo_koatuu_code"];
			$__item["city"]["title"] = OldGeoClass::i()->getCity($__item["geo_koatuu_code"])["title"];
		}

		$__item["images"] = array();
		foreach(NewsImagesModel::i()->getList(["material_id = :material_id"], ["material_id" => $__item["id"]]) as $__id)
			$__item["images"][] = NewsImagesModel::i()->getItem($__id, ["symlink"])["symlink"];
		
		$__item["images"] = array();
		foreach(NewsImagesModel::i()->getList(["material_id = :material_id"], ["material_id" => $__item["id"]]) as $__id)
			$__item["images"][] = NewsImagesModel::i()->getItem($__id, ["symlink"])["symlink"];
		
		return $__item;
	}
	
	private function __getProjects()
	{
		$__list = array();
		
		$__cond = array("is_public = 1");
		$__bind = array();
		
		foreach(ProjectsModel::i()->getList($__cond, $__bind, array("created_at DESC")) as $__item)
		{
			$__project = ProjectsModel::i()->getItem($__item, array("id", "title"));
			$__project["title"] = $__project["title"][Router::getLang()];
			$__list[] = $__project;
		}
		
		return $__list;
	}
	
	private function __getCategories($options = [])
	{
		$__list = [];
		
		$__cond = [];
		$__bind = [];
		
		if(isset($options["is_public"]))
		{
			$__cond[] = "is_public = :is_public";
			$__bind["is_public"] = $options["is_public"];
		}
		
		foreach(NewsCategoriesModel::i()->getList($__cond, $__bind) as $__id)
		{
			$__item = NewsCategoriesModel::i()->getItem($__id, ["id", "symlink", "name", "is_public", "is_system"]);
			
			if(isset($options["use_current_lang"]) && $options["use_current_lang"] == 1)
				$__item["name"] = $__item["name"][Router::getLang()];
			
			$__list[] = $__item;
		}
		
		return $__list;
	}
	
	private function __getTags($options = [])
	{
		$__list = [];
		
		$__cond = [];
		$__bind = [];
		
		if(isset($options["is_public"]))
		{
			$__cond[] = "is_public = :is_public";
			$__bind["is_public"] = $options["is_public"];
		}
		
		foreach(NewsTagsModel::i()->getList($__cond, $__bind) as $__id)
			$__list[] = NewsTagsModel::i()->getItem($__id, ["id", "name", "is_public"]);
		
		return $__list;
	}
	
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		parent::loadCKEditor(true);
		parent::loadFileupload(true);
		
		parent::loadWindow([
			"admin/news/form",
			"admin/news/categories_form",
			"admin/news/tags_form"
		]);

		HeadClass::addJs(array(
			"/js/form.js",
			"/js/frontend/admin/news.js"
		));
		
		HeadClass::addLess([
			"/less/frontend/admin/news.less",
			"/less/frontend/admin/news/form.less"
		]);
		
		$__list = array();
		foreach(NewsMaterialsModel::i()->getList(array(), array(), array("created_at DESC")) as $__id)
			$__list[] = $this->__getItem($__id);
		
		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->list = $__pager->getList();
		$this->pager = $__pager;
		
		$this->categories = $this->__getCategories([
			"is_public" => 1,
			"use_current_lang" => 1
		]);
		
		$this->tags = $this->__getTags([
			"is_public" => 1
		]);
		
		$this->electionCandidates = array();
		foreach(ElectionCandidatesModel::i()->getList(["is_public = :is_public"], ["is_public" => 1]) as $__id)
		{
			$__electionCandidate = ElectionCandidatesModel::i()->getItem($__id, ["id", "first_name", "middle_name", "last_name"]);
			$this->electionCandidates[] = [
				"id" => $__electionCandidate["id"],
				"name" => UserClass::getNameByItem($__electionCandidate)
			];
		}
	}
	
	public function jGetItem()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = $this->__getItem($__id))
		)
			return false;
		
		$this->json["item"] = $__item;
		
		return true;
	}
	
	public function jSaveItem()
	{
		parent::setViewer("json");
		
		$__data = array(
			"category_id" => Request::getInt("category_id"),
			"tags_ids" => Request::getArray("tags_ids"),
			"election_candidate_id" => Request::getInt("election_candidate_id"),
			"meta_title" => stripslashes(Request::getString("meta_title")),
			"meta_description" => stripslashes(Request::getString("meta_description")),
			"meta_keywords" => stripslashes(Request::getString("meta_keywords")),
			"title" => stripslashes(Request::getString("title")),
			"announcement" => stripslashes(Request::getString("announcement")),
			"text" => stripslashes(Request::getString("text")),
			"in_election" => Request::getInt("in_election"),
			"in_main_block" => Request::getInt("in_main_block"),
			"in_volya_people" => Request::getInt("in_volya_people"),
			"in_top" => Request::getInt("in_top"),
			"created_at" => date("Y-m-d H:i:s", strtotime(Request::getString("created_at")))
		);
		
		if( Request::getInt("rid") > 0 )
			$__data["region_id"] = Request::getInt("rid");

		if(($__geoKoatuuCode = Request::getString("geo_koatuu_code", "-1")) != "-1")
			$__data["geo_koatuu_code"] = strlen($__geoKoatuuCode) == 10 ? $__geoKoatuuCode : null;
		
		if( Request::getInt("project_id") > 0 )
			$__data["project_id"] = Request::getInt("project_id");
		
		foreach(["title", "announcement", "text", "meta_title", "meta_description", "meta_keywords"] as $__field)
		{
			if( ! isset($__data[$__field]))
				continue;
			
			$__value = $__data[$__field];
			
			$__data[$__field] = array();
			foreach(Router::getLangs() as $__lang)
				$__data[$__field][$__lang] = $__value;
		}
		
		if(
				! (($__mId = Request::getInt("id")) > 0)
				|| ! (NewsMaterialsModel::i()->update(array_merge(["id" => $__mId], $__data)))
		)
			$__mId = NewsMaterialsModel::i()->insert($__data);
		
		$__images = Request::get("images");
		if( ! is_null($__images) && is_array($__images))
		{
			foreach(NewsImagesModel::i()->getList(["material_id = :material_id"], ["material_id" => $__mId]) as $__id)
				NewsImagesModel::i()->deleteItem($__id);
			
			foreach($__images as $__image)
				NewsImagesModel::i()->insert([
					"material_id" => $__mId,
					"symlink" => $__image
				]);
		}
		
		$this->json["item"] = $this->__getItem($__mId);
		
		return true;
	}
	
	public function jDeleteItem()
	{
		parent::setViewer("json");
		
		if(
				! ($__id = Request::getInt("id")) > 0
				|| ! ($__item = NewsMaterialsModel::i()->getItem($__id))
		)
			return false;
		
		NewsMaterialsModel::i()->deleteItem($__id);
		
		return true;
	}
	
	public function jUpdateItem()
	{
		parent::setViewer("json");
		
		$__data = array();
		
		$__tokens = [];
		foreach(["field", "value"] as $__token)
		{
			$__value = Request::get($__token);
			
			if(is_null($__value))
				continue;
			
			if(is_int($__value))
				$__value = (int) $__value;
			
			if(is_string($__value))
				$__value = stripslashes(Request::getString($__token));
			
			$__tokens[$__token] = $__value;
		}
		
		if( ! in_array($__tokens["field"], ["is_public"]))
			return false;
		
		$__data[$__tokens["field"]] = $__tokens["value"];
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! NewsMaterialsModel::i()->update(array_merge(["id" => $__id], $__data))
		)
			return false;
		
		return true;
	}
	
	public function jGetCategories()
	{
		parent::setViewer("json");
		
		$__options = [];
		
		if(($__isPublic = Request::getInt("is_public", -1)) != -1)
			$__options["is_public"] = $__isPublic;
		
		if(Request::getInt("use_current_lang") == 1)
			$__options["use_current_lang"] = 1;
		
		$this->json["list"] = $this->__getCategories($__options);
		
		return true;
	}
	
	public function jSaveCategory()
	{
		parent::setViewer("json");
		
		$__data = [];
		
		$__name = Request::get("name");
		if( ! is_null($__name))
			$__data["name"] = (string) $__name;
		
		$__isPublic = Request::get("is_public");
		if( ! is_null($__isPublic))
			$__data["is_public"] = (int) $__isPublic;
		
		foreach(["name"] as $__field)
		{
			if( ! isset($__data[$__field]))
				continue;
			
			$__value = stripslashes($__data[$__field]);
			foreach(Router::getLangs() as $__lang)
			{
				if( ! is_array($__data[$__field]))
					$__data[$__field] = [];
				
				$__data[$__field][$__lang] = $__value;
			}
		}
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! NewsCategoriesModel::i()->update(array_merge(["id" => $__id], $__data))
		)
			$__id = NewsCategoriesModel::i()->insert($__data);
		
		$this->json["item"] = NewsCategoriesModel::i()->getItem($__id);
		
		return true;
	}
	
	public function jDeleteCategory()
	{
		parent::setViewer("json");
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! NewsCategoriesModel::i()->getItem($__id)
		)
			return false;
		
		NewsCategoriesModel::i()->deleteItem($__id);
		
		return true;
	}
	
	public function jGetTags()
	{
		parent::setViewer("json");
		
		$__options = [];
		
		if(($__isPublic = Request::getInt("is_public", -1)) != -1)
			$__options["is_public"] = $__isPublic;
		
		$this->json["list"] = $this->__getTags($__options);
		
		return true;
	}
	
	public function jSaveTag()
	{
		parent::setViewer("json");
		
		$__data = [];
		
		$__name = Request::get("name");
		if( ! is_null($__name))
			$__data["name"] = (string) stripslashes($__name);
		
		$__isPublic = Request::get("is_public");
		if( ! is_null($__isPublic))
			$__data["is_public"] = (int) $__isPublic;
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! NewsTagsModel::i()->update(array_merge(["id" => $__id], $__data))
		)
			$__id = NewsTagsModel::i()->insert($__data);
		
		$this->json["item"] = NewsTagsModel::i()->getItem($__id, ["id", "name", "is_public"]);
		
		return true;
	}
	
	public function jDeleteTag()
	{
		parent::setViewer("json");
		
		if(
				! (($__id = Request::getInt("id")) > 0)
				|| ! NewsTagsModel::i()->getItem($__id, ["id"])
		)
			return false;
		
		NewsTagsModel::i()->deleteItem($__id);
		
		return true;
	}
}
