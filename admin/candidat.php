<?php
session_start();
require_once('../include/config-bdd.php');

//Si la personne n'est pas connectée, on la redirige vers la page de login
if(!isset($_SESSION['admin'])){
	header('Location: login.php');
}

//Modification
if(isset($_POST['edit'])){
	$requete = $bdd->prepare(
		"SELECT *
		FROM `candidat`
		WHERE `id` = :id");
	$requete->execute(array(':id'=>$_POST['edit']));
	$candidat = $requete->fetch(PDO::FETCH_ASSOC);
}

//Suppression
if(isset($_POST['delete'])){
	$requete = $bdd->prepare(
		"DELETE FROM `candidat`
		WHERE `id` = :id");
	$requete->execute(array(':id'=>$_POST['delete']));

	header('Location: index.php');
}

//Création
if(isset($_POST['create'])){
	$requete = $bdd->prepare(
		"INSERT INTO `candidat` (`nom`)
		VALUES (:nom)");
	$requete->execute(array(':nom'=>$_POST['nom']));
	$candidatId = $bdd->lastInsertId(); 
	//Go upload img
}

//Update
if(isset($_POST['update'])){
	$requete = $bdd->prepare(
		"UPDATE `candidat`
		SET `nom` = :nom
		WHERE id = :id");
	$requete->execute(array(':nom'=>$_POST['nom'], ':id'=>$_POST['update']));
	$candidatId = $_POST['update']; 
	//Go upload img
}

if(isset($_FILES['avatar'])&&isset($candidatId)) {
	if($_FILES['avatar']['error']==0) {
		$extension = strrchr($_FILES['avatar']['name'], '.');
		$folder = '../img/candidats/';
		$file = $candidatId.$extension;
		if(move_uploaded_file($_FILES['avatar']['tmp_name'], $folder.$file)) {
			$requete = $bdd->prepare(
				"UPDATE `candidat`
				SET `avatar` = :avatar
				WHERE id = :id");
			$requete->execute(array(':avatar'=>$file, ':id'=>$candidatId));
		}
	}

	header('Location: index.php');
}


require_once('header.php');
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php if(isset($candidat)) : ?>
					<h3 class="panel-title">Modification d'un 6A</h3>
				<?php else : ?>
					<h3 class="panel-title">Ajout d'un 6A</h3>
				<?php endif; ?>
			</div>
			<div class="panel-body">
				<form action="" method="POST" role="form" enctype="multipart/form-data">
					<div class="form-group">
						<label for="name">Nom</label>
						<input value="<?php if(isset($candidat)) echo $candidat['nom']; ?>" type="text" class="form-control" id="name" name="nom" required autofocus/>
					</div>
					<div class="form-group">
						<label>Avatar</label>
						<div>
							<?php if(isset($candidat)) : ?>
								<div class="fileinput fileinput-exists" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 160px; height: 160px;">
										<img data-src="holder.js/100%x100%" alt="avatar" />
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 160px; max-height: 160px;">
										<img src="../img/candidats/<?php echo $candidat['avatar'].'?dummy='.time(); ?>" style="max-width: 200px; max-height: 150px; line-height: 20px;">
									</div>
									<div>
										<span class="btn btn-default btn-file">
											<span class="fileinput-new">Select image</span>
											<span class="fileinput-exists">Change</span>
											<input type="file" name="avatar" />
										</span>
										<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
									</div>
								</div>
							<?php else : ?>
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 160px; height: 160px;">
										<img data-src="holder.js/100%x100%" alt="avatar" />
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 160px; max-height: 160px;"></div>
									<div>
										<span class="btn btn-default btn-file">
											<span class="fileinput-new">Select image</span>
											<span class="fileinput-exists">Change</span>
											<input type="file" name="avatar" />
										</span>
										<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
									</div>
								</div>
							<?php endif; ?>
							
						</div>
					</div>
					<?php if(isset($candidat)) : ?>
						<button type="submit" class="btn btn-primary" name="update" value="<?php echo $candidat['id']; ?>">Modifier</button>
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