<?php

require_once('include/config-bdd.php');

//Check that the form has been posted.
if (isset($_POST["candidat"])) {

	$requeteVerif = $bdd->prepare(
		"SELECT *
		FROM `vote`
		WHERE id_categorie = :categorie
		AND ip = :ip
		AND DATEDIFF(NOW(), `time`) < 1");
	$requeteVerif->execute(array(
		':categorie'=>$_POST['categorie'],
		':ip'=>$_SERVER['REMOTE_ADDR']));
	$result = $requeteVerif->fetch(PDO::FETCH_ASSOC);
	
	//Does the vote pass both test? If so, insert the vote into the database.
	if(!$result) {
		$requeteVote = $bdd->prepare(
			"INSERT INTO `vote` (`ip`, `id_candidat`, `id_categorie`)
			VALUES (:ip, :id_candidat, :id_categorie)");
		$requeteVote->execute(array(
			':ip'=>$_SERVER['REMOTE_ADDR'],
			':id_candidat'=>$_POST['candidat'],
			':id_categorie'=>$_POST['categorie']));
	}
}

header('Location: indexbis.php#elections');

?>