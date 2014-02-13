<?php

class Main extends Controller {
	
	function __construct(){
		parent::__construct();
	}
	
	function index()
	{
		
		$user = $this->session_helper->get('user');
		
		$template = $this->loadView('main_view');
		$template->render();
	}
	
	function categoryAjax(){
		$model = $this->loadModel('example_model');
		
		$response = $model->getProjetos();
		if($response[0] === true){
			$this->render(array('data'=>$response[1]));
		}
		else{
			$this->render(array('data'=>array(), 'error'=> $response[1]));	
		}
	}
	
	function category(){
		//return ajax json
		$model = $this->loadModel('example_model');
		$this->render(array('data'=>$model->getCategory()), 'json');
	}
    
}

?>
