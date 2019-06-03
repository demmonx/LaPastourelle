<?php
@session_start();
require_once 'inc.function.php';
verifLoginWithArray($_SESSION, 1);

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

if (strlen($lieu) >= 100) {
	exit("Le lieu doit faire moins de 100 caractères");
}

if (strlen($musiciens) >= 150) {
	exit("Les musiciens doivent faire moins de 150 caractères");
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