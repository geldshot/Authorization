<?php
require "config.php";

class DBConnect{
	private $mysql;
	private $error;
	private $keyuses;
	
	function DBConnect(){
		$this->error = "";
		$this->keyuses = 5;
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
	
	public function addKey($email, $key){
		$this->createKey($email);
		
		$arr = $this->getKey($email);
		
		if(!$arr){
			return false;
		}
		
		$id = $arr['id'];
		$key = $key + $id;
		if(!($this->setKey($id, $key))){
			return false;
		}
		
		return $key;
	
	}
	
	public function decrementKey($email){
		$arr = $this->getKey($email);
		
		if(!$arr){
			
			return false;
		}
		
		$key = $arr['key'];
		$uses = $arr['uses'];
		
		if(!($this->setKeyUse($key, $uses + 1))){
			
			return false;
		}
		if($uses <= $this->keyuses)
			return true;
		return false;
	}
	
	protected function createKey($email){
		if(!($this->_open())){
			$date = strtotime('today');
			$stmt = $this->mysql->prepare("INSERT INTO `passkeys` ( email, datestamp ) VALUES(?,?);");
			if(!$stmt){
				$this->error .= 'Could not prepare: '. $this->mysql->error . "<br/>\n";
				$this->mysql->close();
				return false;
			}
			$stmt->bind_param('ss',$email, $date);
			
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
	
	protected function getKey($email){
		if(!($this->_open())){
			$stmt = $this->mysql->prepare("SELECT authid, authkey, uses FROM `passkeys` WHERE email = ? AND datestamp > ? ORDER BY creation DESC");
			if(!$stmt){
				$this->error .= 'Could not prepare: '. $this->mysql->error . "<br/>\n";
				$this->mysql->close();
				return false;
			}
			$date = strtotime('yesterday');
			$stmt->bind_param('ss',$email, $date );
			
			if($stmt->execute()){
				$stmt->bind_result($id, $key, $uses);
				if($stmt->fetch()){
					$stmt->close();
					$this->mysql->close();
					$arr['id'] = 
					$arr['key'] = $key;
					$arr['uses'] = $uses;
					return $arr;
				}
				$stmt->close();
				$this->mysql->close();
				return false;
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
	
	protected function setKey($id, $key){
		if(!($this->_open())){
			$date = strtotime('today');
			$stmt = $this->mysql->prepare("UPDATE `passkeys` SET authkey = ? WHERE authid = ?;");
			if(!$stmt){
				$this->error .= 'Could not prepare: '. $this->mysql->error . "<br/>\n";
				$this->mysql->close();
				return false;
			}
			$stmt->bind_param('ss',$key, $id);
			
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
	
	protected function setKeyUse($key, $uses){
		if(!($this->_open())){
			$date = strtotime('today');
			$stmt = $this->mysql->prepare("UPDATE `passkeys` SET uses = ? WHERE authkey = ?;");
			if(!$stmt){
				$this->error .= 'Could not prepare: '. $this->mysql->error . "<br/>\n";
				$this->mysql->close();
				return false;
			}
			$stmt->bind_param('ss',$key, $uses);
			
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
	
	protected function disposeKey($key){
		if(!($this->_open())){
			$date = strtotime('today');
			$stmt = $this->mysql->prepare("DELETE `passkeys` WHERE authkey = ?;");
			if(!$stmt){
				$this->error .= 'Could not prepare: '. $this->mysql->error . "<br/>\n";
				$this->mysql->close();
				return false;
			}
			$stmt->bind_param('s',$key);
			
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
	
	public function checkKey($email, $key){
		if(!($arr = $this->getKey($email))){
		return false;
		}
		if($arr['key'] === $key){
			return true;
		}
		return false;
	
	}
	
	public function getUserID($name, $pass){
		if(!($this->_open())){
			$name2 = $name;
			$stmt = $this->mysql->prepare("SELECT userid FROM `users` WHERE (email = ? OR username = ?) AND password = ?");
			if(!$stmt){
				$this->error .= 'Could not prepare: '. $this->mysql->error . "<br/>\n";
				$this->mysql->close();
				return false;
			}
			$stmt->bind_param('sss',$name, $name2, $pass );
			
			if($stmt->execute()){
				$stmt->bind_result($id);
				if($stmt->fetch()){
					$stmt->close();
					$this->mysql->close();
					
					return $id;
				}
				$stmt->close();
				$this->mysql->close();
				return false;
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