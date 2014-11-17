<?php

require_once('include/config-bdd.php');

//Check that the form has been posted.
if (isset($_POST["vote"]) {

	$verification = false;
	$requeteVerif = $bdd->prepare(
		"SELECT *
		FROM `vote`
		WHERE `ip` = :ip");
	$requeteVerif->execute(array(':ip'=>$_SERVER['REMOTE_ADDR']));
	$verif = $requeteVerif->fetch(PDO::FETCH_ASSOC);
	if($verif) {
		$requeteVerif = $bdd->prepare(
			"SELECT *
			FROM `vote`
			WHERE `ip` = :ip
			AND DATEDIFF(`time`, NOW() ) >= 1");
		$requeteVerif->execute(array(':ip'=>$_SERVER['REMOTE_ADDR']));
		$verif = $requeteVerif->fetch(PDO::FETCH_ASSOC);
		if($verif) {
			$verification=true;
		}
	}

	//Does the vote pass both test? If so, insert the vote into the database.
	if($verification) {
		$requeteVote = $bdd->prepare(
			"INSERT INTO `vote` (`ip`, `id_candidat`)
			VALUES (:ip, :id_candidat)");
		$requeteVote->execute(array(
			':ip'=>$_SERVER['REMOTE_ADDR'],
			':id_candidat'=>$_POST['vote']));
	}
}

?>