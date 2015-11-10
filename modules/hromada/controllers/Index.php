<?php

Loader::loadModule('Hromada');

class IndexHromadaController extends HromadaController
{
	public function execute()
	{
		parent::execute();

		HeadClass::addLess('/less/frontend/hromada/index.less');
	}
}