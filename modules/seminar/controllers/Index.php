<?php

Loader::loadModule("Seminar");

Loader::loadClass("UserClass");

Loader::loadModel("PMGroupsModel");
Loader::loadModel("PMFilesModel");

class IndexSeminarController extends SeminarController
{
	public function execute($args = [])
	{
		parent::execute();

		if( ! UserClass::i()->isAuthorized())
			parent::redirect("/");

		HeadClass::addLess("/less/frontend/seminar/index.less");

		$this->files = [];
		$this->tab = @$args[0];

		foreach(PMFilesModel::i()->getList([], [], ["created_at ASC"]) as $__id)
		{
			$__file = PMFilesModel::i()->getItem($__id, ["id", "pmgid", "hash", "name"]);

			if( ! isset($this->files[$__file["pmgid"]]))
				$this->files[$__file["pmgid"]] = [];

			$this->files[$__file["pmgid"]][] = $__file;
		}
	}
}