<?php

Loader::loadAppliaction("Frontend");
Loader::loadService("StructuresService", Loader::APPLICATION);

use \libs\services\StructuresService;

class StructuresController extends Frontend
{
	public static $structures;

	public function execute()
	{
		parent::execute();

		self::$structures = new StructuresService();

		parent::addBreadcrumb("/structures", t("Осередки"));
	}
}
