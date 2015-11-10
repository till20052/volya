<?php

Loader::loadModule("Team");
Loader::loadModel("TeamModel");

class IndexTeamController extends TeamController
{
	public function execute()
	{
		parent::execute();
		parent::loadKendo(TRUE);
		
		HeadClass::addJs("/js/frontend/team/index.js");
		HeadClass::addCss("/css/frontend/team/index.css");
		
		$this->list = TeamModel::i()->getCompiledList(array("is_public = 1"), array(), array("priority ASC"));
	}
}
