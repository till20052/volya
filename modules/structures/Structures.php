<?php

Loader::loadAppliaction("Frontend");

class StructuresController extends Frontend
{
	public static $structures;

	function __construct()
	{
		parent::__construct();
	}

	public function execute()
	{
		parent::execute();
		parent::addBreadcrumb("/structures", t("Осередки"));
	}
}
