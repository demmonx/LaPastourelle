<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once "traitement.inc.php";
verifLoginWithArray($_SESSION, 1);

$action = filter_input(INPUT_GET, 'ac', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);

/* Cas d'erreur */
if (! ($nom || $action && $id))
    exit("L'action choisit n'est pas valide");

/**
 * On traite la partie ajout
 */
if ($nom) {
    try {
        addPage($nom);
        exit("Ajout effectué avec succès");
    } catch (Exception $e) {
        exit($e->getMessage());
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
            if (deletePage($id)) {
                exit("Suppression effectuée avec succès");
            } else {
                exit("Erreur lors de la suppression");
            }
            break;
        default:
            exit("L'action selectionnée est invalide");
    }
} // else


