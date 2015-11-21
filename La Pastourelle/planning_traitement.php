<?php
session_start();
require 'traitement.inc.php';
// Vérification si on est admin
if (! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    exit(
            "Vous devez être administrateur pour procéder à la l'ajout d'un évènement");
}

// Regarde si le formulaire est correct
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
$lieu = filter_input(INPUT_POST, 'lieu', FILTER_SANITIZE_SPECIAL_CHARS);
$nom_jour = filter_input(INPUT_POST, 'jour', FILTER_SANITIZE_SPECIAL_CHARS);
$musiciens = filter_input(INPUT_POST, 'musiciens', 
        FILTER_SANITIZE_SPECIAL_CHARS);
$action = filter_input(INPUT_GET, 'ac', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (! ($date && $lieu && $nom_jour && $musiciens || $action && $id)) {
    exit("Les champs doivent être remplis");
}

/**
 * On traite les suppressions
 */
// else
if ($action) {
    // On met à jour les infos
    switch ($action) {
        case 1:
            if (deleteFromPlanning($id)) {
                exit("Suppression effectuée avec succès");
            } else {
                exit("Erreur lors de la suppression");
            }
            break;
        default:
            exit("L'action selectionnée est invalide");
    }
} // else
  
// traitement de la date pour l'inserer de la forme aaaa/mm/jj pour pouvoir les
  // classer par date
$morceau_date = explode("/", $date);
$jour = $morceau_date[0];
$mois = $morceau_date[1];
$annee = $morceau_date[2];
$date = $annee . "/" . $mois . "/" . $jour;
if (addDatePlanning($nom_jour, $date, $lieu, $musiciens)) {
    exit("Date ajoutée au planning");
} else {
    exit("Erreur lors de l'ajout");
}