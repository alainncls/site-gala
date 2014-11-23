<?php

//Les accès à la bdd étant perdus, oenologie a prété les siens.
//Merci de ne pas tout leur casser !
/*$server = "localhost";
$username = "oenologie";
$password = "312q645d978Z";
$database_name = "oenologie";*/

// Config pour exécuter en local

$server = "localhost";
$username = "root";
$password = "";
$database_name = "gala";

try{
	$bdd = new PDO('mysql:host='.$server.';dbname='.$database_name, $username, $password);
}catch (Exception $e){
	die('Erreur : ' . $e->getMessage());
}
?>