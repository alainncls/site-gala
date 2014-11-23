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
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">
					Liste des Candidats
				</h3>
			</div>
			<div class="table-responsive">
				<?php foreach ($categories as $categorie) : ?>
					<?php $requeteCandidats->execute(array(':categorie'=>$categorie['id'])); ?>
					<?php $candidats = $requeteCandidats->fetchAll(PDO::FETCH_ASSOC); ?>
					<div class="panel-body">
						<div class="row">
							<h3><?php echo strip_tags($categorie['nom']); ?></h3>
							<?php foreach ($candidats as $candidat) : ?>
								<div class="col-md-2 text-center">
									<div class="featurette-item">
										<h4><?php echo $candidat['nom']; ?></h4>
										Score: <?php echo $candidat['nbVote']; ?>
										<?php $requeteVotes->execute(array(':categorie'=>$categorie['id'], ':ip'=>$_SERVER['REMOTE_ADDR'])); ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
<?php
require_once('footer.php');
?>