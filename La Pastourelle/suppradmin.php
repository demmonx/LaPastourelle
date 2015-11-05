<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accéder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=accueil\'", 3000);
			</script>';
	exit(0);
} else {
	//récupération du membre a supprimer
	$psd = $_GET["psd"];
	
	//suppression des membres dans la BD et dans l'annuaire
	$rqt_user = "DELETE FROM user WHERE pseudo=\"".$psd."\"";
	//mysql_query($rqt_user);
	$rep_user = $bdd->select($rqt_user);
	
	$rqt_annu =  "DELETE FROM annuaire WHERE pseudo=\"".$psd."\"";
	//mysql_query($rqt_annu);
	$rep_annu = $bdd->select($rqt_annu);
	
	redirect("index.php?page=change_admin", 3);
	echo "<BR><BR><CENTER>Administrateur Supprimé</CENTER>";
} ?>