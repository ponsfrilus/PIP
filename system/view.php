<?php

class View {

	private $pageVars = array();
	private $templatePath;
	private $templateName;

	public function __construct($template)
	{
		$this->templateName = $template;
		$this->templatePath = APP_DIR .'views/'. $template .'.php';
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
		$result = $this->renderIntoString();
		echo $result;
	}

	public function renderIntoString()
	{
		$result = "";

		if (file_exists($this->templatePath))
		{
			extract($this->pageVars);

			ob_start();
			require($this->templatePath);
			$result = ob_get_clean();
		}
		else
		{
			$result = "Could not find a view called '".$this->templateName."'!";
		}

		return $result;
	}
}

?>