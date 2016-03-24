<?php

Loader::loadModule("Trainings");
Loader::loadClass("TrainingClass");
Loader::loadClass("EmailTemplateClass");
Loader::loadClass("OldGeoClass");

class MembersTrainingsController extends TrainingsController
{
	public function execute()
	{
		parent::execute();
		parent::setLayout(null);
	}
	
	public function jAddMember()
	{
		parent::setViewer("json");
		
		if(TrainingClass::i()->isTrainingMember(Request::getInt("training_id"), UserClass::i()->getId()))
			return false;
		
		$__data = array(
			"training_id" => Request::getInt("training_id"),
			"user_id" => UserClass::i()->getId()
		);
		
		TrainingsMembersModel::i()->insert($__data);
		
		$__street = "";
		if(UserClass::i()->get("street") != "")
			$__street .= "вул. ".UserClass::i()->get("street");
		
		if(UserClass::i()->get("house_number") != "")
			$__street .= ", буд. ".UserClass::i()->get("house_number");
		
		if(UserClass::i()->get("house_number") != "")
			$__street .= ", кв. ".UserClass::i()->get("apartment_number");
		
		EmailTemplateClass::i()->send("trainings.members.j_add_member[0]", "oseredky@volya.ua", array(
			"first_name" => UserClass::i()->get("first_name"),
			"last_name" => UserClass::i()->get("last_name"),
			"phone" => (($__phone = UserClass::i()->getContacts("phone")) && count($__phone) > 0) ? $__phone[0] : "",
			"email" => (($__email = UserClass::i()->getContacts("email")) && count($__email) > 0) ? $__email[0] : "",
			"address" => $__street,
			"city" => OldGeoClass::i()->getRegionById(UserClass::i()->get("region_id"))["title"]." / ".OldGeoClass::i()->getCityById(UserClass::i()->get("city_id"))["title"]
		));
		
		EmailTemplateClass::i()->send("trainings.members.j_add_member[1]", (count($__email) > 0) ? $__email[0] : UserClass::i()->get("login"));
		
		return true;
	}
}
