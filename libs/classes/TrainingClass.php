<?php

Loader::loadClass("ExtendedClass", Loader::SYSTEM);
Loader::loadModel("trainings.*");

class TrainingClass extends ExtendedClass
{
	/**
	 * 
	 * @param string $instance
	 * @return TrainingClass
	 */
	public static function i($instance = "TrainingClass")
	{
		return parent::i($instance);
	}
	
	public function countTrainingMembers($trainingId)
	{
		$__cond = array("training_id = :training_id");
		$__bind = array("training_id" => $trainingId);
		
		return count(TrainingsMembersModel::i()->getList($__cond, $__bind));
	}

	public function isTrainingMember($trainingId, $userId)
	{
		$__cond = array("training_id = :training_id", "user_id = :user_id");
		$__bind = array(
			"training_id" => $trainingId,
			"user_id" => $userId
		);
		
		return count(TrainingsMembersModel::i()->getList($__cond, $__bind, array(), 1)) > 0 ? true : false;
	}
}
