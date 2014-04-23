<?php

class Main extends Controller {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		
		$user = $this->session_helper->get('user');
		
		$template = $this->loadView('main_view');
		$template->set('title','Welcome to PIP');
		$template->setCSS(array(
			array("static/css/style.css", "intern"),
			array("http://www.example.com/default.css", "extern")
		));
		$template->setJS(array(
			array("static/js/index.js", "intern"),
			array("http://www.example.com/static.js", "extern")
		));
		
		$template->render();
	}
	
	function category()
	{
		$model = $this->loadModel('example_model');
		$template = $this->loadView('main_view');
		$template->set('data',$model->getCategory());
		$template->render();
	}

}

?>
