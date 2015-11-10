<?php

Loader::loadModule("Admin");

Loader::loadClass("ElectionClass");
Loader::loadClass("PagerClass", Loader::SYSTEM);

Loader::loadModel("AgitationsModel");
Loader::loadModel("AgitationsCategoriesModel");
Loader::loadModel("election.ElectionExitpollsModel");
Loader::loadModel("election.ElectionPartiesModel");
Loader::loadModel("election.ElectionPartiesExitpollsResultsModel");

Loader::loadClass("PHPExcel", Loader::SYSTEM);

class ElectionAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Вибори 2014";
	public static $modAHref = "/admin/election";
	public static $modImgSrc = "election";
	
	private function __init()
	{
		parent::execute();
		
		parent::loadKendo(true);
		
		HeadClass::addLess([
			"/less/frontend/admin/election.less"
		]);
	}
	
	private function __getAgitationCategories($options = [])
	{
		$__list = [];
		
		$__cond = [];
		$__bind = [];
		
		if(isset($options["is_public"]))
		{
			$__cond[] = "is_public = :is_public";
			$__bind["is_public"] = $options["is_public"];
		}
		
		foreach(AgitationsCategoriesModel::i()->getList($__cond, $__bind) as $__id)
		{
			$__item = AgitationsCategoriesModel::i()->getItem($__id, ["id", "name", "is_public"]);
			
			if(isset($options["use_current_lang"]) && $options["use_current_lang"] == 1)
				$__item["name"] = $__item["name"][Router::getLang()];
			
			$__list[] = $__item;
		}
		
		return $__list;
	}
	
	public function execute()
	{
		parent::redirect("/admin/election/candidates");
	}
	
	public function candidates()
	{
		$this->__init();
		
		parent::loadFileupload(true);
		
		parent::loadWindow([
			"admin/election/candidates/form",
			"admin/election/candidates/agitation_form",
			"admin/election/candidates/agitation_categories_form",
			"admin/election/candidates/opponent_form",
			"admin/election/candidates/export_form"
		]);
		
		HeadClass::addJs([
			"/js/form.js",
			"/js/frontend/admin/election/candidates.js"
		]);
		HeadClass::addLess([
			"/less/frontend/admin/election/candidates/form.less",
			"/less/frontend/admin/election/candidates/agitation_form.less",
			"/less/frontend/admin/election/candidates/opponent_form.less"
		]);
		
		$this->pager = new PagerClass(ElectionClass::i()->getCandidates(), Request::getInt("page"), 14);
		$this->list = $this->pager->getList();
		
		$this->agitationCategories = $this->__getAgitationCategories([
			"is_public" => 1,
			"use_current_lang" => 1
		]);
	}
	
	public function jGetCandidate()
	{
		parent::setViewer("json");
		
		if( ! (($__id = Request::getInt("id")) > 0))
			return false;
		
		$this->json["item"] = ElectionClass::i()->getCandidate($__id);
		$this->json["item"]["contacts"] = ElectionClass::i()->getCandidateContacts($__id);
		$this->json["item"]["opponents"] = ElectionClass::i()->getCandidateOpponents($__id);
		$this->json["item"]["agitations"] = ElectionClass::i()->getCandidateAgitations($__id);
		
		return true;
	}
	
	public function jSaveCandidate()
	{
		parent::setViewer("json");
		
		$__data = array(
			"symlink" => Request::getString("symlink"),
			"symlink_avatar" => Request::getString("symlink_avatar"),
			"first_name" => Request::getString("first_name"),
			"middle_name" => Request::getString("middle_name"),
			"last_name" => Request::getString("last_name"),
			"geo_koatuu_code" => Request::getString("geo_koatuu_code"),
			"staff_address" => Request::getString("staff_address"),
			"county_number" => Request::getInt("county_number"),
			"announcement" => Request::getString("announcement"),
			"biography" => Request::getString("biography"),
			"program" => Request::getString("program"),
			"quote" => Request::getString("quote"),
			"is_results_visible" => Request::getInt("is_results_visible"),
			"percent" => Request::getFloat("percent"),
			"place_number" => Request::getInt("place_number"),
			"votes_count" => Request::getInt("votes_count"),
			"difference" => Request::getFloat("difference"),
		);
		
		foreach($__data as $__field => $__value)
		{
			if( ! is_string($__data[$__field]))
				continue;
			
			$__data[$__field] = stripslashes($__value);
		}
		
		$__id = ElectionClass::i()->saveCandidate($__data, Request::getInt("id"));
		
		ElectionClass::i()->cleanUpCandidateContacts($__id);
		ElectionClass::i()->setCandidateContacts($__id, Request::getArray("contacts")["email"], "email");
		ElectionClass::i()->setCandidateContacts($__id, Request::getArray("contacts")["phone"], "phone");
		ElectionClass::i()->setCandidateContacts($__id, Request::getArray("contacts")["facebook"], "facebook");
		ElectionClass::i()->setCandidateContacts($__id, Request::getArray("contacts")["twitter"], "twitter");
		ElectionClass::i()->setCandidateContacts($__id, Request::getArray("contacts")["website"], "website");
		
		ElectionClass::i()->setCandidateOpponents($__id, Request::getArray("opponents_ids"));
		ElectionClass::i()->setCandidateAgitations($__id, Request::getArray("agitations_ids"));
		
		$this->json["item"] = ElectionCandidatesModel::i()->getItem($__id);
		
		return true;
	}
	
	public function jCandidatePublicate()
	{
		parent::setViewer("json");
		
		if( ! (($__id = Request::getInt("id")) > 0) || ! ElectionCandidatesModel::i()->getItem($__id, ["id"]))
			return false;
		
		ElectionCandidatesModel::i()->update([
			"id" => $__id,
			"is_public" => Request::getInt("state")
		]);
		
		return true;
	}
	
	public function jDeleteCandidate()
	{
		parent::setViewer("json");
		
		if( ! (($__id = Request::getInt("id")) > 0) || ! ElectionCandidatesModel::i()->getItem($__id, ["id"]))
			return false;
		
		ElectionCandidatesModel::i()->deleteItem($__id);
		
		return true;
	}
	
	public function jGetAgitation()
	{
		parent::setViewer("json");
		
		if( ! (($__id = Request::getInt("id")) > 0) || ! ($__item = AgitationsModel::i()->getItem($__id, [
			"id",
			"categories_ids",
			"name",
			"image",
			"file"
		])))
			return;
		
		if(Request::getInt("use_current_lang") == 1)
			$__item["name"] = $__item["name"][Router::getLang()];
		
		$this->json["item"] = $__item;
		
		return true;
	}
	
	public function jSaveAgitation()
	{
		parent::setViewer("json");
		
		$__data = array(
			"categories_ids" => Request::getArray("categories_ids"),
			"name" => Request::getString("name"),
			"description" => "",
			"image" => Request::getString("image"),
			"file" => Request::getString("file"),
			"is_hidden" => 1
		);
		
		foreach($__data as $__field => $__value)
		{
			if( ! is_string($__data[$__field]))
				continue;
			
			$__data[$__field] = str_replace("'", "\'", stripslashes($__value));
		}
		
		foreach(["name", "description"] as $__field)
		{
			$__value = $__data[$__field];
			foreach(Router::getLangs() as $__lang)
			{
				if( ! is_array($__data[$__field]))
					$__data[$__field] = [];
				
				$__data[$__field][$__lang] = $__value;
			}
		}
		
		if( ! (($__id = Request::getInt("id")) > 0) || ! AgitationsModel::i()->update(array_merge(["id" => $__id], $__data)))
			$__id = AgitationsModel::i()->insert($__data);
		
		$__item = AgitationsModel::i()->getItem($__id, ["id", "name", "categories_ids", "image", "file", "is_public"]);
			
		$__item["categories"] = [];
		foreach($__item["categories_ids"] as $__categoryId)
			$__item["categories"][] = AgitationsCategoriesModel::i()->getItem($__categoryId, ["name"])["name"][Router::getLang()];
		
		$this->json["item"] = $__item;
		
		return true;
	}
	
	public function jPublicateAgitation()
	{
		parent::setViewer("json");
		
		if( ! (($__id = Request::getInt("id")) > 0) || ! AgitationsModel::i()->update([
			"id" => $__id,
			"is_public" => Request::getInt("state")
		]))
			return false;
		
		return true;
	}
	
	public function jGetAgitationCategories()
	{
		parent::setViewer("json");
		
		$__options = [];
		
		if(($__isPublic = Request::getInt("is_public", -1)) != -1)
			$__options["is_public"] = $__isPublic;
		
		if(Request::getInt("use_current_lang") == 1)
			$__options["use_current_lang"] = 1;
		
		$this->json["list"] = $this->__getAgitationCategories($__options);;
		
		return true;
	}
	
	public function jDeleteAgitation()
	{
		parent::setViewer("json");
		
		if( ! (($__id = Request::getInt("id")) > 0))
			return false;
		
		AgitationsModel::i()->deleteItem($__id);
		
		return true;
	}
	
	public function jAddAgitationCategory()
	{
		parent::setViewer("json");
		
		$__data = array(
			"name" => Request::getString("name"),
			"in_election" => 1
		);
		
		foreach($__data as $__field => $__value)
		{
			if( ! is_string($__data[$__field]))
				continue;
			
			$__data[$__field] = str_replace("'", "\'", stripslashes($__value));
		}
		
		foreach(["name"] as $__field)
		{
			$__value = $__data[$__field];
			foreach(Router::getLangs() as $__lang)
			{
				if( ! is_array($__data[$__field]))
					$__data[$__field] = [];
				
				$__data[$__field][$__lang] = $__value;
			}
		}
		
		$this->json["item"] = AgitationsCategoriesModel::i()
				->getItem(AgitationsCategoriesModel::i()->insert($__data));
		
		return true;
	}
	
	public function jEditAgitationCategory()
	{
		parent::setViewer("json");
		
		if( ! (($__id = Request::getInt("id")) > 0) || ! AgitationsCategoriesModel::i()->getItem($__id, ["id"]))
			return false;
		
		$__data = array(
			"id" => $__id,
			"name" => Request::getString("name")
		);
		
		foreach(["name"] as $__field)
		{
			$__value = str_replace("'", "\'", stripslashes($__data[$__field]));
			foreach(Router::getLangs() as $__lang)
			{
				if( ! is_array($__data[$__field]))
					$__data[$__field] = [];
				
				$__data[$__field][$__lang] = $__value;
			}
		}
		
		AgitationsCategoriesModel::i()->update($__data);
		
		return true;
	}
	
	public function jPublicateAgitationCategory()
	{
		parent::setViewer("json");
		
		if( ! (($__id = Request::getInt("id")) > 0) || ! AgitationsCategoriesModel::i()->getItem($__id, ["id"]))
			return false;
		
		AgitationsCategoriesModel::i()->update([
			"id" => $__id,
			"is_public" => Request::getInt("state")
		]);
		
		return true;
	}
	
	public function jDeleteAgitationCategory()
	{
		parent::setViewer("json");
		
		if( ! (($__id = Request::getInt("id")) > 0) || ! AgitationsCategoriesModel::i()->getItem($__id, ["id"]))
			return false;
		
		AgitationsCategoriesModel::i()->deleteItem($__id);
		
		return true;
	}
	
	public function jSaveOpponent()
	{
		parent::setViewer("json");
		
		$__data = [
			"type" => Request::getInt("type"),
			"symlink_avatar" => Request::getString("symlink_avatar"),
			"name" => Request::getString("name"),
			"appointment" => Request::getString("appointment"),
			"description" => Request::getString("description")
		];
		
		if( ! (($__id = Request::getInt("id")) > 0) || ! ElectionCandidatesOpponentsModel::i()->update(array_merge(["id" => $__id], $__data)))
			$__id = ElectionCandidatesOpponentsModel::i()->insert($__data);
		
		$this->json["item"] = ElectionCandidatesOpponentsModel::i()->getItem($__id);
		
		return true;
	}
	
	public function jGetOpponent()
	{
		parent::setViewer("json");
		
		if( ! (($__id = Request::getInt("id")) > 0) || ! ($__item = ElectionCandidatesOpponentsModel::i()->getItem($__id)))
			return false;
		
		$this->json["item"] = $__item;
		
		return true;
	}
	
	public function jUpdateOpponentState()
	{
		parent::setViewer("json");
		
		$__data = [
			Request::getString("field") => Request::getInt("state")
		];
		
		if( ! (($__id = Request::getInt("id")) > 0) || ! ElectionCandidatesOpponentsModel::i()->update(array_merge(["id" => $__id], $__data)))
			return false;
		
		return true;
	}
	
	public function jDeleteOpponent()
	{
		parent::setViewer("json");
		
		if( ! (($__id = Request::getInt("id")) > 0))
			return false;
		
		ElectionCandidatesOpponentsModel::i()->deleteItem($__id);
		
		return true;
	}
	
	public function export()
	{
		parent::setViewer(null);
		
		$__from = date("Y-m-d ", strtotime(Request::getString("from")))."00:00:00";
		$__to = date("Y-m-d ", strtotime(Request::getString("to")))."23:59:59";
		
		$__phpExcel = new PHPExcel();
		
		// Excel Properties
		$__phpExcelProperties = $__phpExcel->getProperties();
		$__phpExcelProperties->setCreator("Партія ВОЛЯ");
		$__phpExcelProperties->setLastModifiedBy($__phpExcelProperties->getCreator());
		$__phpExcelProperties->setTitle("Список волонтерів");
		$__phpExcelProperties->setSubject($__phpExcelProperties->getTitle());
		$__phpExcelProperties->setDescription($__phpExcelProperties->getTitle());
		
		// Excel Sheet 0
		$__helperTypes = [
			2 => "Агітатор",
			3 => "Член виборчої комісії",
			4 => "Спостерігачі"
		];
		
		$__phpExcelSheet = $__phpExcel->getSheet(0);
		$__phpExcelSheet->setTitle("Готові допомогти на виборах");
		
		$__sql = "SELECT `u`.`id`, `u`.`login`, `u`.`first_name`, `u`.`last_name`, "
				. "`u`.`middle_name`, `u`.`geo_koatuu_code`, `u`.`helper_type`, "
				. "`u`.`county_number`, `u`.`polling_place_number` "
				. "FROM `users` AS `u` "
				. "WHERE `u`.`type` = 2 AND `u`.`helper_type` > 1 AND `u`.`created_at` >= '".$__from."' AND `u`.`created_at` <= '".$__to."' "
				. "ORDER BY `u`.`helper_type` ASC";
		
		$__users = UsersModel::getRows($__sql);
		
		$__rowIndex = 1;
		foreach($__helperTypes as $__helpertType => $__helpertTypeTitle)
		{
			$__flag = false;
			foreach($__users as $__volunteer)
			{
				if($__volunteer["helper_type"] != $__helpertType)
					continue;
				
				$__flag = true;
			}
			
			if( ! $__flag)
				continue;
			
			$__cellIndex = "A".$__rowIndex.":H".$__rowIndex;
			
			$__phpExcelSheet->getRowDimension($__rowIndex)->setRowHeight(30);
			
			$__phpExcelSheetStyle = $__phpExcelSheet->mergeCells($__cellIndex)
					->getStyle($__cellIndex);
			
			$__phpExcelSheetStyle->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$__phpExcelSheetStyle->getAlignment()
					->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			$__phpExcelSheetStyle->getFont()
					->setBold(true);
			
			$__phpExcelSheet->setCellValue("A".$__rowIndex, $__helpertTypeTitle);
			
			$__rowIndex++;
			
			$__phpExcelSheet->setCellValue("A".$__rowIndex, "ID");
			$__phpExcelSheet->setCellValue("B".$__rowIndex, "Ім'я та прізвище");
			$__phpExcelSheet->setCellValue("C".$__rowIndex, "Область");
			$__phpExcelSheet->setCellValue("D".$__rowIndex, "Місто");
			$__phpExcelSheet->setCellValue("E".$__rowIndex, "Ел. пошта");
			$__phpExcelSheet->setCellValue("F".$__rowIndex, "Телефон");
			$__phpExcelSheet->setCellValue("G".$__rowIndex, "Номер округу");
			$__phpExcelSheet->setCellValue("H".$__rowIndex, "Номер дільниці");
			foreach(range("A", "H") as $__colIndex)
			{
				$__phpExcelSheetStyle = $__phpExcelSheet->getStyle($__colIndex.$__rowIndex);
				
				$__phpExcelSheetStyle->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$__phpExcelSheetStyle->getFont()
						->setBold(true);
			}
				
			$__rowIndex++;
			
			foreach($__users as $__volunteer)
			{
				if($__volunteer["helper_type"] != $__helpertType)
					continue;
				
				$__phpExcelSheet->setCellValue("A".$__rowIndex, $__volunteer["id"]);
				$__phpExcelSheet->setCellValue("B".$__rowIndex, UserClass::getNameByItem($__volunteer));
				
				$__geo = OldGeoClass::i()->getCity($__volunteer["geo_koatuu_code"]);
				$__phpExcelSheet->setCellValue("C".$__rowIndex,
						isset($__geo["region"])
						? $__geo["region"]
						: "-");
				$__phpExcelSheet->setCellValue("D".$__rowIndex,
						isset($__geo["title"])
						? $__geo["title"]
						: "-");
				
				$__phpExcelSheet->setCellValue("E".$__rowIndex, $__volunteer["login"]);
				$__phpExcelSheet->getCell("E".$__rowIndex)
						->getHyperlink()
						->setUrl("mailto:".$__volunteer["login"]);
				
				$__contacts = UserClass::i($__volunteer["id"])->getContacts("phone");
				$__phpExcelSheet->setCellValue("F".$__rowIndex,
						count($__contacts) > 0 && $__contacts[0] != "+38"
						? $__contacts[0]
						: "-");
				
				$__phpExcelSheet->setCellValue("G".$__rowIndex,
						! is_null($__volunteer["county_number"])
						? $__volunteer["county_number"]
						: "-");
				
				$__phpExcelSheet->setCellValue("H".$__rowIndex,
						! is_null($__volunteer["polling_place_number"])
						? $__volunteer["polling_place_number"]
						: "-");
				
				foreach(["E", "F", "G", "H"] as $__colIndex)
				{
					$__phpExcelSheetStyle = $__phpExcelSheet->getStyle($__colIndex.$__rowIndex);
					$__phpExcelSheetStyle->getAlignment()
							->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					if($__colIndex == "E")
					{
						$__phpExcelSheetStyle->getFont()
								->setColor((new PHPExcel_Style_Color())->setRGB("0181C5"));

						$__phpExcelSheetStyle->getFont()
								->setUnderline(true);
					}
				}
				
				$__rowIndex++;
			}
			
			$__rowIndex++;
		}
		
		foreach(range("A", "H") as $__column)
			$__phpExcelSheet->getColumnDimension($__column)
				->setAutoSize(true);
		
		$__sql = "SELECT "
				. "`u`.`id`, "
				. "`u`.`login`, "
				. "`u`.`first_name`, "
				. "`u`.`last_name`, "
				. "`u`.`middle_name`, "
				. "`u`.`helper_type`, "
				. "`u`.`i_want_to_be_a_helper`, "
				. "`ec`.`id` AS `c_id`, "
				. "`ec`.`symlink` AS `c_symlink`, "
				. "`ec`.`first_name` AS `c_first_name`, "
				. "`ec`.`last_name` AS `c_last_name`, "
				. "`ec`.`county_number`, "
				. "`ec`.`geo_koatuu_code` "
				. "FROM `users` AS `u` "
				. "RIGHT JOIN `election_candidates_supporters` AS `ecs` ON `ecs`.`user_id` = `u`.`id` "
				. "RIGHT JOIN `election_candidates` AS `ec` ON `ec`.`id` = `ecs`.`election_candidate_id` "
				. "WHERE `u`.`type` = 2 AND `u`.`helper_type` = 1 AND `u`.`created_at` >= '".$__from."' AND `u`.`created_at` <= '".$__to."' ";
		
		$__users = UsersModel::getRows($__sql);
		
		$__candidates = [];
		foreach($__users as $__user)
		{
			if( ! isset($__candidates[$__user["c_id"]]))
				$__candidates[$__user["c_id"]] = [
					"id" => $__user["c_id"],
					"symlink" => $__user["c_symlink"],
					"first_name" => $__user["c_first_name"],
					"last_name" => $__user["c_last_name"],
					"middle_name" => "",
					"county_number" => $__user["county_number"],
					"volunteers" => []
				];
			
			$__candidates[$__user["c_id"]]["name"] = UserClass::getNameByItem($__candidates[$__user["c_id"]]);
			
			$__geo = OldGeoClass::i()->getRegion($__user["geo_koatuu_code"]);
			$__candidates[$__user["c_id"]]["region"] = $__geo["title"];
			
			$__contacts = UserClass::i($__user["id"])->getContacts("phone");
			
			$__candidates[$__user["c_id"]]["volunteers"][] = [
				"id" => $__user["id"],
				"name" => UserClass::getNameByItem($__user),
				"email" => $__user["login"],
				"phone" => count($__contacts) > 0 && $__contacts[0] != "+38" 
					? $__contacts[0]
					: "-",
				"is_helper" => $__user["i_want_to_be_a_helper"]
			];
		}
		
		$__sheetIndex = 1;
		foreach($__candidates as $__candidate)
		{
			$__phpExcel->createSheet();
			$__phpExcelSheet = $__phpExcel->getSheet($__sheetIndex);
			$__phpExcelSheet->setTitle($__candidate["name"]);
			
			$__rowIndex = 1;
			
			$__cellIndex = "A".$__rowIndex.":E".$__rowIndex;
			
			$__phpExcelSheet->getRowDimension("1")->setRowHeight(40);
			
			$__phpExcelSheetStyle = $__phpExcelSheet->mergeCells($__cellIndex)
					->getStyle($__cellIndex);
			
			$__phpExcelSheetStyle->getFont()
					->setBold(true);
			
			$__phpExcelSheetStyle->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$__phpExcelSheetStyle->getAlignment()
					->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			
			$__phpExcelSheet->setCellValue("A".$__rowIndex, $__candidate["name"]." (".$__candidate["region"].", виборчий округ № ".$__candidate["county_number"].")");
			$__phpExcelSheet->getCell("A".$__rowIndex)
					->getHyperlink()
					->setUrl("http://volya.ua/election/candidates/".$__candidate["symlink"]);
			
			$__phpExcelSheetStyle->getFont()
					->setColor((new PHPExcel_Style_Color())->setRGB("0181C5"));

			$__phpExcelSheetStyle->getFont()
					->setUnderline(true);
			
			$__rowIndex++;
			
			$__phpExcelSheet->setCellValue("A".$__rowIndex, "ID");
			$__phpExcelSheet->setCellValue("B".$__rowIndex, "Ім'я та прізвище");
			$__phpExcelSheet->setCellValue("C".$__rowIndex, "Ел. пошта");
			$__phpExcelSheet->setCellValue("D".$__rowIndex, "Телефон");
			$__phpExcelSheet->setCellValue("E".$__rowIndex, "Готовий долучитися у якості волонтера, спостерігача або члена комісії");
			foreach(range("A", "E") as $__colIndex)
			{
				$__phpExcelSheet->getColumnDimension($__column)
					->setAutoSize(true);
				
				$__phpExcelSheetStyle = $__phpExcelSheet->getStyle($__colIndex.$__rowIndex);
				
				$__phpExcelSheetStyle->getAlignment()
						->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$__phpExcelSheetStyle->getAlignment()
						->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				$__phpExcelSheetStyle->getAlignment()
						->setWrapText(true);
				
				$__phpExcelSheetStyle->getFont()
						->setBold(true);
			}
			$__phpExcelSheet->getColumnDimension("E")->setWidth(18);
			$__rowIndex++;
			
			foreach($__candidate["volunteers"] as $__volunteer)
			{
				$__phpExcelSheet->setCellValue("A".$__rowIndex, $__volunteer["id"]);
				$__phpExcelSheet->setCellValue("B".$__rowIndex, $__volunteer["name"]);
				
				$__phpExcelSheet->setCellValue("C".$__rowIndex, $__volunteer["email"]);
				$__phpExcelSheet->getCell("C".$__rowIndex)
						->getHyperlink()
						->setUrl("mailto:".$__volunteer["email"]);
				
				$__phpExcelSheet->setCellValue("D".$__rowIndex, $__volunteer["phone"]);
				$__phpExcelSheet->setCellValue("E".$__rowIndex,
						$__volunteer["is_helper"]
						? "Так"
						: "Ні");
				
				foreach(range("A", "E") as $__colIndex)
				{
					$__phpExcelSheetStyle = $__phpExcelSheet->getStyle($__colIndex.$__rowIndex);
					
					if($__colIndex != "E")
						$__phpExcelSheet->getColumnDimension($__colIndex)
								->setAutoSize(true);
					
					if($__colIndex != "B")
						$__phpExcelSheetStyle->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					
					if($__colIndex == "C")
					{
						$__phpExcelSheetStyle->getFont()
								->setColor((new PHPExcel_Style_Color())->setRGB("0181C5"));

						$__phpExcelSheetStyle->getFont()
								->setUnderline(true);
					}
				}
				
				$__rowIndex++;
			}
			
			$__sheetIndex++;
		}
		
		// Excel Writer
		header("Content-Type: application/vnd.ms-excel");
		
		$__filename = date("d.m.Y", strtotime($__from));
		if(($__toStr = date("d.m.Y", strtotime($__to))) != $__filename)
			$__filename .= " - ".$__toStr;
		header("Content-Disposition: attachment;filename=\"Export ".$__filename.".xls\"");
		
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header("Cache-Control: max-age=1");

		// If you're serving to IE over SSL, then the following may be needed
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); // always modified
		header("Cache-Control: cache, must-revalidate"); // HTTP/1.1
		header("Pragma: public");
		
		$__phpExcelWriter = PHPExcel_IOFactory::createWriter($__phpExcel, "Excel2007");
		$__phpExcelWriter->save("php://output");
	}
	
	private function __ERGetData()
	{
		$__exitpolls = [];
		foreach(ElectionExitpollsModel::i()->getList() as $__id)
			$__exitpolls[] = ElectionExitpollsModel::i()->getItem($__id, ["id", "name", "is_public"]);
		
		$__parties = [];
		foreach(ElectionPartiesModel::i()->getList() as $__id)
			$__parties[] = ElectionPartiesModel::i()->getItem($__id, ["id", "name"]);
		
		$__results = [];
		foreach(ElectionPartiesExitpollsResultsModel::i()->getList() as $__id)
		{
			$__item = ElectionPartiesExitpollsResultsModel::i()->getItem($__id);
			$__results[$__item["election_exitpoll_id"]."x".$__item["election_party_id"]] = $__item["value"];
		}
		
		return [
			"exitpolls" => $__exitpolls,
			"parties" => $__parties,
			"results" => $__results
		];
	}
	
	public function exitpollsResults()
	{
		$this->__init();
		
		parent::loadWindow([
			"admin/election/exitpolls_results/exitpoll_form",
			"admin/election/exitpolls_results/party_form"
		]);
		
		HeadClass::addJs("/js/frontend/admin/election/exitpolls_results.js");
		HeadClass::addLess("/less/frontend/admin/election/exitpolls_results.less");
		
		$this->data = $this->__ERGetData();
	}
	
	public function jErSaveExitpoll()
	{
		parent::setViewer("json");
		
		$__id = Request::getInt("id");
		
		$__data = [
			"name" => stripslashes(Request::getString("name"))
		];
		
		if( ! ($__id > 0) || ! ElectionExitpollsModel::i()->update(array_merge(["id" => $__id], $__data)))
		{
			$__id = ElectionExitpollsModel::i()->insert($__data);
			
			foreach(ElectionPartiesModel::i()->getList() as $__electionPartyId)
				ElectionPartiesExitpollsResultsModel::i()->insert([
					"election_party_id" => $__electionPartyId,
					"election_exitpoll_id" => $__id,
					"value" => 0
				]);
		}
		
		$this->json["data"] = $this->__ERGetData();
		
		return true;
	}
	
	public function jErSetExitpollState()
	{
		parent::setViewer("json");
		
		$__data = [
			"id" => Request::getInt("id"),
			"is_public" => Request::getInt("state")
		];
		
		if( ! ($__data["id"] > 0) || ! ElectionExitpollsModel::i()->update($__data))
			return false;
		
		return true;
	}
	
	public function jErSaveParty()
	{
		parent::setViewer("json");
		
		$__id = Request::getInt("id");
		
		$__data = [
			"name" => stripslashes(Request::getString("name"))
		];
		
		if( ! ($__id > 0) || ! ElectionPartiesModel::i()->update(array_merge(["id" => $__id], $__data)))
		{
			$__id = ElectionPartiesModel::i()->insert($__data);
			
			foreach(ElectionExitpollsModel::i()->getList() as $__electionExitpollId)
				ElectionPartiesExitpollsResultsModel::i()->insert([
					"election_party_id" => $__id,
					"election_exitpoll_id" => $__electionExitpollId,
					"value" => 0
				]);
		}
		
		$this->json["data"] = $this->__ERGetData();
		
		return true;
	}
	
	public function jErSetValue()
	{
		parent::setViewer("json");
		
		$__value = Request::getFloat("value");
		
		$__cond = [
			"election_exitpoll_id = :eeid",
			"election_party_id = :epid"
		];
		$__bind = [
			"eeid" => Request::getInt("eid"),
			"epid" => Request::getInt("pid")
		];
		
		foreach(ElectionPartiesExitpollsResultsModel::i()->getList($__cond, $__bind) as $__id)
			ElectionPartiesExitpollsResultsModel::i()->update([
				"id" => $__id,
				"value" => $__value
			]);
		
		$this->json["value"] = $__value;
		
		return true;
	}
}
