<?php

Loader::loadModule('Errors');

class IndexErrorsController extends ErrorsController
{
	public function execute($args)
	{
		parent::execute();
		
		if(
				isset($args[0])
				&& in_array($args[0], array('404')))
			$this->setView($args[0]);
		else
			$this->setView('404');
		
		if($this->getView() == "404")
			header("HTTP/1.0 404 Not Found");
	}
}

?>
