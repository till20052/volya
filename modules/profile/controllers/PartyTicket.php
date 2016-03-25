<?php

Loader::loadModule("Profile");

Loader::loadClass("GeoClass");
Loader::loadClass("OldGeoClass");
Loader::loadClass("PHPExcel", Loader::SYSTEM);
Loader::loadClass("barcodegen.BCGFontFile", Loader::SYSTEM);
Loader::loadClass("barcodegen.BCGColor", Loader::SYSTEM);
Loader::loadClass("barcodegen.BCGDrawing", Loader::SYSTEM);
Loader::loadClass("barcodegen.BCGcode128_barcode", Loader::SYSTEM);

Loader::loadModel("UsersModel");
Loader::loadModel("UsersVerificationsModel");
Loader::loadModel("CellsMembersModel");
Loader::loadModel("UsersPartyTicketsModel");

class PartyTicketProfileController extends ProfileController
{
	public function execute($args = [])
	{
		parent::setViewer(null);

		ob_start();

		$__user = UsersModel::i()->getItem($args[0]);

		$__decision = ["number" => null, "date" => null];
		if(count(($__list = UsersVerificationsModel::i()->getList(["user_id = :uid"], ["uid" => $__user["id"]], ["id DESC"], 1))) > 0)
		{
			$__uvId = $__list[0];
			$__uvItem = UsersVerificationsModel::i()->getItem($__uvId);
			$__decision["number"] = $__uvItem["decision_number"];
			$__decision["date"] = date("d.m.Y", strtotime($__uvItem["created_at"]));
		}

		$__user["geo"] = OldGeoClass::i()->getCity($__user["geo_koatuu_code"]);

		if(count(($__list = CellsMembersModel::i()->getList(["user_id = :uid"], ["uid" => $__user["id"]], null, 1))) > 0)
			$__user["cell_id"] = $__list[0];


//		$__partyTicketNumber = 100000 + $__user["id"];
//		$__partyTicketNumber = "01/01/001/".str_pad($__user["id"], 4, 0, STR_PAD_LEFT);

		$__partyTicketNumber = substr($__user["geo"]["id"], 0, 2)."/";
		$__partyTicketNumber .= substr($__user["geo"]["id"], 3, 2)."/";
		if(isset($__user["cell_id"]))
			$__partyTicketNumber .= str_pad($__user["cell_id"], 3, 0, STR_PAD_LEFT)."/";
		$__partyTicketNumber .= str_pad($__user["id"], 4, 0, STR_PAD_LEFT);

		print eval("?>".file_get_contents(Router::getAppFolder().DS."data/templates/pdf/party_ticket.html"));
		header("Content-Type: text/html; charset=utf-8");
		echo ob_get_clean();
	}

	public function barCode($args = [])
	{
		if( ! isset($args[0]))
			$__string = 0;
		else
			$__string = $args[0];

		$__font = new BCGFontFile('Arial.ttf', 10);
		$__colorBlack = new BCGColor(0, 0, 0);
		$__colorWhite = new BCGColor(255, 255, 255);

		// Barcode Part
		$__code = new BCGcode128();
		$__code->setScale(1);
		$__code->setThickness(30);
		$__code->setForegroundColor($__colorBlack);
		$__code->setBackgroundColor($__colorWhite);
		$__code->setFont($__font);
		$__code->setStart(NULL);
		$__code->setTilde(true);
		$__code->parse($__string);

		// Drawing Part
		$drawing = new BCGDrawing('', $__colorWhite);
		$drawing->setBarcode($__code);
		$drawing->setDPI(300);
		$drawing->setRotationAngle(90);
		$drawing->draw();

		header('Content-Type: image/png');

		$drawing->finish(BCGDrawing::IMG_FORMAT_PNG, 100);
	}

	public function getPackage()
	{
		parent::setViewer("file");

		$__debugMode = Request::getInt("debug");

		$__phpExcel = new PHPExcel();

		$__phpExcelProperties = $__phpExcel->getProperties();
		$__phpExcelProperties->setCreator("Партія ВОЛЯ");
		$__phpExcelProperties->setLastModifiedBy($__phpExcelProperties->getCreator());
		$__phpExcelProperties->setTitle("База партійців");
		$__phpExcelProperties->setSubject($__phpExcelProperties->getTitle());
		$__phpExcelProperties->setDescription($__phpExcelProperties->getTitle());

		$__phpExcelSheet = $__phpExcel->getSheet(0);
		$__phpExcelSheet->setTitle($__phpExcelProperties->getTitle());


		$__columns = range("A", "G");
		foreach(["", "ПІП", "Location_1", "Location_2", "Номер посвідчення", "Дата", "Фото"] as $__i => $__field)
			$__phpExcelSheet->setCellValue($__columns[$__i]."1", $__field);

		$__cond = ["type = :type"];
		$__bind = ["type" => 100];

		$__i = 0;
		$__buffer = [];
		$__avatars = [];
		foreach(UsersModel::i()->getList($__cond, $__bind) as $__uid)
		{
			if(in_array($__uid, [
				// фильтрация от февраля
				239, 246, 322, 408, 518, 984, 990, 1004, 2906, 2993, 3033, 3407, 3853,
				// фильтрация от июня
				1008, 2436, 2488, 2493, 3767, 3778, 3847
			]))
				continue;

			$__uItem = UsersModel::i()->getItem($__uid, ["id", "first_name", "last_name", "middle_name", "geo_koatuu_code", "avatar"]);
			$__uvList = UsersVerificationsModel::i()->getList(["user_id = :uid", "type = :type"], [
				"uid" => $__uid,
				"type" => 10
			], ["created_at DESC"], 1);
			$__uptList = UsersPartyTicketsModel::i()->getList(["uid = :uid"], [
				"uid" => $__uid
			], [], 1);
			
			if(
				strlen($__uItem["geo_koatuu_code"]) != 10
				|| ! (count($__uvList) > 0)
//				|| strlen($__uItem["avatar"]) != 32
				|| count($__uptList) > 0
			)
				continue;


			$__TMPBuff = [];

			// SEQUENCE
			$__phpExcelSheet->setCellValue("A".($__i+2), ($__i+1));


			// NAME
			$__name = mb_strtoupper($__uItem["last_name"], "UTF8")." "
				.mb_strtoupper(mb_substr($__uItem["first_name"], 0, 1, "UTF8"), "UTF8").mb_strtolower(mb_substr($__uItem["first_name"], 1, null, "UTF8"), "UTF8");
			$__name .= ! empty($__uItem["middle_name"]) ? " ".mb_strtoupper(mb_substr($__uItem["middle_name"], 0, 1, "UTF8"), "UTF8").mb_strtolower(mb_substr($__uItem["middle_name"], 1, null, "UTF8"), "UTF8") : "";
			$__phpExcelSheet->setCellValue("B".($__i+2), $__name);
			$__TMPBuff['name'] = $__name;


			// LOCATION
			$__location1 = $__location2 = "";
			if(strlen($__uItem["geo_koatuu_code"]) == 10)
			{
				$__geo = GeoClass::i()->location($__uItem["geo_koatuu_code"]);

				$__location1 = isset($__geo['region']) ? $__geo['region']['title'] : '';

				if(isset($__geo['village']))
					$__location2 = $__geo['village']['title'];
				elseif(isset($__geo['urban_village']))
					$__location2 = $__geo['urban_village']['title'];
				elseif(isset($__geo['city']))
					$__location2 = $__geo['city']['title'];

				if(preg_match('/(80|85)[0-9]{8}/', $__uItem["geo_koatuu_code"]))
				{
					$__location1 = $__geo['city']['title'];
					if(isset($__geo['city_district']))
						$__location2 = $__geo['city_district']['title'];
				}
			}
			$__phpExcelSheet->setCellValue("C".($__i+2), $__location1);
			$__phpExcelSheet->setCellValue("D".($__i+2), $__location2);
			$__TMPBuff['location'] = [$__location1, $__location2];


			// PARTY TICKET NUMBER
			$__number = "";
			if(strlen($__uItem["geo_koatuu_code"]) == 10)
			{
				if(count(($__uptList = UsersPartyTicketsModel::i()->getList(["uid = :uid"], ["uid" => $__uid], ["created_at DESC"], 1))) > 0)
					$__number = UsersPartyTicketsModel::i()->getItem($__uptList[0])["number"];
				else
				{
					$__uptId = UsersPartyTicketsModel::i()->insert([
						"uid" => $__uid
					]);
					$__number = substr($__uItem["geo_koatuu_code"], 0, 2)."/";
					$__number .= substr($__uItem["geo_koatuu_code"], 3, 2)."/";
					$__number .= str_pad($__uptId, 4, 0, STR_PAD_LEFT);
					UsersPartyTicketsModel::i()->update([
						"id" => $__uptId,
						"number" => $__number
					]);
				}
			}
			$__phpExcelSheet->setCellValue("E".($__i+2), $__number);
			$__TMPBuff['number'] = $__number;


			// DATE
			$__uvItem = UsersVerificationsModel::i()->getItem($__uvList[0]);
			$__phpExcelSheet->setCellValue("F".($__i+2), date("d.m.Y", strtotime($__uvItem["created_at"])));
			$__TMPBuff['date'] = date("d.m.Y", strtotime($__uvItem["created_at"]));


			// PHOTO
			$__avatar = "";
			if(strlen($__uItem["avatar"]) == 32)
			{
				$__fname = "avatar_".$__uid.".jpg";
				$__url = "http://".$_SERVER["SERVER_NAME"]."/s/img/thumb/105x140/".$__uItem["avatar"];
				file_put_contents(Router::getAppFolder()."/data/temp/".$__fname, file_get_contents($__url));
				$__avatar = $__fname;
				$__avatars[] = $__fname;
			}
			$__phpExcelSheet->setCellValue("G".($__i+2), $__avatar);
			$__TMPBuff['avatar'] = $__avatar;

//			if($__debugMode)
//				Console::log($__location1, $__location2, "---");

			$__buffer[] = $__TMPBuff;
			$__i++;
		}

		if($__debugMode)
		{
			var_dump($__buffer);
			return;
		}

		foreach(range("A", "G") as $__column)
			$__phpExcelSheet->getColumnDimension($__column)
				->setAutoSize(true);

//		// Excel Writer
//		header("Content-Type: application/vnd.ms-excel");
//		header("Content-Disposition: attachment;filename=\"database.xls\"");
//
//		header('Cache-Control: max-age=0');
//		// If you're serving to IE 9, then the following may be needed
//		header("Cache-Control: max-age=1");
//
//		// If you're serving to IE over SSL, then the following may be needed
//		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
//		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); // always modified
//		header("Cache-Control: cache, must-revalidate"); // HTTP/1.1
//		header("Pragma: public");

		$__phpExcelWriter = PHPExcel_IOFactory::createWriter($__phpExcel, "Excel2007");
		$__phpExcelWriter->save(Router::getAppFolder()."/data/temp/database.xls");

		$__zip = new ZipArchive();

		if($__zip->open(Router::getAppFolder()."/data/temp/database.zip", ZIPARCHIVE::CREATE) !== true)
		{
			echo "Помилка";
			return;
		}

		foreach(array_merge(["database.xls"], $__avatars) as $__file)
			$__zip->addFile(Router::getAppFolder()."/data/temp/".$__file, $__file);

		$__zip->close();

		$this->fileName = Router::getAppFolder()."/data/temp/database.zip";
	}

	public function getRevPackage()
	{
		parent::setViewer("file");

		$__phpExcel = new PHPExcel();

		$__phpExcelProperties = $__phpExcel->getProperties();
		$__phpExcelProperties->setCreator("Партія ВОЛЯ");
		$__phpExcelProperties->setLastModifiedBy($__phpExcelProperties->getCreator());
		$__phpExcelProperties->setTitle("База проблемних партійців");
		$__phpExcelProperties->setSubject($__phpExcelProperties->getTitle());
		$__phpExcelProperties->setDescription($__phpExcelProperties->getTitle());

		$__phpExcelSheet = $__phpExcel->getSheet(0);
		$__phpExcelSheet->setTitle($__phpExcelProperties->getTitle());

		$__columns = range("A", "H");
		foreach(["", "ПІП", "Location_1", "Location_2", "Номер посвідчення", "Дата", "Фото", "Звернути увагу"] as $__i => $__field)
			$__phpExcelSheet->setCellValue($__columns[$__i]."1", $__field);

		$__cond = ["type = :type"];
		$__bind = ["type" => 100];

		$__i = 0;
		$__avatars = [];
		foreach(UsersModel::i()->getList($__cond, $__bind) as $__uid)
		{
			if(count(UsersPartyTicketsModel::i()->getList(["uid = :uid"], ["uid" => $__uid])) > 0)
				continue;

			$__comment = "";
			$__uItem = UsersModel::i()->getItem($__uid, ["id", "first_name", "last_name", "middle_name", "geo_koatuu_code", "avatar"]);
			$__uvList = UsersVerificationsModel::i()->getList(["user_id = :uid", "type = :type"], [
				"uid" => $__uid,
				"type" => 10
			], ["created_at DESC"], 1);


			// SEQUENCE
			$__phpExcelSheet->setCellValue("A".($__i+2), ($__i+1));


			// NAME
			$__name = mb_strtoupper($__uItem["last_name"], "UTF8")." "
				.mb_strtoupper(mb_substr($__uItem["first_name"], 0, 1, "UTF8"), "UTF8")
				.mb_strtolower(mb_substr($__uItem["first_name"], 1, null, "UTF8"), "UTF8");
			$__name .= ! empty($__uItem["middle_name"])
				? " ".mb_strtoupper(mb_substr($__uItem["middle_name"], 0, 1, "UTF8"), "UTF8")
					.mb_strtolower(mb_substr($__uItem["middle_name"], 1, null, "UTF8"), "UTF8")
				: "";
			$__phpExcelSheet->setCellValue("B".($__i+2), $__name);


			// LOCATION
			$__location1 = $__location2 = "";
			if(strlen($__uItem["geo_koatuu_code"]) == 10)
			{
				$__geo = GeoClass::i()->getCity($__uItem["geo_koatuu_code"]);
				if(in_array(substr($__geo["id"], 0, 2), ["80"]))
				{
					if(isset($__geo["region"]))
					{
						$__location1 = "м. ".$__geo["region"];
						$__location2 = $__geo["title"]." район";
					}
					else
						$__location1 = "м. ".$__geo["title"];
				}
				else
				{
					if(isset($__geo["region"]))
					{
						$__location1 = $__geo["region"];
						$__location2 = "м. ".$__geo["title"];
					}
					else
						$__location1 = $__geo["title"];
				}
			}
			else
				$__comment .= "Локація\r\n";
			$__phpExcelSheet->setCellValue("C".($__i+2), $__location1);
			$__phpExcelSheet->setCellValue("D".($__i+2), $__location2);


			// PARTY TICKET NUMBER
			$__phpExcelSheet->setCellValue("E".($__i+2), "---");


			// DATE OF PARTY MEMBER REGISTRATION
			$__createdAt = "---";
			if(count($__uvList) > 0)
				$__createdAt = UsersVerificationsModel::i()->getItem($__uvList[0])["created_at"];
			else
				$__comment .= "Членство\r\n";
			$__phpExcelSheet->setCellValue("F".($__i+2), date("d.m.Y", strtotime($__createdAt)));


			// PHOTO
			$__avatar = "---";
			if(strlen($__uItem["avatar"]) == 32)
			{
				$__fname = "avatar_".$__uid.".jpg";
				$__url = "http://".$_SERVER["SERVER_NAME"]."/s/img/thumb/105x140/".$__uItem["avatar"];
				file_put_contents(Router::getAppFolder()."/data/temp/".$__fname, file_get_contents($__url));
				$__avatar = $__fname;
				$__avatars[] = $__fname;
			}
			else
				$__comment .= "Фотографія\r\n";
			$__phpExcelSheet->setCellValue("G".($__i+2), $__avatar);


			// COMMENT
			$__phpExcelSheet->setCellValue("H".($__i+2), $__comment);

			$__i++;
		}

		foreach(range("A", "H") as $__column)
			$__phpExcelSheet->getColumnDimension($__column)
				->setAutoSize(true);

		$__phpExcelWriter = PHPExcel_IOFactory::createWriter($__phpExcel, "Excel2007");
		$__phpExcelWriter->save(Router::getAppFolder()."/data/temp/database.xls");

		$__zip = new ZipArchive();

		if($__zip->open(Router::getAppFolder()."/data/temp/database.zip", ZIPARCHIVE::CREATE) !== true)
		{
			echo "Помилка";
			return;
		}

		foreach(array_merge(["database.xls"], $__avatars) as $__file)
			$__zip->addFile(Router::getAppFolder()."/data/temp/".$__file, $__file);

		$__zip->close();

		$this->fileName = Router::getAppFolder()."/data/temp/database.zip";
	}
}
