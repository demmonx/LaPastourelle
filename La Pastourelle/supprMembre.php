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
	include ("traitement.inc.php");
	$bdd = connect_BD_PDO();
	//récupération du membre a supprimer
	$id = $_GET["id"];
	if (!is_numeric($id)) {

		exit("Identifiant invalide");
	}
	
	//suppression des membres dans la BD et dans l'annuaire
	$sql = "DELETE FROM user WHERE id_membre=?";
	$stmt = $bdd->prepare($sql);
	$stmt->bindValue(1, $id, PDO::PARAM_INT);
	$stmt->execute();
	echo "Suppression du membre réussie";
	echo'
			<script language="javascript" type="text/javascript">
				setTimeout("window.location=\'index.php?page=accueil\'", 3000);
			</script>';
	
//}
?>