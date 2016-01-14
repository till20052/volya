<?php

namespace libs\services;

\Loader::loadModel("inquirers.InquirersModel");

use \libs\models\inquirers\InquirersModel;

class FormsService
{

	/**
	 * @return FormsService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function save($id, $geo)
	{
		InquirersModel::i()->ins
	}
}