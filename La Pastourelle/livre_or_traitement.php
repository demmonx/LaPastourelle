<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once ("traitement.inc.php");

if (! (isset($_POST['g-recaptcha-response']) &&  verifCaptcha($_SERVER, $_POST['g-recaptcha-response']))) {
	exit("Code de validation incorrect");
}

$action = filter_input(INPUT_GET, 'ac', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
// Champs non renseignés
if (! ($message && $nom || $id && $action)) {
    exit("Les champs doivent être remplis");
}

/**
 * On traite les suppressions
 */
// else
if ($action) {
    // On vérifie que l'on soit admin
    verifLoginWithArray($_SESSION, 1);
    
    // On met à jour les infos
    switch ($action) {
        case 1:
            if (deleteMessageLivre($id)) {
                exit("Suppression effectuée avec succès");
            } else {
                exit("Erreur lors de la suppression");
            }
            break;
        default:
            exit("L'action selectionnée est invalide");
    }
} // else

// Ajout
addMessageToLivre($nom, $message);
exit("Ajout effectué avec succès");
