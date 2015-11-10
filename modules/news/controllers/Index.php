<?php

Loader::loadModule("News");

Loader::loadModel("materials.NewsMaterialsModel");
Loader::loadModel("NewsCategoriesModel");
Loader::loadModel("NewsTagsModel");
Loader::loadModel("NewsImagesModel");
Loader::loadModel("election.ElectionCandidatesModel");

Loader::loadClass("PagerClass", Loader::SYSTEM);
Loader::loadClass("OGeoClass");
Loader::loadClass("OldGeoClass");
Loader::loadClass("UserClass");

class IndexNewsController extends NewsController
{
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
		
		$__item["images"] = array();
		foreach(NewsImagesModel::i()->getList(["material_id = :material_id"], ["material_id" => $__item["id"]]) as $__id)
			$__item["images"][] = NewsImagesModel::i()->getItem($__id, ["symlink"])["symlink"];
		
		return $__item;
	}
	
	private function __getCategory($id)
	{
		if( ! ($__item = NewsCategoriesModel::i()->getItem($id)))
			return $__item;
		
		return $__item;
	}
	
	private function __getCategories()
	{
		$__list = array();

		$__cond = array("is_public = :is_public");
		$__bind = array(
			"is_public" => true
		);

		foreach(NewsCategoriesModel::i()->getList($__cond, $__bind, array("priority ASC")) as $__id)
		{
			$__list[] = $this->__getCategory($__id);
		}
		
		return $__list;
	}
	
	private function __viewList()
	{
		parent::setView("index/view_list");
		
		HeadClass::addJs("/js/frontend/news/index/view_list.js");
		HeadClass::addLess("/less/frontend/news/index/view_list.less");

		$__rnd = rand(-999, -1);

		$__categories = array();
		$__categoriesIds = array();
		foreach(NewsCategoriesModel::i()->getList(["is_public = :is_public"], ["is_public" => 1]) as $__id)
		{
			$__category = NewsCategoriesModel::i()->getItem($__id, ["id", "symlink", "name"]);
			$__category["name"] = $__category["name"][Router::getLang()];
			$__categories[] = $__category;
			$__categoriesIds[] = $__category["id"];
		}
		
		$__filter = array();
		
		$__cond = array("is_public = :is_public");
		$__bind = array("is_public" => 1);
		
		$__category = Request::get("category");
		if( ! is_null($__category))
		{
			if(in_array($__category, $__categoriesIds))
			{
				$__cond[] = "category_id = :category_id";
				$__bind["category_id"] = $__category;
			}
			elseif($__category == "by_regions")
			{
				$__category = NewsCategoriesModel::i()->getItemBySymlink($__category)["id"];

				$__cond[] = "category_id = :category_id";
				$__bind["category_id"] = $__category;

				$this->regions = [];
				foreach(OldGeoClass::i()->getRegions() as $__region)
				{
					if( ! (count(NewsMaterialsModel::i()->getList(["geo_koatuu_code REGEXP '".substr($__region["id"], 0, 2)."[0-9]{8}'"])) > 0))
						continue;

					$this->regions[] = $__region;
				}

				if(($__geo = Request::getString("geo", "-1")) != "-1" && strlen($__geo) == 10)
				{
					for($__i = 9; $__i > 0; $__i--)
					{
						if(substr($__geo, $__i, 1) == "0")
							continue;

						$__geo = substr($__geo, 0, $__i + 1);
						break;
					}

					$__cond[] = "geo_koatuu_code REGEXP '".$__geo."[0-9]{".(10-strlen($__geo))."}'";
					$__filter["regions"] = substr($__geo, 0, 2).str_repeat("0", 8);
				}

			}
			elseif($__category == "election")
			{
				$__cond[] = "in_election = 1";
				
				$this->electionCandidates = array();
				$__electionCandidatesIds = array();
				
				$__sql = "SELECT id "
						. "FROM election_candidates "
						. "WHERE id IN ("
						. "SELECT election_candidate_id "
						. "FROM materials "
						. "WHERE election_candidate_id > 0 "
						. "GROUP BY election_candidate_id"
						. ") AND is_public = 1;";
				
				foreach(ElectionCandidatesModel::i()->getCols($__sql) as $__id)
				{
					$__electionCandidate = ElectionCandidatesModel::i()->getItem($__id, ["id", "first_name", "middle_name", "last_name"]);
					$__electionCandidatesIds[] = $__id;
					$this->electionCandidates[] = [
						"id" => $__electionCandidate["id"],
						"name" => UserClass::getNameByItem($__electionCandidate)
					];
				}
				
				$__ecid = Request::get("ecid");
				if( ! is_null($__ecid) && in_array($__ecid, $__electionCandidatesIds))
				{
					$__cond[] = "election_candidate_id = :election_candidate_id";
					$__bind["election_candidate_id"] = $__ecid;
					$__filter["ecid"] = $__ecid;
				}
			}
			
			$__filter["category"] = $__category;
		}

		$__tag = Request::get("tag");
		if( ! is_null($__tag))
			$__filter["tag"] = $__tag;

		$__q = stripslashes(urldecode(Request::getString("q")));
		if( ! empty($__q))
		{
			foreach (explode(" ", $__q) as $__token) {
				if(empty($__token))
					continue;

				$__cond[] = ["OR" => [
					"title LIKE '%{$__token}%'",
					"announcement LIKE '%{$__token}%'",
					"text LIKE '%{$__token}%'"
				]];
			}
			$__filter["q"] = $__q;
		}

		$__list = NewsMaterialsModel::i()->getList($__cond, $__bind, ["created_at DESC"]);
		
		$__tagsIds = array();
		foreach($__list as $__i => $__id)
		{
			$__tokens = NewsMaterialsModel::i()->getItem($__id, ["tags_ids", "text"]);

			if(
					isset($__filter["tag"])
					&& ( ! is_array($__tokens["tags_ids"]) || ! in_array($__filter["tag"], $__tokens["tags_ids"]))
			)
				unset($__list[$__i]);
			
			if(is_array($__tokens["tags_ids"]))
				$__tagsIds = array_merge_recursive($__tagsIds, array_diff($__tokens["tags_ids"], $__tagsIds));
		}
		
		$__list = array_values($__list);
		
		$this->tags = array();
		foreach($__tagsIds as $__tagId)
			$this->tags[] = NewsTagsModel::i()->getItem($__tagId, ["id", "name"]);
		
		$__pager = new PagerClass($__list, Request::getInt("page"), 14);
		
		$this->list = array();
		foreach($__pager->getList() as $__id)
			$this->list[] = $this->__getItem($__id);
		
		$this->pager = $__pager;
		$this->categories = $__categories;
		$this->filter = $__filter;
		
		return true;
	}
	
	private function __viewItem($id)
	{
		parent::setView("index/view_item");
		parent::loadWindow([
			"news/index/view_item/image_viewer"
		]);
		
		HeadClass::addJs("/js/frontend/news/index/view_item.js");
		HeadClass::addLess("/less/frontend/news/index/view_item.less");
		
		$this->menuClickable = true;
		
		$__categories = array();
		$__categoriesIds = array();
		foreach(NewsCategoriesModel::i()->getList(["is_public = :is_public"], ["is_public" => 1]) as $__id)
		{
			$__category = NewsCategoriesModel::i()->getItem($__id, ["id", "name"]);
			$__category["name"] = $__category["name"][Router::getLang()];
			$__categories[] = $__category;
			$__categoriesIds[] = $__category["id"];
		}
		
		$this->electionCandidates = array();
		$__electionCandidatesIds = array();

		$__sql = "SELECT id "
				. "FROM election_candidates "
				. "WHERE id IN ("
				. "SELECT election_candidate_id "
				. "FROM materials "
				. "WHERE election_candidate_id > 0 "
				. "GROUP BY election_candidate_id"
				. ") AND is_public = 1;";

		foreach(ElectionCandidatesModel::i()->getCols($__sql) as $__id)
		{
			$__electionCandidate = ElectionCandidatesModel::i()->getItem($__id, ["id", "first_name", "middle_name", "last_name"]);
			$__electionCandidatesIds[] = $__id;
			$this->electionCandidates[] = [
				"id" => $__electionCandidate["id"],
				"name" => UserClass::getNameByItem($__electionCandidate)
			];
		}
		
		$this->item = $this->__getItem($id);

		$this->tags = array();
		foreach($this->item["tags_ids"] as $__tagId)
			$this->tags[] = NewsTagsModel::i()->getItem($__tagId, ["id", "name"]);

		if( ! $this->item["is_public"] && ! UserClass::i()->hasCredential(777))
			parent::redirect("/news");

		$this->categories = $__categories;
		
		parent::title($this->item["title"]." | ".parent::title());
		parent::description($this->item["announcement"]);
		
		parent::enableSharingButtons(true);
		
		if(count($this->item["images"]) > 0)
			parent::sharing("image", "http://".Uri::getUrl()."/s/img/thumb/am/".$this->item["images"][0]);
		
		return true;
	}

	public function execute($args = array())
	{
		parent::execute();
		parent::loadKendo(true);
		
		parent::title("Новини | ".parent::title());
		
		HeadClass::addLess("/less/frontend/news/index.less");
		
		if(
				isset($args[0])
				&& $args[0] > 0
				&& NewsMaterialsModel::i()->getItem((int) $args[0], ["id"])
		)
			return $this->__viewItem($args[0]);
		
		$this->indexNewsController = new stdClass();
		
		return $this->__viewList();
	}
	
	public function jAddComment()
	{
		parent::execute();
		parent::setViewer("json");
		
		$__xtnd = array(
			"name" => stripslashes(Request::getString("name")),
			"email" => stripslashes(Request::getString("email"))
		);
		
		$__data = array(
			"content_id" => Request::getInt("content_id"),
			"text" => stripslashes(Request::getString("text")),
			"author_id" => Request::getInt("author_id"),
			"parent_id" => Request::getInt("parent_id"),
			"__xtnd" => $__xtnd
		);
		$__id = NewsCommentsModel::i()->insert($__data);
		
		$this->json["item"] = $this->__compileCommentItem(NewsCommentsModel::i()->getItem($__id));
		
		return true;
	}
}
