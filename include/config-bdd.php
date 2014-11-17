<?php

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