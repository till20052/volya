<?php

Loader::loadModule("Election");

Loader::loadClass("OldGeoClass");
Loader::loadClass("ElectionClass");
Loader::loadClass("UserClass");

Loader::loadModel("roep.RoepDistrictsModel");
Loader::loadModel("AgitationsModel");
Loader::loadModel("AgitationsCategoriesModel");
Loader::loadModel("materials.NewsMaterialsModel");
Loader::loadModel("NewsImagesModel");
Loader::loadModel("election.ElectionExitpollsModel");
Loader::loadModel("election.ElectionPartiesModel");
Loader::loadModel("election.ElectionPartiesExitpollsResultsModel");

class IndexElectionController extends ElectionController
{
	private function __viewCandidatesList()
	{
		$this->subView = ["list", "majority"];
		
		HeadClass::addJs("/js/frontend/election/index/candidates.js");
		HeadClass::addLess("/less/frontend/election/index/candidates/list.less");
		
		$__candidates = ElectionClass::i()->getCandidates([
			"cond" => ["is_public = 1", "county_number > 0"]
		]);
		
		$__regions = [];
		foreach($__candidates as $__candidate)
		{
			if(strlen($__candidate["geo_koatuu_code"]) != 10)
				continue;
			
			if( ! isset($__regions[$__candidate["geo_koatuu_code"]]))
				$__regions[$__candidate["geo_koatuu_code"]] = [
					"title" => OldGeoClass::i()->getRegion($__candidate["geo_koatuu_code"])["title"],
					"county_numbers" => [],
					"candidates" => []
				];
			
			if( ! in_array($__candidate["county_number"], $__regions[$__candidate["geo_koatuu_code"]]["county_numbers"]))
				$__regions[$__candidate["geo_koatuu_code"]]["county_numbers"][] = $__candidate["county_number"];
			
			$__regions[$__candidate["geo_koatuu_code"]]["candidates"][] = $__candidate;
		}
		
		$this->regions = $__regions;
	}
	
	private function __viewCandidateItem($candidate)
	{
		$this->subView = "item";
		
		parent::loadKendo(true);
		
		parent::loadWindow([
			"election/index/candidates/item/support"
		]);
		
		HeadClass::addJs([
			"/js/form.js",
			"/js/frontend/election/index/candidates/item.js"
		]);
		
		HeadClass::addLess([
			"/less/frontend/election/index/candidates/item.less",
			"/less/frontend/election/index/candidates/item/support.less"
		]);
		
		$this->submenuClickable = true;
		
		$candidate["contacts"] = ElectionClass::i()->getCandidateContacts($candidate["id"]);
		
		$candidate["opponents"] = [
			1 => [],
			2 => []
		];
		
		foreach(ElectionClass::i()->getCandidateOpponents($candidate["id"]) as $__opponent)
		{
			if($__opponent["is_public"] != 1)
				continue;
			
			$candidate["opponents"][$__opponent["type"]][] = $__opponent;
		}
		
		$candidate["news"] = array();
		
		$__cond = ["is_public = 1", "election_candidate_id = :election_candidate_id"];
		$__bind = [
			"election_candidate_id" => $candidate["id"]
		];
		$__order = ["created_at DESC"];
		
		foreach(NewsMaterialsModel::i()->getList($__cond, $__bind, $__order) as $__id)
		{
			$__item = NewsMaterialsModel::i()->getItem($__id);
			
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
			
			$candidate["news"][] = $__item;
		}
		
		parent::title($candidate["first_name"]." ".$candidate["last_name"]." | ".parent::title());
		parent::description("Кандидат в мажоритарники по виборчому округу № ".$candidate["county_number"].", ".OldGeoClass::i()->getRegion($candidate["geo_koatuu_code"])["title"]);
		
		parent::enableSharingButtons(true);
		parent::sharing("image", "http://".Uri::getUrl()."/s/img/thumb/as/".$candidate["symlink_avatar"]);
		
		$this->candidate = $candidate;
	}
	
	private function __viewAssociation()
	{
		parent::title("Наші кандидати у списку Об’єднання Самопоміч | ".parent::title());
		parent::description("");
		
		parent::enableSharingButtons(true);
		
		$this->subView = ["list", "association"];
	}
	
	// LANDING PAGE
	public function execute()
	{
		parent::execute();
		
		parent::loadKendo(true);
		
		HeadClass::addJs("/js/frontend/election/index/landing_page.js");
		HeadClass::addLess("/less/frontend/election/index/landing_page.less");
		
		$this->candidates = array();
		
//		$__ip = $_SERVER["REMOTE_ADDR"];
//		if(Request::getString("ip") != "")
//			$__ip = Request::getString("ip");
		
//		$__geoData = json_decode(file_get_contents("http://api.sypexgeo.net/json/".$__ip), true); // 91.201.225.194
		
//		if(isset($__geoData["region"]) && isset($__geoData["region"]["okato"]))
//		{
			$__cond = [
				"is_public = :is_public",
//				"geo_koatuu_code REGEXP '".$__geoData["region"]["okato"]."[0-9]{8}'"
			];
			$__bind = ["is_public" => 1];
			$__order = ["percent DESC"];
			
			foreach(ElectionCandidatesModel::i()->getList($__cond, $__bind, $__order, 5) as $__id)
			{
				$this->candidates[] = ElectionCandidatesModel::i()->getItem($__id, [
					"id",
					"symlink",
					"symlink_avatar",
					"first_name",
					"middle_name",
					"last_name",
					"geo_koatuu_code",
					"county_number",
					"is_results_visible",
					"percent"
				]);
			}
//		}
		
		$__exitpolls = array();
		foreach(ElectionExitpollsModel::i()->getList(["is_public = 1"], [], ["priority ASC"]) as $__id)
			$__exitpolls[] = ElectionExitpollsModel::i()->getItem($__id, ["id", "name"]);
		
		$__parties = array();
		foreach(ElectionPartiesModel::i()->getList() as $__id)
		{
			$__party = ElectionPartiesModel::i()->getItem($__id, ["id", "name", "is_special"]);
			
			$__party["results"] = array();
			$__cond = ["election_party_id = :epid"];
			$__bind = ["epid" => $__party["id"]];
//			$__midValue = 0;
			foreach(ElectionPartiesExitpollsResultsModel::i()->getList($__cond, $__bind) as $__eperId)
			{
				$__eperItem = ElectionPartiesExitpollsResultsModel::i()->getItem($__eperId);
				$__party["results"][$__eperItem["election_exitpoll_id"]] = $__eperItem["value"];
//				$__midValue += $__eperItem["value"];
			}
			
//			$__party["results"][0] = number_format($__midValue / count($__party["results"]), 2);
			
			$__parties[] = $__party;
		}
		
		$this->charts = [
			"exitpolls" => $__exitpolls,
			"parties" => $__parties
		];
		
		$__cond = [
			"is_public = :is_public",
			"in_election = :in_election"
		];
		$__bind = [
			"is_public" => 1,
			"in_election" => 1
		];
		
		$__list = array();
		foreach(NewsMaterialsModel::i()->getList($__cond, $__bind, ["created_at DESC"], 13) as $__id)
		{
			$__item = NewsMaterialsModel::i()->getItem($__id, ["id", "title", "created_at"]);
			$__list[] = [
				"id" => $__item["id"],
				"title" => $__item["title"][Router::getLang()],
				"created_at" => $__item["created_at"]
			];
		}
		
		$this->news = $__list;
	}
	
	// PROGRAM
	public function program()
	{
		parent::execute();
		
		HeadClass::addLess("/less/frontend/election/index/program.less");
		
		parent::title("Передвиборча программа | ".parent::title());
		parent::description();
		
		parent::enableSharingButtons(true);
		
		$this->menuClickable = true;
	}
	
	// AGITATION
	public function agitation()
	{
		parent::execute();
		parent::loadKendo(true);
		
		parent::title("Агітаційні матеріали | ".parent::title());
		parent::description("");
		
		parent::enableSharingButtons(true);
		
		HeadClass::addJs([
			"/js/frontend/election/index/agitation.js"
		]);
		
		HeadClass::addLess("/less/frontend/election/index/agitations.less");
		
		$this->menuClickable = true;
		
		$__candidates = [];
		$__counties = [];
		foreach(ElectionCandidatesModel::i()->getList(["is_public = 1"], [], ["county_number"]) as $__id)
		{
			$__item = ElectionCandidatesModel::i()->getItem($__id, ["id", "first_name", "last_name", "county_number"]);
			
			$__candidates[] = $__item;
			
			$__contacts = ElectionClass::i()->getCandidateContacts($__item["id"]);
			if( ! isset($__contacts["phone"]) && ! isset($__contacts["email"]))
				continue;
			
			$__counties[] = array(
				"id" => $__item["county_number"],
				"county_number" => t("Одномандатний виборчий округ № ").$__item["county_number"],
				"contacts" => $__contacts
			);
		}
		
		$this->candidates = $__candidates;
		$this->counties = $__counties;
	}
	
	public function jGetAgitations()
	{
		parent::setViewer("json");
		
		$__agitations = array();
		$__categories = array();
		
		$__cond = ["is_public = 1"];
		$__bind = [];
		
		$__inElection = Request::get("in_election");
		if( ! is_null($__inElection))
		{
			$__cond[] = "in_election = :in_election";
			$__bind["in_election"] = (int) $__inElection;
		}
		
		$__candidateId = Request::get("candidate_id");
		if( ! is_null($__candidateId))
		{
			$__cond[] = "election_candidate_id = :election_candidate_id";
			$__bind["election_candidate_id"] = (int) $__candidateId;
		}
		
		foreach(AgitationsModel::i()->getList($__cond, $__bind) as $__id)
		{
			$__item = AgitationsModel::i()->getItem($__id);
			
			$__item["name"] = $__item["name"][Router::getLang()];
			
			if( ! is_array($__item["categories_ids"]))
				$__item["categories_ids"] = [];
			
			foreach($__item["categories_ids"] as $__id)
			{
				if(
						in_array($__id, array_keys($__categories))
						|| ! ($__category = AgitationsCategoriesModel::i()->getItem($__id))
				)
					continue;
				
				$__categories[$__category["id"]] = $__category["name"][Router::getLang()];
			}
			
			$__agitations[] = $__item;
		}
		
		$this->json["agitations"] = $__agitations;
		
		$this->json["categories"] = array();
		foreach($__categories as $__id => $__name)
			$this->json["categories"][] = [
				"id" => $__id,
				"name" => $__name
			];
		
		return true;
	}
	
	// CANDIDATES
	public function candidates($args = [])
	{
		parent::execute();
		
		$this->menuClickable = true;
		
		if(isset($args[0]) && strlen($args[0]) > 0 && $args[0] == "association")
			return $this->__viewAssociation();
		
		if(isset($args[0]) && strlen($args[0]) > 0 && ($__candidate = ElectionClass::i()->getCandidateBySymlink($args[0])))
			return $this->__viewCandidateItem($__candidate);
		
		return $this->__viewCandidatesList();
	}
	
	public function jSaveHelper()
	{
		parent::setViewer("json");
		
		$__errors = array();
		$__level = Request::getInt("level");
		
		// NAME
		$__name = str_replace("'", "\'", stripslashes(Request::getString("name")));
		if(empty(preg_replace("/\s+/i", "", $__name)))
			$__errors[] = "name_should_not_be_empty";
		else
			@list($__firstName, $__lastName, $__middleName) = explode(" ", $__name);
		
		// EMAIL
		$__email = str_replace("'", "\'", stripslashes(Request::getString("email")));
		if( ! filter_var($__email, FILTER_VALIDATE_EMAIL))
			$__errors[] = "email_has_not_correct_value";
		
		$__geoKoatuuCode = null;
		if($__level > 0)
		{
			$__geoKoatuuCode = Request::get("geo_koatuu_code");
			if(is_null($__geoKoatuuCode) || strlen($__geoKoatuuCode) != 10)
				$__errors[] = "set_locality";
			else
				$__geoKoatuuCode = str_replace("'", "\'", stripslashes($__geoKoatuuCode));
		}
		
		if(count($__errors) > 0)
		{
			$this->json["errors"] = $__errors;
			return false;
		}
		
		$__data = [
			"type" => 2,
			"login" => (string) $__email,
			"first_name" => (string) $__firstName,
			"middle_name" => (string) $__middleName,
			"last_name" => (string) $__lastName,
			"geo_koatuu_code" => $__geoKoatuuCode,
			"i_want_to_be_a_helper" => Request::getInt("i_want_to_be_a_helper"),
			"helper_type" => Request::getInt("helper_type")
		];
		
		$__additionalInfo = Request::get("additional_info");
		if( ! is_null($__additionalInfo))
			$__data["additional_info"] = str_replace("'", "\'", stripslashes($__additionalInfo));
		
		$__countyNumber = Request::get("county_number");
		if( ! is_null($__countyNumber) && intval($__countyNumber) > 0)
			$__data["county_number"] = (int) $__countyNumber;
		
		$__pollingPlaceNumber = Request::get("polling_place_number");
		if( ! is_null($__pollingPlaceNumber) && intval($__pollingPlaceNumber) > 0)
			$__data["polling_place_number"] = (int) $__pollingPlaceNumber;
		
		$__userId = UsersModel::i()->insert($__data);
		
		UserClass::i($__userId)->addContact("email", $__email);
		
		// PHONE
		$__phone = str_replace("'", "\'", stripslashes(Request::getString("phone")));
		if( ! in_array(strlen($__phone), [10, 12]))
			UserClass::i($__userId)->addContact("phone", $__phone);
		
		$__candidateId = Request::get("candidate_id");
		if( ! is_null($__candidateId) && $__candidateId > 0)
		{
			ElectionCandidatesSupportersModel::i()->insert([
				"election_candidate_id" => (int) $__candidateId,
				"user_id" => $__userId
			]);
		}
		
		return true;
	}
	
	// HELPING
	public function helping()
	{
		parent::execute();
		
		parent::loadKendo(true);
		
		HeadClass::addJs([
			"/js/form.js",
			"/js/frontend/election/index/helping.js"
		]);
		
		HeadClass::addLess("/less/frontend/election/index/helping.less");
		
		$this->menuClickable = true;
	}
}
