<?php
session_start();
require 'traitement.inc.php';
// Vérification si on est admin
if (!verifLoAdmin ( $_SESSION ['pseudo'], $_SESSION ['pass'] )) {
	exit("Vous devez être administrateur pour procéder à la l'ajout d'un évènement");
}

// Regarde si le formulaire est correct
$date = filter_input ( INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS );
$lieu = filter_input ( INPUT_POST, 'lieu', FILTER_SANITIZE_SPECIAL_CHARS );
$nom_jour = filter_input ( INPUT_POST, 'jour', FILTER_SANITIZE_SPECIAL_CHARS );
$musiciens = filter_input ( INPUT_POST, 'musiciens', FILTER_SANITIZE_SPECIAL_CHARS );

if (!$date || !$lieu || !$nom_jour || !$musiciens) {
	exit("Les champs doivent être remplis");
}

// traitement de la date pour l'inserer de la forme aaaa/mm/jj pour pouvoir les classer par date
$morceau_date = explode ( "/", $date );
$jour = $morceau_date [0];
$mois = $morceau_date [1];
$annee = $morceau_date [2];
$date = $annee . "/" . $mois . "/" . $jour;

// Exécution de la l'insertion
$bdd = connect_BD_PDO();
$stmt = $bdd->prepare ( "INSERT INTO planning (pl_jour, pl_date, pl_lieu, pl_musiciens) VALUES (:jour, :date, :lieu, :music)" );
$stmt->bindValue(':jour', $nom_jour);
$stmt->bindValue(':date', $date);
$stmt->bindValue(':lieu', $lieu);
$stmt->bindValue(':music', $musiciens);
$stmt->execute();
exit($stmt ? "Date ajoutée au planning" : "Erreur lors de l'ajout");