<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once "traitement.inc.php";
verifLoginWithArray($_SESSION, 1);
// récupération des valeurs
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$pays = filter_input(INPUT_POST, 'pays', FILTER_VALIDATE_INT);
$titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
$texte = filter_input(INPUT_POST, 'texte', FILTER_SANITIZE_SPECIAL_CHARS);

if (!($pays && $titre || $id)) {
	exit("Les champs doivent être remplis");
}
/**
 * 	On traite l'ajout d'un voyage.
 */

if ($id == null) {
	if (strlen($titre) >= 100) {
		exit("Le titre doit faire moins de 100 caractères");
	}
if (addVoyage ($pays, $titre, $texte)){
	exit("Ajout effectué avec succès");
} else {
	exit("Erreur lors de l'ajout");
}
}

/**
 * On traite la suppression d'un voyage
 */
if (deleteVoyage ($id)){
	exit("Suppression effectuée avec succès");
} else {
	exit("Erreur lors de la suppression");
}
	

?>