<?php

class Controller {

	function __construct()
	{
		$this->autoload();
	}
	
	private function autoload()
	{
		global $config;
		
		foreach( $config['autoload'] as $type => $payload )
		{
			$funcName = 'load' . ucfirst( substr($type, 0, -1) );
			
			if( is_array($payload) )
			{
				foreach($payload as $toLoad)
				{
					if(method_exists($this,$funcName))
					{
						if( $type == 'helpers' )
						{
							$this->$toLoad = call_user_func(array($this, $funcName), $toLoad);
						} elseif( $type == 'plugins' ) 
						{
							call_user_func(array($this, $funcName), $toLoad);
						}
					}
				}
			}
		}
	}

	public function loadModel($name)
	{
		require(APP_DIR .'models'. DS . strtolower($name) .'.php');

		$model = new $name;
		return $model;
	}
	
	public function loadView($name)
	{
		$view = new View($name);
		return $view;
	}
	
	public function loadPlugin($name)
	{
		require(APP_DIR .'plugins'. DS . strtolower($name) .'.php');
	}
	
	public function loadHelper($name)
	{
		require(APP_DIR .'helpers'. DS . strtolower($name) .'.php');
		$helper = new $name;
		return $helper;
	}
	
	public function redirect($loc)
	{
		global $config;
		
		header('Location: '. $config['base_url'] . $loc);
	}

	/*
		Render a default view (a view with the same name as the controller) or
		the specified view. If rendering the default view, vars may be passed
		in via the first argument.
	*/
	public function render($view = null, $vars = null)
	{
		// Check whether to render the default view or a specific view.
		$viewName = (is_string($view)) ? $viewName : strtolower(get_class($this));
		$template = $this->loadView($viewName);

		// Find the vars if they exist.
		$v = array();
		if (isset($vars) && is_array($vars))
		{
			$v = $vars;
		}
		else if (isset($view) && is_array($view))
		{
			$v = $view;
		}

		$template->set($v);
		$template->render();
	}
    
}

?>