<?php

Loader::loadSystem("Controller");

class LandingPage extends Controller
{
	private $__title = "Партія ВОЛЯ";
	private $__keywords = "Партія ВОЛЯ";
	private $__description = "Партія ВОЛЯ";
	
	public function execute()
	{
		parent::execute();
		parent::setLayout("landing_page");
		
		HeadClass::addLess([
			"/less/landing_page.less"
		]);
		
		$this->application = new stdClass();
		$this->application->title =& $this->__title;
		$this->application->description =& $this->__description;
		$this->application->keywords =& $this->__keywords;
	}
}
