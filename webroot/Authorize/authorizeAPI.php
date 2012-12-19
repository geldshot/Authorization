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
	
	public function process($webInput){
		$this->webInput = $webInput;
		switch($webInput['command'])
			case "login":
				if(isset($webInput['username']) && isset($webInput['password'])){
					if(($this->model->login($webInput['username'], $webInput['password']))
						$outPut = "success";
					else
						$outPut = "AUTHORIZEAPI: login failed";
				}
				else
					$outPut = "AUTHORIZEAPI: missing login information";
				break;
				
			case "register":
				if(isset($webInput['email']) && isset($webInput['username']) && isset($webInput['password'])){
					if(($this->model->register($webInput['email'], $webInput['username'], $webInput['password']))
						$outPut = "success";
					else
						$outPut = "AUTHORIZEAPI: login failed";
					}
				else
					$outPut = "AUTHORIZEAPI: missing registration information";
				break;
			case "changepass":
				if(isset($webInput['email']) && isset($webInput['key']) && isset($webInput['password'])){
					if(($this->model->changepass($webInput['email'], $webInput['key'], $webInput['password']))
						$outPut = "success";
					else
						$outPut = "AUTHORIZEAPI: changepass failed";
				}
				else
					$outPut = "AUTHORIZEAPI: missing changepass information";
				break;
			case "requestpass":
				if(isset($webInput['email'])){
					if(($this->model->requestpass($webInput['email']))
						$outPut = "success";
					else
						$outPut = "AUTHORIZEAPI: request failed";
				}
				else
					$outPut = "AUTHORIZEAPI: missing request information";
				break;
			case "logout":
				$this->model->logout();
				break;
			default:
				$outPut = "AUTHORIZEAPI: invalid command";
				break;
	}
	
	public function error(){
		echo $webInput . "<br/>\n";
		echo $model->Error() . "<br/>\n";
		echo $outPut . "<br/>\n";
	}
	
	public function output(){
		echo $outPut;
	}
}
?>