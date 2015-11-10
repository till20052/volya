<?php

Loader::loadModule("Projects");

class CreateProjectsController extends ProjectsController
{
	public function execute()
	{
		parent::execute();
		parent::loadKendo(TRUE);
		
		HeadClass::addCss("/css/frontend/projects/create.css");
	}
}
