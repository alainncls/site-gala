<?php
session_start();
require_once('../include/config-bdd.php');

//Si la personne n'est pas connectée, on la redirige vers la page de login
if(!isset($_SESSION['admin'])){
	header('Location: login.php');
}

$requeteCandidats = $bdd->prepare(
	"SELECT c.*, COUNT(v.id) AS nbVote
	FROM `candidat` AS c
	LEFT JOIN `vote` AS v
	ON c.id = v.id_candidat
	AND v.id_categorie = :categorie
	GROUP BY c.id
	ORDER BY nbVote DESC");

$requeteVotes = $bdd->prepare(
	"SELECT *
	FROM `vote`");

$requeteCategories = $bdd->prepare(
	"SELECT *, COUNT(v.id) AS nbVote, c.id
	FROM `categorie` AS c
	LEFT JOIN `vote` AS v
	ON c.id = v.id_categorie
	GROUP BY c.id");

$requeteCategories->execute();
$categories = $requeteCategories->fetchAll(PDO::FETCH_ASSOC);

require_once('header.php');
?>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					Liste des Candidats
					<a href="candidat.php" class="btn btn-success btn-sm" name="add" data-toggle="tooltip" data-placement="bottom" title="Ajouter un candidat">
						<span class="glyphicon glyphicon-plus"></span>
					</a>
				</h3>
			</div>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Avatar</th>
							<th>Nom</th>
							<th>Sexy</th>
							<th>Drole</th>
							<th>Studieux</th>
							<th>Populaire</th>
							<th>Fetard</th>
							<th>Associatif</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

					<?php foreach ($categories as $categorie) : ?>
						<div class="col-md-2 text-center">
							<div class="featurette-item">
								<i class="fa fa-question"></i>
								<h4><?php echo $categorie['nom']; ?></h4>
								<a href="#collapseCat<?php echo $categorie['id']; ?>" data-toggle="collapse" class="span-vote" data-parent="#accordionVote" aria-expanded="true" aria-controls="collapseCat<?php echo $categorie['id']; ?>">Afficher</a>
							</div>
						</div>
					<?php endforeach; ?>


								<?php foreach ($categories as $categorie) : ?>
									<?php $requeteCandidats->execute(array(':categorie'=>$categorie['id'])); ?>
									<?php $candidats = $requeteCandidats->fetchAll(PDO::FETCH_ASSOC); ?>
									<div class="panel panel-default" style="border:0; background-color:transparent;">
										<div id="collapseCat<?php echo $categorie['id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingCat<?php echo $categorie['id']; ?>">
											<div class="panel-body">
												<h2><?php echo strip_tags($categorie['nom']); ?></h2>
												<?php foreach ($candidats as $candidat) : ?>
													<div class="col-md-2 text-center">
														<div class="featurette-item">
															<img class="img-circle grayscale" src="img/candidats/<?php echo $candidat['avatar']; ?>" width="150px" height="150px" />
															<h4><?php echo $candidat['nom']; ?></h4>
															Score: <?php echo $candidat['nbVote']; ?>
															<?php $requeteVotes->execute(array(':categorie'=>$categorie['id'], ':ip'=>$_SERVER['REMOTE_ADDR'])); ?>
															<?php if($result = $requeteVotes->fetch(PDO::FETCH_ASSOC)) : ?>
																Déjà voté
															<?php else : ?>
																<form action="vote.php" method="POST" role="form">
																	<input type="hidden" name="categorie" value="<?php echo $categorie['id']; ?>" />
																	<button type="submit" name="candidat" value="<?php echo $candidat['id']?>" class="btn btn-info btn-xs">Voter</button>
																</form>
															<?php endif; ?>
														</div>
													</div>
												<?php endforeach; ?>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<form id="candidatEdit" action="candidat.php" method="POST" role="form"></form>
		</div>

		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">
						Liste des Catégories
						<a href="categorie.php" class="btn btn-success btn-sm" name="add" data-toggle="tooltip" data-placement="bottom" title="Ajouter un candidat">
							<span class="glyphicon glyphicon-plus"></span>
						</a>
					</h3>
				</div>
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Nom</th>
								<th>Nb_vote</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($categories as $categorie) : ?>
								<tr>
									<td><?php echo strip_tags($categorie['nom']); ?></td>
									<td><?php echo $categorie['nbVote']; ?></td>
									<td align="right">
										<button type="submit" form="categorieEdit" value="<?php echo $categorie['id']; ?>" class="btn btn-warning btn-sm" name="edit" data-toggle="tooltip" data-placement="top" title="Modifier">
											<span class="glyphicon glyphicon-pencil"></span>
										</button>
										<button type="submit" form="categorieEdit" value="<?php echo $categorie['id']; ?>" class="btn btn-danger btn-sm" name="delete" data-toggle="tooltip" data-placement="top" title="Supprimer">
											<span class="glyphicon glyphicon-trash"></span>
										</button>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<form id="categorieEdit" action="categorie.php" method="POST" role="form"></form>
		</div>
	</div>
	<?php
	require_once('footer.php');
	?>