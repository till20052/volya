<?php

Loader::loadModel("ExtendedModel", Loader::SYSTEM);
Loader::loadModel("OrganizationsContactsValuesModel");

class OrganizationsContactsModel extends ExtendedModel
{
	protected $table = "organizations_contacts";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);

	/**
	 * @param string $instance
	 * @return ExtendedModel
	 */
	public static function i($instance = "OrganizationsContactsModel")
	{
		return parent::i($instance);
	}

	public function getItem($pKey, $fields = array(), $shortContact = false){
		$__item = parent::getItem($pKey, $fields);

		if($shortContact){
			$__cond = ["ocid = :ocid", "type LIKE 'phone'"];
			$__bind["ocid"] = $pKey;
			$__item['contacts'][] = OrganizationsContactsValuesModel::i()->getCompiledList($__cond, $__bind, [], $shortContact)[0];

			$__cond = ["ocid = :ocid", "type LIKE 'email'"];
			$__item['contacts'][] = @OrganizationsContactsValuesModel::i()->getCompiledList($__cond, $__bind, [], $shortContact)[0];
		}
		else
			$__item['contacts'] = OrganizationsContactsValuesModel::i()->getCompiledListByField("ocid", $pKey);

		return $__item;
	}

	public function getCompiledList($where = array(), $bind = array(), $order = array(), $limit = null, $shortContact = false){
		$__list = parent::getList($where, $bind, $order, $limit);

		$__compiledList = array();
		foreach($__list as $__item)
			$__compiledList[] = $this->getItem($__item, [], $shortContact);

		return $__compiledList;
	}
}
