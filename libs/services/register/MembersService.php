<?php

namespace libs\services\register;

\Loader::loadModel("register.members.VerificationModel");
\Loader::loadModel("register.members.ApprovesModel");
\Loader::loadModel("UsersModel");
\Loader::loadClass("GeoClass");
\Loader::loadClass("UserClass");

use libs\models\register\members\VerificationModel;
use libs\models\register\members\ApprovesModel;

class MembersService
{
	public function getMember($userId){
		if(
			! ($userId > 0)
			|| ! ($__user = \UsersModel::i()->getItem($userId))
		)
			return false;

		$__user["name"] = \UserClass::i($__user["id"])->getName("&ln &fn &mn");

		if( ! is_null($__user["geo_koatuu_code"]))
			$__user["locality"] = \GeoClass::i()->location($__user["geo_koatuu_code"])["location"];

		$__user["contacts"] = array(
			"email" => \UserClass::i($userId)->getContacts("email"),
			"phone" => \UserClass::i($userId)->getContacts("phone")
		);

		$__user["documents"] = \UserClass::i($userId)->getDocuments();

		$__verification = $this->getLastVerification($userId);
		if( ! is_null($__verification))
			$__verification["user_verifier"] = \UsersModel::i()->getItem($__verification["uvid"], array(
				"id",
				"first_name",
				"last_name",
				"middle_name",
				"avatar"
			));

		$__user["verification"] = $__verification;

		$__approve = $this->getLastApprove($userId);
		if( ! is_null($__approve))
			$__approve["user_approver"] = \UsersModel::i()->getItem($__approve["uaid"], array(
				"id",
				"first_name",
				"last_name",
				"middle_name",
				"avatar"
			));

		$__user["approve"] = $__approve;

		return $__user;
	}

	public function getLastVerification($userId)
	{
		if( ! $userId > 0)
			return false;

		$__cond = array("uid = :uid");
		$__bind = array(
			"uid" => $userId
		);
		$__order = array("created_at DESC");

		foreach(VerificationModel::i()->getList($__cond, $__bind, $__order, 1) as $__id)
			return VerificationModel::i()->getItem($__id);

		return null;
	}

	public function getLastApprove($userId)
	{
		if( ! $userId > 0)
			return false;

		$__cond = array("uid = :uid");
		$__bind = array(
			"uid" => $userId
		);
		$__order = array("created_at DESC");

		foreach(ApprovesModel::i()->getList($__cond, $__bind, $__order, 1) as $__id)
			return ApprovesModel::i()->getItem($__id);

		return null;
	}

	public function setVerification($uid, $uvid, $type, $comment)
	{
		$__data = [
			"uid" => $uid,
			"uvid" => $uvid,
			"type" => $type,
			"comment" => $comment
		];

		VerificationModel::i()->insert($__data);
	}

	public function setApprove($uid, $uaid, $did, $type, $comment)
	{
		$__data = [
			"uid" => $uid,
			"uaid" => $uaid,
			"did" => $did,
			"type" => $type,
			"comment" => $comment
		];

		ApprovesModel::i()->insert($__data);

		\UsersModel::i()->update(["id" => $uid, "type" => $type == 1 ? 100 : 50]);
	}
}