<?php

//Les accès à la bdd étant perdus, oenologie a prété les siens.
//Merci de ne pas tout leur casser !
$server = "localhost";
$username = "oenologie";
$password = "312q645d978Z";
$database_name = "oenologie";

try{
	$bdd = new PDO('mysql:host='.$server.';dbname='.$database_name, $username, $password);
}catch (Exception $e){
	die('Erreur : ' . $e->getMessage());
}
?>