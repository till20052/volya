<?php

Loader::loadModule("S");
Loader::loadModel("PollingPlacesModel");
Loader::loadModel("CellsModel");
Loader::loadModel("CellsDocumentsModel");
Loader::loadModel("CellsMembersModel");
Loader::loadModel("CellsVerifiedModel");
Loader::loadModel("CellsPollingPlacesModel");
Loader::loadClass("OldGeoClass");
Loader::loadModel("roep.*");

class PollingPlacesSController extends SController
{
	public function execute()
	{
		parent::execute();
		parent::execute();
	}
	
	private function getAllPollingPlaces()
	{
		parent::execute();
		parent::setViewer(null);
		
		$__path = Router::getAppFolder().DS."static".DS."upload".DS."html";
		
		foreach(scandir($__path) as $__file)
		{
			if(in_array($__file, [".", ".."]))
				continue;
			
			$__command = "node ".Router::getAppFolder()."/scripts/nodejs/polling_places.js ".$__file;
		
			$__returnVar = 777;

			ob_start();
			passthru($__command, $__returnVar);
			$__output = ob_get_clean();

			if($__returnVar != 0)
				return;
			
			$__data = json_decode($__output, true);
			
			foreach($__data as $__item)
			{
				PollingPlacesModel::i()->insert(array(
					"number" => $__item["number"],
					"address" => $__item["address"],
					"borders" => $__item["borders"],
					"count_of_vouters" => $__item["count_of_vouters"]
				));
			}
			
			echo $__file." - OK<br />\n";
		}
	}
	
	public function parsePollingPlacesAddresses()
	{
		parent::setViewer(null);
		
		$__counter = 0;
		$__conditions = [
			"/(вул|бульв|пров|просп).(.*),\s(.*),\sм.(.*),\s(.*),\s([0-9]{5})/" => [
				"address" => ":1 :2, :4, :5, Україна",
				"convert" => [
					"вул" => "вулиця",
					"бульв" => "бульвар",
					"пров" => "провулок",
					"просп" => "проспект"
				]
			],
//			"/(вул|бульв|пров|просп).(.*),\s(.*),\s(смт|с).(.*),\s(.*)\sр-н,\s(.*)(|\sобл.),\s([0-9]{5})/"
		];
		
		foreach(array_slice(PollingPlacesModel::i()->getList([], [], ["id ASC"]), 0) as $__id)
		{
			$__item = PollingPlacesModel::i()->getItem($__id, ["id", "address"]);
			
			$__wasMatched = false;
			$__matches = array();
			
			foreach($__conditions as $__pattern => $__data)
			{
				if( ! preg_match($__pattern, $__item["address"], $__matches))
					continue;
				
				$__wasMatched = true;
				$__condition = $__data;
				
				break;
			}
			
			if( ! $__wasMatched)
				continue;
			
			$__address = $__condition["address"];
			
			foreach($__matches as $__index => $__token)
			{
				if(isset($__condition["convert"]) && isset($__condition["convert"][$__token]))
					$__token = $__condition["convert"][$__token];

				$__address = str_replace(":".$__index, $__token, $__address);
			}
			
			Console::log($__item["address"], $__address, ($__counter + 1));
			
			$__counter++;
		}
	}
	
	public function fillCountyNumber()
	{
		parent::execute();
		parent::setViewer(null);
		
		$__RPNumbers = [];
		
		foreach(RoepDistrictsModel::i()->getList() as $__RDId)
		{
			$__RDItem = RoepDistrictsModel::i()->getItem($__RDId, ["id", "number"]);
			
			foreach(RoepPlotsModel::i()->getList(["roep_district_id = :RDId"], ["RDId" => $__RDItem["id"]]) as $__RPId)
			{
				if( ! isset($__RPNumbers[$__RDItem["number"]]))
					$__RPNumbers[$__RDItem["number"]] = [];
				
				$__RPNumbers[$__RDItem["number"]][] = RoepPlotsModel::i()->getItem($__RPId, ["number"])["number"];
			}
		}
		
//		Console::log($__RPNumbers);
//		return;
		
		foreach(PollingPlacesModel::i()->getList(["county_number IS NULL OR county_number = 0"], [], [], 2500) as $__id)
		{
			$__item = PollingPlacesModel::i()->getItem($__id, ["id", "number"]);
			
			$__flag = false;
			foreach($__RPNumbers as $__countyNumber => $__PPNumbers)
			{
				if( ! in_array($__item["number"], $__PPNumbers))
					continue;
				
				PollingPlacesModel::i()->update([
					"id" => $__item["id"],
					"county_number" => mb_substr($__countyNumber, mb_strpos($__countyNumber, "№", 0, "UTF-8")+1, null, "UTF-8")
				]);
				
				$__flag = true;
				break;
			}
			
			Console::log($__item["id"]." - ".( ! $__flag ? "FAIL" : "OK"), str_repeat("-", 32));
		}
	}
	
	public function fillGeoKoatuuCode()
	{
		parent::execute();
		parent::setViewer(null);
		
		foreach(PollingPlacesModel::i()->getList() as $__id)
		{
			$__item = PollingPlacesModel::i()->getItem($__id, ["id", "number"]);
			
			PollingPlacesModel::i()->update([
				"id" => $__id,
				"geo_koatuu_code" => substr($__item["number"], 0, 2).str_repeat("0", 8)
			]);
		}
		
		Console::log("OK");
	}
	
	public function convCountyNumber()
	{
		parent::execute();
		parent::setViewer(null);
		
		foreach(PollingPlacesModel::i()->getList([], [], []) as $__id)
		{
			$__item = PollingPlacesModel::i()->getItem($__id, ["id", "number", "county_number"]);
			
			PollingPlacesModel::i()->update([
				"id" => $__id,
				"county_number" => mb_substr($__item["county_number"], mb_strpos($__item["county_number"], "№", 0, "UTF-8")+1, null, "UTF-8")
			]);
		}
		
		Console::log("OK");
	}
	
//	public function parsePollingPlacesAddresses()
//	{
//		parent::setViewer(null);
//		
//		$__cond = array("geo_koatuu_code LIKE 'Err%'");
//		
//		foreach(PollingPlacesModel::i()->getCompiledList($__cond, array(), array()) as $__item)
//		{
////			if($__item["geo_koatuu_code"] != "")
////				continue;
//			
//			$__tokens = explode(",", str_replace("\"", "", $__item["address"]));
//			
//			$__arraySliceOffset = 2;
//			
//			switch($__tokens[0])
//			{
//				case "ДЛОЗ Казка":
//				case "вул.Нікітіної":
//				case "Військове містечко №12":
//					$__arraySliceOffset = 1;
//					break;
//			}
//			
//			$__address = $__title = str_replace(array("с-ще "), "", implode(",", array_slice($__tokens, $__arraySliceOffset)));
//			
//			$__command = "nodejs ".Router::getAppFolder()."/scripts/nodejs/geocoder.js \"".$__address."\"";
//		
//			$__returnVar = 777;
//
//			ob_start();
//			passthru($__command, $__returnVar);
//			$__output = ob_get_clean();
//			
//			if($__returnVar != 0)
//			{
//				Console::log("ERROR", $__command, $__returnVar, "-----------------------");
//				PollingPlacesModel::i()->update(array(
//					"id" => $__item["id"],
//					"geo_koatuu_code" => "Err:01"
//				));
//				continue;
//			}
//			
//			$__data = json_decode($__output, true);
//			
//			if(intval($__data["success"]) != 1 || ! isset($__data["locality"]["city"]))
//			{
//				Console::log("ERROR", $__item["address"], $__address, $__data, "-----------------------");
//				PollingPlacesModel::i()->update(array(
//					"id" => $__item["id"],
//					"geo_koatuu_code" => "Err:02"
//				));
//				continue;
//			}
//			
//			$__title = $__data["locality"]["city"];
//			if(isset($__data["locality"]["city_area"]) && mb_strpos(mb_strtolower($__data["locality"]["city_area"], "UTF-8"), " мікрорайон", 0, "UTF-8") === false)
//				$__title = $__data["locality"]["city_area"];
//			
//			$__title = str_replace(array(" район", "село ", "селище ", "міського типу "), "", $__title);
//			
//			Console::log($__title);
//			
//			$__finishCity = array(
//				"id" => "Err:03"
//			);
//			
//			if(($__cities = OldGeoClass::i()->findCities($__title, null, $__data["locality"]["region"])) && count($__cities) > 0)
//				$__finishCity = $__cities[0];
//			
//			Console::log($__item["address"], $__data, $__title, $__finishCity, "-----------------------");
//			
//			PollingPlacesModel::i()->update(array(
//				"id" => $__item["id"],
//				"geo_koatuu_code" => $__finishCity["id"]
//			));
//			
//			usleep(1000);
//		}
//	}
	
//	public function groupPollingPlaces()
//	{
//		parent::setViewer(null);
//		
//		$__sql = "SELECT `geo_koatuu_code` "
//				."FROM `polling_places` "
//				."WHERE `geo_koatuu_code` != '' "
//				."AND `geo_koatuu_code` NOT LIKE 'Err%' "
//				."GROUP BY `geo_koatuu_code`";
//		
//		foreach(PollingPlacesModel::i()->getRows($__sql) as $__row)
//		{
//			$__geoKoatuuCode = $__row["geo_koatuu_code"];
//			
//			$__cell = array(
//				"geo_koatuu_code" => $__geoKoatuuCode,
//				"polling_places" => array(),
//				"count_of_vouters" => 0
//			);
//			
//			foreach(PollingPlacesModel::i()->getListByField("geo_koatuu_code", $__geoKoatuuCode) as $__id)
//			{
//				$__pollingPlace = PollingPlacesModel::i()->getItem($__id, array(
//					"id",
//					"geo_koatuu_code",
//					"count_of_vouters"
//				));
//				
//				$__cell["count_of_vouters"] += $__pollingPlace["count_of_vouters"];
//				$__cell["polling_places"][] = $__pollingPlace["id"];
//				
//				if($__cell["count_of_vouters"] >= 3000)
//				{
//					$__cellId = CellsModel::i()->insert(array(
//						"geo_koatuu_code" => $__cell["geo_koatuu_code"]
//					));
//					
//					foreach($__cell["polling_places"] as $__pollingPlaceId)
//					{
//						CellsPollingPlacesModel::i()->insert(array(
//							"cell_id" => $__cellId,
//							"polling_place_id" => $__pollingPlaceId
//						));
//					}
//					
//					$__cell["count_of_vouters"] = 0;
//					$__cell["polling_places"] = array();
//				}
//			}
//			
//			if($__cell["count_of_vouters"] < 3000)
//			{
//				$__cellId = CellsModel::i()->insert(array(
//					"geo_koatuu_code" => $__cell["geo_koatuu_code"]
//				));
//
//				foreach($__cell["polling_places"] as $__pollingPlaceId)
//				{
//					CellsPollingPlacesModel::i()->insert(array(
//						"cell_id" => $__cellId,
//						"polling_place_id" => $__pollingPlaceId
//					));
//				}
//			}
//		}
//	}
	
//	public function convertOldCells()
//	{
//		parent::setViewer(null);
//		
//		foreach(CellsModel::i()->getList(array("roep_plot_id != 0")) as $__oldCellId)
//		{
//			$__oldCell = CellsModel::i()->getItem($__oldCellId, array("id", "roep_plot_id", "user_creator_id"));
//			$__roepPlot = RoepPlotsModel::i()->getItem($__oldCell["roep_plot_id"], array("number"));
//			$__pollingPlace = PollingPlacesModel::i()->getItemByField("number", $__roepPlot["number"]);
//			$__cellPollingPlace = CellsPollingPlacesModel::i()->getItemByField("polling_place_id", $__pollingPlace["id"]);
//			
//			$__newCellId = $__cellPollingPlace["cell_id"];
//			
//			CellsModel::i()->update(array(
//				"id" => $__newCellId,
//				"user_creator_id" => $__oldCell["user_creator_id"]
//			));
//			
//			foreach(CellsMembersModel::i()->getListByField("cell_id", $__oldCellId) as $__cellMemberId)
//			{
//				CellsMembersModel::i()->update(array(
//					"id" => $__cellMemberId,
//					"cell_id" => $__newCellId
//				));
//			}
//			
//			foreach(CellsDocumentsModel::i()->getListByField("cell_id", $__oldCellId) as $__cellDocumentId)
//			{
//				CellsDocumentsModel::i()->update(array(
//					"id" => $__cellDocumentId,
//					"cell_id" => $__newCellId
//				));
//			}
//			
//			foreach(CellsVerifiedModel::i()->getListByField("cell_id", $__oldCellId) as $__cellVerifiedId)
//			{
//				CellsVerifiedModel::i()->update(array(
//					"id" => $__cellVerifiedId,
//					"cell_id" => $__newCellId
//				));
//			}
//		}
//	}
}
