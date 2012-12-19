<?php
$require_once "authorizeAPI.php";
$api = new AuthorizeAPI();
if(isset($_POST['command']){
	$api->Process($_POST);
}
else if(isset($_GET['command'])){
	$api->Process($_GET);
}
else "AUTHORIZEAPI: invalid api access";

?>