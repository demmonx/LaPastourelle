<?php
@session_start();
require_once 'traitement.inc.php';
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
         ! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    echo "Vous ne pouvez pas accèder à ces pages sans être connecté en tant qu'administrateur";
    exit(0);
}

// récupération du membre a supprimer
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
$lieu = filter_input(INPUT_POST, 'lieu', FILTER_SANITIZE_SPECIAL_CHARS);
$jour = filter_input(INPUT_POST, 'jour', FILTER_SANITIZE_SPECIAL_CHARS);
$musiciens = filter_input(INPUT_POST, 'musiciens', 
        FILTER_SANITIZE_SPECIAL_CHARS);
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (! $date || ! $lieu || ! $jour || ! $musiciens || ! $id) {
    exit("Les champs doivent être remplis");
}

// traitement de la date pour l'inserer de la forme aaaa/mm/jj pour pouvoir les
// classer par date
$morceau_date = explode("/", $date);
$jourDate = $morceau_date[0];
$mois = $morceau_date[1];
$annee = $morceau_date[2];
$date = $annee . "-" . $mois . "-" . $jourDate;

if (setDatePlanning($jour, $musiciens, $date, $lieu, $id)) {
    echo "Mise à jour de l'évènement réussie";
} else {
    echo "La date n'est pas valide";
}
?>