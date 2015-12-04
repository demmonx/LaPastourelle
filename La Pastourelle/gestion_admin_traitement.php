<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once "traitement.inc.php";
verifLoginWithArray($_SESSION, 1);

$action = filter_input(INPUT_GET, 'ac', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

/* Cas d'erreur */
if (! ($action && $id))
    exit("L'action choisit n'est pas valide");

if ($_SESSION['id'] == $id) {
    exit("Impossible de modifier ses propres droits");
}
/**
 * On traite les suppressions
 */
// else
if ($action) {
    // On met à jour les infos
    switch ($action) {
        case 1:
            setNiveauMembre($id, 0);
            exit("Le membre a bien été retiré du groupe administrateur");
            break;
        case 2:
            setNiveauMembre($id, 1);
            exit("Le membre a bien été promu administrateur");
            break;
        default:
            exit("L'action selectionnée est invalide");
    }
}