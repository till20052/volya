<?php

Loader::loadSystem("Controller");
Loader::loadClass("UserClass");
Loader::loadModel("MenuModel");
Loader::loadModel("RegisterUsersModel");

class Frontend extends Controller
{
	private $__title = "Партія ВОЛЯ";
	private $__keywords = "Партія ВОЛЯ";
	private $__description = "Партія ВОЛЯ";
	private $__breadcrumbs = array();
	private $__sharing = [];
	private $__isVisibleSharingButtons = false;

	private $__accessHandlers = [];

	protected function addAccessHandler($handler)
	{
		if( ! is_callable($handler))
			return false;

		list(, $caller) = debug_backtrace(false);

		$key = md5(json_encode($caller['class']));

		$this->__accessHandlers[$key] = $handler;
	}

	protected function hasAccess()
	{
		list(, $caller) = debug_backtrace(false);

		$key = md5(json_encode($caller['class']));

		if( ! isset($this->__accessHandlers[$key]))
			return true;

		if( ! $this->__accessHandlers[$key] instanceof ReflectionFunction)
			$this->__accessHandlers[$key] = new ReflectionFunction($this->__accessHandlers[$key]);

		return $this->__accessHandlers[$key]->invokeArgs(func_get_args());
	}
	
	protected function loadKendo($state)
	{
		$this->loadKendo = (bool) $state;
		
		if($this->loadKendo)
			HeadClass::addLess("/less/kendo.less");
	}
	
	protected function loadCKEditor($state)
	{
		$this->loadCKEditor = (bool) $state;
	}
	
	protected function loadFileupload($state)
	{
		$this->loadFileupload = (bool) $state;
	}
	
	protected function loadWindow($window)
	{
		if(is_array($window))
			$this->windows = array_merge($this->windows, $window);
		else
			$this->windows[] = $window;
	}
	
	protected function title($title = null)
	{
		if( ! is_null($title))
			$this->__title = $title;
		
		return $this->__title;
	}
	
	protected function description($description = null)
	{
		if( ! is_null($description))
			$this->__description = $description;
		
		return $this->__description;
	}
	
	protected function keywords($keywords = null)
	{
		if( ! is_null($keywords))
			$this->__keywords = $keywords;
		
		return $this->__keywords;
	}
	
	protected function addBreadcrumb($href, $text)
	{
		if( ! is_array($this->__breadcrumbs))
			$this->__breadcrumbs = array();
		
		$this->__breadcrumbs[] = array(
			"href" => $href,
			"text" => $text
		);
	}
	
	protected function clearBreadcrumbs()
	{
		$this->__breadcrumbs = array();
	}
	
	protected function sharing($field, $value = null)
	{
		if( ! in_array($field, ["title", "description", "image"]))
			return;
		
		if( ! is_null($value))
			$this->__sharing[$field] = $value;
		
		if( ! isset($this->__sharing[$field]) && in_array($field, ["title", "description"]))
		{
			$__property = "__".$field;
			return $this->$__property;
		}
		
		return $this->__sharing[$field];
	}
	
	protected function enableSharingButtons($state = null)
	{
		if(is_bool($state))
			$this->__isVisibleSharingButtons = $state;
		
		return $this->__isVisibleSharingButtons;
	}

	public function __construct()
	{

	}

	public function execute()
	{
		parent::execute();

		$this->loadKendo = false;
		$this->loadCKEditor = false;
		$this->loadFileupload = false;
		$this->windows = array();
		
		$this->application = new stdClass();
		$this->application->title =& $this->__title;
		$this->application->description =& $this->__description;
		$this->application->keywords =& $this->__keywords;
		$this->application->breadcrumbs =& $this->__breadcrumbs;
		$this->application->sharing =& $this->__sharing;
		$this->application->isVisibleSharingButtons =& $this->__isVisibleSharingButtons;
		
		if(in_array(parent::getLayout(), ["document"]))
		{
			HeadClass::addLess("/less/".parent::getLayout().".less");
			return;
		}

		$this->registerUser = RegisterUsersModel::i()->getItemByUserId(UserClass::i()->getId());

		if( ! ($this->registerUser["credential_level_id"] > 0))
			if(Router::getModule() == "admin")
				parent::redirect("/admin");
			elseif(Router::getModule() == "register")
				parent::redirect("/");

		parent::setLayout("frontend");
		
		$__cond = array("is_public = 1");
		$this->mainMenu = MenuModel::i()->buildTree(MenuModel::i()->getCompiledList($__cond, array(), array("priority ASC")));
		
		$this->application->intlDateFormatter = new IntlDateFormatter('UK_ua', IntlDateFormatter::LONG, IntlDateFormatter::NONE, 'Europe/Kiev');
		$this->application->intlDateFormatter->setPattern("d MMMM, HH:mm");
		
		HeadClass::addJs(array(
			"/js/frontend.js",
			"/js/frontend/".(UserClass::i()->isAuthorized() ? "profile" : "login").".js"
		));
		
		HeadClass::addLess(array(
			"/less/frontend.less",
			"/less/frontend/".(UserClass::i()->isAuthorized() ? "profile" : "login").".less"
		));
	}
	
	public function nan()
	{
		parent::setViewer(null);
	}
}
