<?php
require "config.php";

class DBConnect{
	private $mysql;
	private $error;
	
	function DBConnect(){
		$error = "";
		return $this;
	}
	
	protected function _open(){
		$this->error = "";
		$this->mysql = new mysqli($dbURL, $dbUSR, $dbPass, $dbName);
		if(!($this->mysql))
		{
			$this->error .= 'Could not connect: '. mysqli_error() . "<br/>\n";
			return false;
		}
		return true;
	}
	
	public function getError(){
		return $this->error;
	{
	
	public function (){
		if(!($this->_open())){
			$stmt = $this->mysql->prepare("");
			if(!$stmt){
				$this->error .= 'Could not prepare: '. $this->mysql->error . "<br/>\n";
				$this->mysql->close();
				return false;
			}
			$stmt->bind_param('',);
			
			if($stmt->execute()){
				$stmt->close();
				$this->mysql->close();
				return true;
			}
			else{
				$this->error .= 'Could not execute: '. $stmt->error . "<br/>\n";
				$stmt->close();
				$this->mysql->close();
				return false;
			}
		}
		return false;
	
	}
	
	public function registerUser($email, $name, $pass){
		if(!($this->_open())){
			$stmt = $this->mysql->prepare("INSERT INTO `users` (username, email, password) VALUES(?,?,?);");
			if(!$stmt){
				$this->error .= 'Could not prepare: '. $this->mysql->error . "<br/>\n";
				$this->mysql->close();
				return false;
			}
			$stmt->bind_param('sss',$email, $name, $pass);
			
			if($stmt->execute()){
				$stmt->close();
				$this->mysql->close();
				return true;
			}
			else{
				$this->error .= 'Could not execute: '. $stmt->error . "<br/>\n";
				$stmt->close();
				$this->mysql->close();
				return false;
			}
		}
		return false;
	
	}
	
}


?>