<?php

namespace libs\models\reports;

\Loader::loadModel("ExtendedModel", \Loader::SYSTEM);

class ReportFilesModel extends \ExtendedModel
{
	protected $table = "report_files";
	protected $_specificFields = array(
		"date" => array("created_at", "modified_at:force")
	);

	/**
	 * @return mixed
	 */
	public static function i()
	{
		return parent::i(get_class());
	}
}
