<?php
session_start();
require_once('../include/config-bdd.php');

//Si la personne n'est pas connectée, on la redirige vers la page de login
if(!isset($_SESSION['admin'])){
	header('Location: login.php');
}

$requete = $bdd->prepare(
	"SELECT *
	FROM `candidat`");
$requete->execute();
$candidats = $requete->fetchAll(PDO::FETCH_ASSOC);


require_once('header.php');
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<a href="candidat.php" class="btn btn-success btn-sm pull-right" name="add" data-toggle="tooltip" data-placement="bottom" title="Ajouter un candidat">
					<span class="glyphicon glyphicon-plus"></span>
				</a>
				<h3 class="panel-title">Liste des Candidats</h3>
			</div>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Avatar</th>
							<th>Nom</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($candidats as $candidat) : ?>
							<tr>
								<td><img src="../img/candidats/<?php echo $candidat['avatar'].'?dummy='.time(); ?>" width="100px" height="100px" /></td>
								<td><?php echo $candidat['nom']?></td>
								<td align="right">
									<button type="submit" form="candidatEdit" value="<?php echo $candidat['id']?>" class="btn btn-warning btn-sm" name="edit" data-toggle="tooltip" data-placement="top" title="Modifier">
										<span class="glyphicon glyphicon-pencil"></span>
									</button>
									<button type="submit" form="candidatEdit" value="<?php echo $candidat['id']?>" class="btn btn-danger btn-sm" name="delete" data-toggle="tooltip" data-placement="top" title="Supprimer">
										<span class="glyphicon glyphicon-trash"></span>
									</button>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<form id="candidatEdit" action="candidat.php" method="POST" role="form"></form>
	</div>
</div>
<?php
require_once('footer.php');
?>