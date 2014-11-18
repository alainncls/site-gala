<?php
session_start();
require_once('../include/config-bdd.php');

//Si la personne n'est pas connectée, on la redirige vers la page de login
if(!isset($_SESSION['admin'])){
	header('Location: login.php');
}
echo '<pre>';
print_r($_POST);
echo '</pre>';
//Modification
if(isset($_POST['edit'])){
	$requete = $bdd->prepare(
		"SELECT *
		FROM `categorie`
		WHERE `id` = :id");
	$requete->execute(array(':id'=>$_POST['edit']));
	$categorie = $requete->fetch(PDO::FETCH_ASSOC);
}

//Suppression
if(isset($_POST['delete'])){
	$requete = $bdd->prepare(
		"DELETE FROM `categorie`
		WHERE `id` = :id");
	$requete->execute(array(':id'=>$_POST['delete']));

	header('Location: index.php');
}

//Création
if(isset($_POST['create'])){
	$requete = $bdd->prepare(
		"INSERT INTO `categorie` (`nom`)
		VALUES (:nom)");
	$requete->execute(array(':nom'=>$_POST['nom']));
	$categorieId = $bdd->lastInsertId(); 
	header('Location: index.php');
}

//Update
if(isset($_POST['update'])){
	$requete = $bdd->prepare(
		"UPDATE `categorie`
		SET `nom` = :nom
		WHERE id = :id");
	$requete->execute(array(':nom'=>$_POST['nom'], ':id'=>$_POST['update']));
	$categorieId = $_POST['update']; 
	header('Location: index.php');
}


require_once('header.php');
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php if(isset($categorie)) : ?>
					<h3 class="panel-title">Modification d'une catégorie</h3>
				<?php else : ?>
					<h3 class="panel-title">Ajout d'une catégorie</h3>
				<?php endif; ?>
			</div>
			<div class="panel-body">
				<form action="" method="POST" role="form">
					<div class="form-group">
						<label for="name">Nom</label>
						<input value="<?php if(isset($categorie)) echo $categorie['nom']; ?>" type="text" class="form-control" id="name" name="nom" required autofocus/>
					</div>
					<?php if(isset($categorie)) : ?>
						<button type="submit" class="btn btn-primary" name="update" value="<?php echo $categorie['id']; ?>">Modifier</button>
					<?php else : ?>
						<button type="submit" class="btn btn-primary" name="create">Ajouter</button>
					<?php endif; ?>
				</form>
			</div>
			<div class="panel-footer">
				<a href="index.php" class="btn btn-default">
					Retour
				</a>
			</div>
		</div>
	</div>
</div>
<?php
require_once('footer.php');
?>