<?php

Loader::loadAppliaction("Frontend");

class ApiController extends Frontend
{
	public function execute()
	{
		parent::setViewer("json");
	}
}
