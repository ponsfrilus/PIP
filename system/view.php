<?php

class View {

	private $pageVars = array();
	private $template;

	public function __construct($template)
	{
		$this->template = APP_DIR .'views/'. $template .'.php';
	}

	/*
		Set a template var to a specific value. If $var is an array,
		$val will be ignored and the array will be merged with the
		current settings.
	*/
	public function set($var, $val = null)
	{
		if (is_array($var))
		{
			$this->pageVars = array_merge($this->pageVars, $var);
		}
		else if (isset($val))
		{
			$this->pageVars[$var] = $val;
		}
	}

	public function render()
	{
		extract($this->pageVars);

		ob_start();
		require($this->template);
		echo ob_get_clean();
	}
    
}

?>