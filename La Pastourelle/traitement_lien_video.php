<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once "inc.function.php";
verifLoginWithArray($_SESSION, 1);

$action = filter_input(INPUT_GET, 'ac', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);

/* Cas d'erreur */
if (filter_input(INPUT_POST, 'url', FILTER_SANITIZE_SPECIAL_CHARS) && ! $url) {
    exit("Le lien n'est pas une URL valide");
}
if (! ($nom && $url || $action && $id ))
    exit("Les champs doivent être remplis");


/**
 * On traite la partie ajout
 */
if ($nom) {
	if (strlen($nom) >= 100) {
		exit("Le nom doit faire moins de 100 caractères");
	}
    if (addMedia($nom, $url)) {
        exit("Ajout effectué avec succès");
    } else {
        exit("Une vidéo avec la même URL existe déjà");
    }
}

/**
 * On traite les suppressions
 */
// else
if ($action) {
    // On met à jour les infos
    switch ($action) {
        case 1:
            if (deleteMedia($id)) {
                exit("Suppression effectuée avec succès");
            } else {
                exit("Erreur lors de la suppression");
            }
            break;
        default:
            exit("L'action selectionnée est invalide");
    }
} // else


