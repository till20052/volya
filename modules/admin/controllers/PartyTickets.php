<?php

Loader::loadModule("Admin");

Loader::loadClass("GeoClass");

Loader::loadClass("PHPExcel", Loader::SYSTEM);
Loader::loadClass("barcodegen.BCGFontFile", Loader::SYSTEM);
Loader::loadClass("barcodegen.BCGColor", Loader::SYSTEM);
Loader::loadClass("barcodegen.BCGDrawing", Loader::SYSTEM);
Loader::loadClass("barcodegen.BCGcode128_barcode", Loader::SYSTEM);

Loader::loadModel("UsersModel");
Loader::loadModel("UsersVerificationsModel");
Loader::loadModel("CellsMembersModel");
Loader::loadModel("UsersPartyTicketsModel");

class PartyTicketsAdminController extends AdminController
{
	public static $modIsVisible = true;
	public static $modAText = "Партійні квитки";
	public static $modAHref = "/admin/party_tickets";
	public static $modImgSrc = "party_tickets";

	private function clearTemp()
	{
		parent::execute();

		$__photosDirPath = Router::getAppFolder()."/data/temp/photos";
		$__barcodesDirPath = Router::getAppFolder()."/data/temp/barcodes";

		$__photosDirHandle = opendir($__photosDirPath);
		$__barcodesDirHandle = opendir($__barcodesDirPath);

		while($__file = readdir($__photosDirHandle))
			if ($__file != '.' && $__file != '..')
				unlink($__photosDirPath . '/' . $__file);

		while($__file = readdir($__barcodesDirHandle))
			if ($__file != '.' && $__file != '..')
				unlink($__barcodesDirPath . '/' . $__file);

		rmdir($__photosDirPath);
		rmdir($__barcodesDirPath);

		unlink(Router::getAppFolder()."/data/temp/database.xls");

		return true;
	}

	public function execute()
	{
		parent::execute();
		parent::setView("party_tickets");
		parent::loadAngular(true);

		HeadClass::addJs([
			"/angular/js/app/modules/party_tickets/index/services/partyTicketsService.js",

			"/angular/js/app/modules/party_tickets/index/controllers/partyTicketsIndexController.js"
		]);

		HeadClass::addLess([
			"/less/frontend/admin/party_tickets.less"
		]);
	}

	public function getUsersList($args = [])
	{
		parent::execute();
		parent::setViewer("json");

		$this->json["users"] = [];

		foreach (UsersModel::i()->getList(["type = :type"], ["type" => 100]) as $__uid) {

			if(
				UsersVerificationsModel::i()->getList(["user_id = :uid", "type = :type"], [
					"uid" => $__uid,
					"type" => 10
				], ["created_at DESC"], 1)
			)
			{

				if(isset($args[0])) {

					if ($args[0] == "new")
						if (UsersPartyTicketsModel::i()->getList(["uid = :uid"], ["uid" => $__uid], [], 1))
							continue;

					if ($args[0] == "generated")
						if ( ! UsersPartyTicketsModel::i()->getList(["uid = :uid"], ["uid" => $__uid], [], 1))
							continue;
				}

				$this->json["users"][] = UsersModel::i()->getItem($__uid, ["id", "avatar", "first_name", "last_name", "geo_koatuu_code"]);
			}
		}
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

	public function generateUsersList()
	{
		parent::execute();
		parent::setViewer("json");

		$__phpExcel = new PHPExcel();

		$__phpExcelProperties = $__phpExcel->getProperties();
		$__phpExcelProperties->setCreator("Партія ВОЛЯ");
		$__phpExcelProperties->setLastModifiedBy($__phpExcelProperties->getCreator());
		$__phpExcelProperties->setTitle("Список членів");
		$__phpExcelProperties->setSubject($__phpExcelProperties->getTitle());
		$__phpExcelProperties->setDescription($__phpExcelProperties->getTitle());

		$__phpExcelSheet = $__phpExcel->getSheet(0);
		$__phpExcelSheet->setTitle($__phpExcelProperties->getTitle());

		$__columns = range("A", "G");
		foreach(["", "ПІП", "Населений пункт", "Номер посвідчення", "Дата", "Фото", "Штрихкод"] as $__i => $__field)
			$__phpExcelSheet->setCellValue($__columns[$__i]."1", $__field);

		$__i = 0;

		foreach(Request::getArray("usersList") as $__uid) {

			$__user = UsersModel::i()->getItem($__uid,
				[
					"avatar",
					"geo_koatuu_code",

					"first_name",
					"last_name",
					"middle_name"
				]
			);

			// SEQUENCE
			$__phpExcelSheet->setCellValue("A".($__i + 2), ($__i + 1));


			// NAME
			$__name = mb_strtoupper($__user["last_name"], "UTF8");
			$__name .= " " . mb_strtoupper(mb_substr($__user["first_name"], 0, 1, "UTF8"), "UTF8").mb_strtolower(mb_substr($__user["first_name"], 1, null, "UTF8"), "UTF8");
			$__name .= ! empty($__user["middle_name"]) ? " ".mb_strtoupper(mb_substr($__user["middle_name"], 0, 1, "UTF8"), "UTF8").mb_strtolower(mb_substr($__user["middle_name"], 1, null, "UTF8"), "UTF8") : "";

			$__phpExcelSheet->setCellValue("B".($__i + 2), $__name);


			// LOCATION
			$__location = "";
			if(strlen($__user["geo_koatuu_code"]) == 10)
				$__location = GeoClass::i()->location($__user["geo_koatuu_code"])["location"];

			$__phpExcelSheet->setCellValue("C".($__i + 2), $__location);


			// PARTY TICKET NUMBER
			$__number = "";
			if(strlen($__user["geo_koatuu_code"]) == 10)
			{
				if(count(($__uptList = UsersPartyTicketsModel::i()->getList(["uid = :uid"], ["uid" => $__user["id"]], ["created_at DESC"], 1))) > 0)
					$__number = UsersPartyTicketsModel::i()->getItem($__uptList[0])["number"];
				else
				{
					$__uptId = UsersPartyTicketsModel::i()->insert([
						"uid" => $__uid,
						"number" => $__number
					]);

					$__number = substr($__user["geo_koatuu_code"], 0, 2)."/";
					$__number .= substr($__user["geo_koatuu_code"], 3, 2)."/";
					$__number .= str_pad($__uptId, 4, 0, STR_PAD_LEFT);

					UsersPartyTicketsModel::i()->update([
						"id" => $__uptId,
						"number" => $__number
					]);
				}
			}

			$__phpExcelSheet->setCellValue("D".($__i + 2), $__number);


			// DATE
			$__uvItem = UsersVerificationsModel::i()->getItemByField("user_id", $__user["id"], ["created_at DESC"]);

			$__phpExcelSheet->setCellValue("E".($__i + 2), date("d.m.Y", strtotime($__uvItem["created_at"])));


			// PHOTO
			$__phpExcelSheet->setCellValue("F".($__i + 2), "avatar_" . $__uid . ".jpg");


			// BARCODE
			$__phpExcelSheet->setCellValue("G".($__i + 2), "barcode_" . $__uid . ".jpg");

			$__i++;
		}

		foreach(range("A", "G") as $__column)
			$__phpExcelSheet->getColumnDimension($__column)
				->setAutoSize(true);

		$__phpExcelWriter = PHPExcel_IOFactory::createWriter($__phpExcel, "Excel2007");
		$__phpExcelWriter->save(Router::getAppFolder()."/data/temp/database.xls");

		return true;
	}

	public function generatePhotos()
	{
		parent::execute();
		parent::setViewer("json");

		foreach(Request::getArray("usersList") as $__uid) {

			$__hash = UsersModel::i()->getItem($__uid, ["avatar"])["avatar"];

			// PHOTO
			if(strlen($__hash) == 32)
			{
				$__fname = "avatar_".$__uid.".jpg";

//				$__url = "http://" . $_SERVER["SERVER_NAME"] . "/s/img/thumb/105x140/" . $__hash;

				$__url = "http://volya.ua/s/img/thumb/105x140/" . $__hash;

				if( ! is_dir(Router::getAppFolder()."/data/temp/photos") ) {
					mkdir(Router::getAppFolder()."/data/temp/photos");
					chmod(Router::getAppFolder()."/data/temp/photos", 777);
				}

				file_put_contents(Router::getAppFolder()."/data/temp/photos/".$__fname, file_get_contents($__url));
			}
		}

		return true;
	}

	public function generateBarcodes()
	{
		parent::execute();
		parent::setViewer("json");

		foreach(Request::getArray("usersList") as $__uid) {

			$__fname = "barcode_".$__uid.".jpg";
			$__url = "http://".$_SERVER["SERVER_NAME"]."/admin/party_tickets/bar_code/".$__uid;

			if( ! is_dir(Router::getAppFolder()."/data/temp/barcodes") ) {
				mkdir(Router::getAppFolder()."/data/temp/barcodes");
				chmod(Router::getAppFolder()."/data/temp/barcodes", 777);
			}

			file_put_contents(Router::getAppFolder()."/data/temp/barcodes/".$__fname, file_get_contents($__url));
		}

		return true;
	}

	public function generateZip()
	{
		parent::execute();
		parent::setViewer("json");

		$__zip = new ZipArchive();
		$__zipName = "database.".substr(md5(microtime(true)), 0, 7).".zip";

		$__photosDirPath = Router::getAppFolder()."/data/temp/photos";
		$__barcodesDirPath = Router::getAppFolder()."/data/temp/barcodes";

		$__photosDirHandle = opendir($__photosDirPath);
		$__barcodesDirHandle = opendir($__barcodesDirPath);

		if($__zip->open(Router::getAppFolder()."/data/temp/".$__zipName , ZIPARCHIVE::CREATE) !== true)
			return false;

		$__zip->addEmptyDir('Photos');
		$__zip->addEmptyDir('BarCodes');

		while($__file = readdir($__photosDirHandle))
			if ($__file != '.' && $__file != '..')
				$__zip -> addFile($__photosDirPath . '/' . $__file, "Photos/" . $__file);

		while($__file = readdir($__barcodesDirHandle))
			if ($__file != '.' && $__file != '..')
				$__zip -> addFile($__barcodesDirPath . '/' . $__file, "BarCodes/" . $__file);

		$__zip->addFile(Router::getAppFolder()."/data/temp/database.xls", "database.xls");

		$__zip->close();

		$this->json["fileName"] = Router::getAppFolder()."/data/temp/".$__zipName;

		$this->clearTemp();

		return true;
	}

	public function generatePackage() {
		parent::execute();
		parent::setViewer("json");

		return Request::getArray("usersList");

		$__phpExcel = new PHPExcel();

		$__phpExcelProperties = $__phpExcel->getProperties();
		$__phpExcelProperties->setCreator("Партія ВОЛЯ");
		$__phpExcelProperties->setLastModifiedBy($__phpExcelProperties->getCreator());
		$__phpExcelProperties->setTitle("Список партійців");
		$__phpExcelProperties->setSubject($__phpExcelProperties->getTitle());
		$__phpExcelProperties->setDescription($__phpExcelProperties->getTitle());

		$__phpExcelSheet = $__phpExcel->getSheet(0);
		$__phpExcelSheet->setTitle($__phpExcelProperties->getTitle());

		$__columns = range("A", "G");
		foreach(["", "ПІП", "Населений пункт", "Номер посвідчення", "Дата", "Фото", "Штрихкод"] as $__i => $__field)
			$__phpExcelSheet->setCellValue($__columns[$__i]."1", $__field);

		$__i = 0;
		foreach(Request::getArray("usersList") as $__user)
		{
			$__TMPBuff = [];

			// SEQUENCE
			$__phpExcelSheet->setCellValue("A".($__i+2), ($__i+1));

			// NAME
			$__name = mb_strtoupper($__user["last_name"], "UTF8")." "
				.mb_strtoupper(mb_substr($__user["first_name"], 0, 1, "UTF8"), "UTF8").mb_strtolower(mb_substr($__user["first_name"], 1, null, "UTF8"), "UTF8");
			$__name .= ! empty($__user["middle_name"]) ? " ".mb_strtoupper(mb_substr($__user["middle_name"], 0, 1, "UTF8"), "UTF8").mb_strtolower(mb_substr($__user["middle_name"], 1, null, "UTF8"), "UTF8") : "";
			$__phpExcelSheet->setCellValue("B".($__i+2), $__name);
			$__TMPBuff['name'] = $__name;

			// LOCATION
			$__location = "";
			if(strlen($__user["geo_koatuu_code"]) == 10)
				$__location = GeoClass::i()->location($__user["geo_koatuu_code"]);

			$__phpExcelSheet->setCellValue("C".($__i+2), $__location["location"]);
			$__TMPBuff['location'] = $__location["location"];

			// PARTY TICKET NUMBER
			$__number = "";
			if(strlen($__user["geo_koatuu_code"]) == 10)
			{
				if(count(($__uptList = UsersPartyTicketsModel::i()->getList(["uid = :uid"], ["uid" => $__user["id"]], ["created_at DESC"], 1))) > 0)
					$__number = UsersPartyTicketsModel::i()->getItem($__uptList[0])["number"];
				else
				{
					$__uptId = UsersPartyTicketsModel::i()->insert([
						"uid" => $__user["id"]
					]);
					$__number = substr($__user["geo_koatuu_code"], 0, 2)."/";
					$__number .= substr($__user["geo_koatuu_code"], 3, 2)."/";
					$__number .= str_pad($__uptId, 4, 0, STR_PAD_LEFT);
					UsersPartyTicketsModel::i()->update([
						"id" => $__uptId,
						"number" => $__number
					]);
				}
			}
			$__phpExcelSheet->setCellValue("D".($__i+2), $__number);
			$__TMPBuff['number'] = $__number;

			// DATE
			$__uvItem = UsersVerificationsModel::i()->getItemByField("user_id", $__user["id"], ["created_at DESC"]);
			$__phpExcelSheet->setCellValue("E".($__i+2), date("d.m.Y", strtotime($__uvItem["created_at"])));
			$__TMPBuff['date'] = date("d.m.Y", strtotime($__uvItem["created_at"]));

			// PHOTO
			$__avatar = "";
			if(strlen($__user["avatar"]) == 32)
			{
				$__fname = "avatar_".$__user["id"].".jpg";
				$__url = "http://".$_SERVER["SERVER_NAME"]."/s/img/thumb/105x140/".$__user["avatar"];
				$__url = "http://volya.ua/s/img/thumb/105x140/".$__user["avatar"];
				file_put_contents(Router::getAppFolder()."/data/temp/".$__fname, file_get_contents($__url));
				$__avatar = $__fname;
				$__avatars[] = $__avatar;
			}
			$__phpExcelSheet->setCellValue("F".($__i+2), $__avatar);
			$__TMPBuff['avatar'] = $__avatar;

			// BARCODE
			$__barcode = "";
			$__fname = "barcode_".$__user["id"].".jpg";
			$__url = "http://".$_SERVER["SERVER_NAME"]."/admin/party_tickets/bar_code/".$__user["id"];
			file_put_contents(Router::getAppFolder()."/data/temp/".$__fname, file_get_contents($__url));
			$__barcode = $__fname;
			$__barcodes[] = $__fname;

			$__phpExcelSheet->setCellValue("G".($__i+2), $__barcode);
			$__TMPBuff['barcode'] = $__barcode;

			$__buffer[] = $__TMPBuff;
			$__i++;
		}

		foreach(range("A", "H") as $__column)
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
		$__zipName = "database.".substr(md5(microtime(true)), 0, 7).".zip";

		if($__zip->open(Router::getAppFolder()."/data/temp/".$__zipName , ZIPARCHIVE::CREATE) !== true)
		{
			echo "Помилка";
			return;
		}

		$__files = array_merge(["database.xls"], $__avatars, $__barcodes);

		$this->json["files"] = $__files;

		foreach($__files as $__file)
			$__zip->addFile(Router::getAppFolder()."/data/temp/".$__file, $__file);

		$__zip->close();

		foreach($__files as $__file)
			unlink( Router::getAppFolder()."/data/temp/".$__file );

		$this->json["fileName"] = Router::getAppFolder()."/data/temp/".$__zipName;
	}

	public function downloadPackage() {
		parent::setViewer("file");

		header('Content-Disposition: attachment; filename=' . basename(Request::getString("file")));

		$this->fileName = Request::getString("file");
	}
}
