<?php
if (! isset ( $_SESSION ['pseudo'] ) or ! isset ( $_SESSION ['pass'] ) or ! verifLoAdmin ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
	echo "<center>
			Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur<br />
			Revenir à la page d'accueil : <a class='btn btn-link' href='index.php?page=accueil'>ICI</a>
		  </center>";
	exit ( 0 );
}
require_once 'traitement.inc.php';
// connexion à la base de donnée
$bdd = connect_BD_PDO ();

// récupération du membre a supprimer
$date = $_POST ["date"];
$lieu = $_POST ["lieu"];
$jour = $_POST ["jour"];
$musiciens = $_POST ["musiciens"];
$date_A = $_POST ["date_A"];

$lieu_A = $_POST ["lieu_A"];

// traitement de la date pour l'inserer de la forme aaaa/mm/jj pour pouvoir les classer par date
$morceau_date = explode ( "/", $date );
$jourDate = $morceau_date [0];
$mois = $morceau_date [1];
$annee = $morceau_date [2];
$date = $annee . "/" . $mois . "/" . $jourDate;

$morceau_date = explode ( "/", $date_A );
$jourDate = $morceau_date [0];
$mois = $morceau_date [1];
$annee = $morceau_date [2];
$date_A = $annee . "/" . $mois . "/" . $jourDate;

// MAJ de la BD
$sql = "UPDATE planning SET pl_jour=:jour, pl_musiciens=:music, pl_date=:date, pl_lieu=:lieu
				 WHERE id_planning = :id";
$stmt = $bdd->prepare ( $sql );
$stmt->bindValue ( ":jour", $jour );
$stmt->bindValue ( ":music", $musiciens );
$stmt->bindValue ( ":date", $date );
$stmt->bindValue ( ":lieu", $lieu );
$stmt->bindValue ( ":id_planning", $id );
$stmt->execute ();

echo "<BR><BR><CENTER>Date modifiée<br /><br />";
echo "<a class='btn btn-link' href='index.php?page=planning'>Revenir à la page précédente</a></CENTER>";
?>