<?php

	require_once ("traitement.inc.php");
		$bdd = new Connection();
	//récupération du membre a supprimer
	$id = $_GET["id"];
	if (!is_numeric($id)) {

		exit("Identifiant invalide");
	}
	
	//suppression des membres dans la BD et dans l'annuaire
	$sql = "DELETE FROM tuser WHERE id_membre=?";
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