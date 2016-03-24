<?php

Loader::loadModule("S");

Loader::loadClass("UserClass");
Loader::loadClass("OldGeoClass");
Loader::loadClass("Mailchimp");

Loader::loadModel("UsersModel");

class MailchimpSController extends SController
{
	private $__mailchimpApiKey = "cb3ff21405ae5e0cff8684085c3e111a-us9";
	
	public function execute()
	{
		parent::execute();
		parent::setViewer(null);
		
		$__mailchimp = new Mailchimp($this->__mailchimpApiKey);
		$__batch = [];
		
		foreach(UsersModel::i()->getList([], [], []) as $__id)
		{
			$__user = UsersModel::i()->getItem($__id, [
				"login AS email",
				"type AS status",
				"first_name",
				"last_name",
				"geo_koatuu_code AS locality"
			]);

			$__userVerification = UsersVerificationsModel::i()->getRows("SELECT created_at FROM users_verifications WHERE user_id = :user_id AND type = 10 ORDER BY created_at DESC LIMIT 1", ["user_id" => $__id]);
			$__approveDate = "";

			if(isset($__userVerification[0]))
				$__approveDate = date('m/d/Y', strtotime($__userVerification[0]["created_at"]));
			
			if(in_array($__user["email"], ["svroslov@gmal.com"]))
				continue;
			
			$__user["status"] = UserClass::getType($__user["status"])["text"];
			$__user["locality"] = OldGeoClass::i()->getRegion($__user["locality"])["title"];
			
			$__batch[] = array(
				"email" => ["email" => strtolower($__user["email"])],
				"merge_vars" => [
					"EMAIL" => strtolower($__user["email"]),
					"FNAME" => $__user["first_name"],
					"LNAME" => $__user["last_name"],
					"STATUS" => $__user["status"],
					"LOCALITY" => $__user["locality"],
					"APPROVEDAT" => $__approveDate
				]
			);
		}

		Console::log((new Mailchimp_Lists($__mailchimp))->batchSubscribe("3c8fda6f9e", $__batch, false, true, false));
	}
}
