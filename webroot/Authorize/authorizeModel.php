<?php
require_once "dbConnect.php"

class AuthorizeModel{
	private $dbConnect;
	private $error;
	
	public function AuthorizeModel(){
		$this->error = new array();
		$this->dbConnect = new DBConnect();
	}
	
	public function login($name, $pass){
		$db = $this->dbConnect;
		
		if(strpos($name, '@') === false)
			$userID = $db->getUserIDName($name, $pass);
		else
			$userID = $db->getUserIDEmail($name, $pass);
			
		if($userID === false){
			$this->addError($db->getError());
			return false;
		}
		
		$_SESSION['userid'] = $userID;
		return true;
	}
	
	public function register($email, $name, $pass){
		$db = $this->dbConnect;
		if(!(strpos($email, '@') === false) && strlen($pass) >=4){
		
		$out = $db->registerUser($email, $name, $pass);
		}
		else{
			if(strlen($pass) >=4)
				$this->addError("AUTHORIZEMODEL: email provided must be an email");
			else
				$this->addError("AUTHORIZEMODEL: password must be atleast 4 characters long");
			return false;
		}
		if(!$out){
			$this->addError($db->getError());
			return false;
		}
		return true;
	}
	
	public function changepass($email, $key, $pass){
		$db = $this->dbConnect;
		if($db->decrementKey($email)){
			if(!(strpos($email, '@') === false) && strlen($pass) >=4){
				$out = $db->checkKey($email, $key);
			}
			else{
				if(strlen($pass) >=4)
					$this->addError("AUTHORIZEMODEL: email provided must be an email");
				else
					$this->addError("AUTHORIZEMODEL: password must be atleast 4 characters long");
			return false;
		}
		if(!$out){
			$this->addError($db->getError());
			return false;
		}
		$db->changePass($pass);
		return true;
		}
	}
	
	public function requestpass($email){
		$db = $this->dbConnect;
		$salt = $db->getSalt();
		$key = time() + $salt;
		if($db->addKey($email, $key)){
			$str = "please visit the following url to reset your password: " . $_SERVER['SERVER_NAME'] . "/passreset?key={$key}";
		mail($email, "password reset", $str);
		return true;
		
		}
	}
	
}
?>