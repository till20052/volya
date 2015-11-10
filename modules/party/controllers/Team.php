<?php

Loader::loadModule("Party");
Loader::loadModel("TeamModel");

class TeamPartyController extends PartyController
{
	public function execute()
	{
		parent::execute();
		parent::loadKendo(true);
		
		HeadClass::addJs("/js/frontend/team/index.js");
		
//		HeadClass::addCss("/css/frontend/team/index.css");
		
		HeadClass::addLess([
			"/less/frontend/party/team.less"
		]);
		
		$this->menuClickable = true;
		
		$this->selected = "team";
		$this->list = TeamModel::i()->getCompiledList(array("is_public = 1"), array(), array("priority ASC"));
	}
}
