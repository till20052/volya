<?php

Loader::loadClass("ExtendedClass", Loader::SYSTEM);

Loader::loadModel("election.*");
Loader::loadModel("PollingPlacesModel");

class ElectionClass extends ExtendedClass
{
	/**
	 * @param string $instance
	 * @return ElectionClass
	 */
	public static function i($instance = "ElectionClass")
	{
		return parent::i($instance);
	}
	
	public function getCandidates($options = array())
	{
		$__cond = [];
		$__bind = [];
		
		if(isset($options["cond"]) && is_array($options["cond"]))
			$__cond = array_merge($__cond, $options["cond"]);
		
		if(isset($options["bind"]) && is_array($options["bind"]))
			$__bind = array_merge($__bind, $options["bind"]);
		
		$__list = array();
		foreach(ElectionCandidatesModel::i()->getList($__cond, $__bind) as $__id)
			$__list[] = ElectionCandidatesModel::i()->getItem($__id);
		
		return $__list;
	}
	
	public function getCandidate($id)
	{
		return ElectionCandidatesModel::i()->getItem($id);
	}
	
	public function getCandidateBySymlink($symlink)
	{
		return ElectionCandidatesModel::i()->getItemByField("symlink", $symlink);
	}
	
	public function saveCandidate($data, $id = 0)
	{
		$__id = 0;
		
		if( ! ($id > 0) || ! ElectionCandidatesModel::i()->update(array_merge(["id" => $id], $data)))
			$__id = ElectionCandidatesModel::i()->insert($data);
		
		if( ! ($__id > 0))
			$__id = $id;
		
		return $__id;
	}
	
	public function cleanUpCandidateContacts($candidateId)
	{
		$__cond = array("election_candidate_id = :election_candidate_id");
		$__bind = array(
			"election_candidate_id" => $candidateId
		);
		
		foreach(ElectionCandidatesContactsModel::i()->getList($__cond, $__bind) as $__id)
			ElectionCandidatesContactsModel::i()->deleteItem($__id);
	}
	
	public function setCandidateContacts($candidateId, $list, $type = "")
	{ 
		foreach($list as $__value)
		{
			if($__value == "")
				continue;
			
			ElectionCandidatesContactsModel::i()->insert([
				"election_candidate_id" => $candidateId,
				"type" => $type,
				"value" => stripslashes($__value)
			]);
		}
	}
	
	public function getCandidateContacts($candidateId, $type = null)
	{
		$__cond = ["election_candidate_id = :election_candidate_id"];
		$__bind = ["election_candidate_id" => $candidateId];
		
		if( ! is_null($type) && in_array($type, ["phone"]))
		{
			$__cond[] = "type = :type";
			$__bind["type"] = $type;
		}
		
		$__list = [];
		
		foreach(ElectionCandidatesContactsModel::i()->getList($__cond, $__bind) as $__id)
		{
			$__item = ElectionCandidatesContactsModel::i()->getItem($__id, ["type", "value"]);
			if( ! isset($__list[$__item["type"]]))
				$__list[$__item["type"]] = [];
			$__list[$__item["type"]][] = $__item["value"];
		}
			
		return $__list;
	}
	
	public function getVolunteersByCandidate()
	{
		
	}
	
	public function getCountyNumbersByRegion($geoKoatuuCode)
	{
		$__sql = "SELECT `county_number` "
				. "FROM `polling_places` "
				. "WHERE `geo_koatuu_code` REGEXP '".substr($geoKoatuuCode, 0, 2)."[0-9]{8}' "
				. "GROUP BY `county_number`";
		
		$__list = [];
		
		foreach(PollingPlacesModel::i()->getCols($__sql) as $__countyNumber)
			$__list[] = [
				"id" => $__countyNumber,
				"text" => t("Одномандатний виборчий округ № ").$__countyNumber
			];
		
		return $__list;
	}
	
	public function getPollingPlacesByCountyNumber($countyNumber)
	{
		$__list = array();
		
		$__cond = array("county_number = :county_number");
		$__bind = array("county_number" => $countyNumber);
		
		foreach(PollingPlacesModel::i()->getList($__cond, $__bind) as $__id)
			$__list[] = PollingPlacesModel::i()->getItem($__id, ["id", "number", "address"]);
		
		return $__list;
	}
	
	public function setCandidateAgitations($candidateId, $agitationsIds)
	{
		foreach($agitationsIds as $__agitationId)
		{
			if( ! AgitationsModel::i()->getItem($__agitationId, ["id"]))
				continue;
			
			AgitationsModel::i()->update([
				"id" => $__agitationId,
				"election_candidate_id" => $candidateId,
				"is_hidden" => 0
			]);
		}
	}
	
	public function getCandidateAgitations($candidateId)
	{
		$__list = [];
		
		$__cond = ["election_candidate_id = :election_candidate_id"];
		$__bind = ["election_candidate_id" => $candidateId];
		
		foreach(AgitationsModel::i()->getList($__cond, $__bind) as $__id)
		{
			$__item = AgitationsModel::i()->getItem($__id, ["id", "name", "categories_ids", "image", "file", "is_public"]);
			
			$__item["categories"] = [];
			foreach($__item["categories_ids"] as $__categoryId)
				$__item["categories"][] = AgitationsCategoriesModel::i()->getItem($__categoryId, ["name"])["name"][Router::getLang()];
			
			$__list[] = $__item;
		}
		
		return $__list;
	}
	
	public function setCandidateOpponents($candidateId, $opponentsIds)
	{
		foreach($opponentsIds as $__opponentId)
		{
			if( ! ElectionCandidatesOpponentsModel::i()->getItem($__opponentId, ["id"]))
				continue;
			
			ElectionCandidatesOpponentsModel::i()->update([
				"id" => $__opponentId,
				"election_candidate_id" => $candidateId
			]);
		}
	}
	
	public function getCandidateOpponents($candidateId)
	{
		$__list = [];
		
		$__cond = ["election_candidate_id = :election_candidate_id"];
		$__bind = ["election_candidate_id" => $candidateId];
		
		foreach(ElectionCandidatesOpponentsModel::i()->getList($__cond, $__bind) as $__id)
			$__list[] = ElectionCandidatesOpponentsModel::i()->getItem($__id);
		
		return $__list;
	}
}
