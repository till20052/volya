<?php

Loader::loadSystem("Controller");

class SController extends Controller
{
	protected $root;
	
	protected function path()
	{
		$__parts = array(
			date("Y"),
			date("m")
		);
		
		$__j = (int) date("j");
		
		for($__i = 1; $__i <= 5; $__i++)
		{
			$__finish = 7 * $__i;
			$__start = $__finish - 6;
			
			if(
					$__j >= $__start
					&& $__j <= $__finish
			)
				$__parts[] = $__i;
		}
		
		$__path = "";
		foreach($__parts as $__part)
		{
			$__path .= $__part.DS;
			
			if( ! is_dir($this->root.DS.$__path))
				mkdir($this->root.DS.$__path);
		}
		
		return $__path;
	}
	
	public function __construct($folder = "")
	{
		$this->root = Router::getAppFolder()."/static/upload";
		
		if($folder != "")
			$this->root .= DS.$folder;
		
		if( ! is_dir($this->root))
			mkdir($this->root, 0777);
	}
	
	public function execute()
	{
		parent::execute();
	}
}
