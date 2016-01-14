<?php

namespace libs\services;

\Loader::loadModel("inquirers.InquirersModel");
\Loader::loadModel("inquirers.BlocksModel");
\Loader::loadModel("inquirers.QuestionsModel");
\Loader::loadModel("inquirers.AnswersModel");

\Loader::loadModel("UsersModel");
\Loader::loadClass("GeoClass");
\Loader::loadClass("UserClass");

use libs\models\inquirers\InquirersModel;
use libs\models\inquirers\BlocksModel;
use libs\models\inquirers\QuestionsModel;
use libs\models\inquirers\AnswersModel;

class InquirersService extends \Keeper
{

	/**
	 * @return InquirersService
	 */
	public static function i()
	{
		return parent::getInstance(get_class());
	}

	public function getInquirers()
	{
		return InquirersModel::i()->getList();
	}

	public function save($id, $geo)
	{

	}
}