<?php
if (!isset($_SESSION['pseudo']) OR !isset($_SESSION['pass']) OR !verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	exit(0);
} else {
	
	//connexion à la base de donnée
	connect_BD();

	//récupération du membre a supprimer
	$date = $_POST["date"];
	$lieu = $_POST["lieu"];
	$jour = $_POST["jour"];
	$musiciens = $_POST["musiciens"];
	$date_A = $_POST["date_A"];;
	$lieu_A = $_POST["lieu_A"];;
	
	//traitement de la date pour l'inserer de la forme aaaa/mm/jj pour pouvoir les classer par date
	$morceau_date = explode ("/", $date);
	$jourDate = $morceau_date[0];
	$mois = $morceau_date[1];
	$annee = $morceau_date[2];
	$date = $annee."/".$mois."/".$jourDate;
	
	$morceau_date = explode ("/", $date_A);
	$jourDate = $morceau_date[0];
	$mois = $morceau_date[1];
	$annee = $morceau_date[2];
	$date_A = $annee."/".$mois."/".$jourDate;
	
	//suppression des membres dans la BD et dans l'annuaire
	$rqt_up = "UPDATE planning SET pl_jour=\"".$jour."\", pl_musiciens=\"".$musiciens."\", pl_date=\"".$date."\", pl_lieu=\"".$lieu."\"
				 WHERE pl_date=\"".$date_A."\" AND pl_lieu=\"".$lieu_A."\"";
	//mysql_query($rqt_up);
	$rep_up = $bdd->select($rqt_up);

	echo "<BR><BR><CENTER>Date modifiée<br /><br />";
	echo "<a class='btn btn-link' href='index.php?page=planning'>Revenir à la page précédente</a></CENTER>";
	exit(0);
}
?>