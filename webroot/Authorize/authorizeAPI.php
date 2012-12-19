<?php
require_once "authorizeModel.php";
class AuthorizeAPI{
	
	private $webInput;
	private $model;
	private $outPut;
	
	public function AuthorizeAPI(){
		$this->model = new AuthorizeModel();
		$this->outPut = "";
		$this->webInput = "";
	}
	
	public function Process($webInput){
		$this->webInput = $webInput;
		switch($webInput['command'])
			case "login":
				if(isset($webInput['username'])){
					$name = $webInput['username'];
					$type = 1;
				}
				else if(isset($webInput['username'])){
				
				}
				if(($this->model->login($webInput['username'], $webInput['password']))
					$outPut = "success";
				else
					$outPut = "AUTHORIZEAPI: login failed";
				break;
			case "register":
				if(($this->model->register($webInput['email'], $webInput['username'], $webInput['password']))
					$outPut = "success";
				else
					$outPut = "AUTHORIZEAPI: login failed";
				break;
				
		
		
		
		
		
	}
	
	public function Error(){
		echo $webInput . "<br/>\n";
		echo $model->Error() . "<br/>\n";
		echo $outPut . "<br/>\n";
	}
	
	public function OutPut(){
		echo $outPut;
	}
}
?>