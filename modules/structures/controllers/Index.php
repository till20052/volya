<?php

Loader::loadModule("Structures");

class IndexStructuresController extends StructuresController
{
	public function execute()
	{
		parent::execute();

		HeadClass::addLess("/less/frontend/structures/index.less");
		HeadClass::addLess("/less/frontend/structures/common/filter.less");
	}
}
