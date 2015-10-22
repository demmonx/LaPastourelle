<?php
//if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass'])OR !verifLo($_SESSION['pseudo'], $_SESSION['pass'])) {
//	echo "<center>
//			Vous ne pouvez pas accéder à ces pages sans être connecté en tant qu'administrateur<br />
//			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
//		  </center>";
//	//redirect("index.php?page=accueil", 3);
//	echo'
//			<script language="javascript" type="text/javascript">
//				setTimeout("window.location=\'index.php?page=accueil\'", 25);
//			</script>';
//	exit(0);
//} else {
include ("Connection.class.php");
	$bdd = new Connection();
	include ("traitement.inc.php");
	//récupération du membre a supprimer
	$pseudo = $_GET["pseudo"];
	
	//suppression des membres dans la BD et dans l'annuaire
	$rqt_del1 = "DELETE FROM user WHERE pseudo=\"".$pseudo."\"";
	//mysql_query($rqt_del1);
	$rep_del1 = $bdd->select($rqt_del1);
	$rqt_del2 =  "DELETE FROM annuaire WHERE pseudo=\"".$pseudo."\"";
	//mysql_query($rqt_del2);
	$rep_del2 = $bdd->select($rqt_del2);
	//redirect("page_administrateur", 3);
	echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=accueil\'", 3000);
			</script>';
	
//}
?>