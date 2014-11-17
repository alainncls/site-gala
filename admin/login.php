<?php
session_start();
require_once('../include/config-bdd.php');

//Si tentative de connexion
if(isset($_POST['login'])&&$_POST['user']=='gala2014'&&$_POST['mp']=='312d645q978s'){
	//On rempli la variable _SESSION
	$_SESSION['admin']=true;
	//Redirection vers la page d'accueil
	header('Location: index.php');
//Si tentative de déconnection
}else if(isset($_GET['logout'])){
	//On vide la variable _SESSION, et on redémarre la session
	$_SESSION = array();
	session_destroy();
	session_start();
}

require_once('header.php');
?>
		<div id="form_login" class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Login</h3>
			</div>
			<div class="panel-body">
				<form class="form" role="form" method="post">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" class="form-control" id="inputUser" name="user" placeholder="Login" required="required" autofocus="autofocus" />
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-eye-close"></span></span>
							<input type="password" class="form-control" id="inputPassword" name="mp" placeholder="Mot de passe" required="required" />
						</div>
					</div>
					<div class="form-group">
						<button type="submit" name="login" class="btn btn-primary">Connexion</button>
					</div>
				</form>
			</div>
		</div>
<?php
require_once('footer.php');
?>