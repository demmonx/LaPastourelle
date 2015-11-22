<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
$cryptinstall = "./cryptographp.fct.php";
require_once $cryptinstall;
require_once ("traitement.inc.php");

$action = filter_input(INPUT_GET, 'ac', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);
$code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_SPECIAL_CHARS);
// Champs non renseignés
if (! ($message && $code && $nom || $id && $action)) {
    exit("Les champs doivent être remplis");
}

/**
 * On traite les suppressions
 */
// else
if ($action) {
    // On vérifie que l'on soit admin
    if (! isset($_SESSION['pseudo']) || ! isset($_SESSION['pass']) ||
             ! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
        exit("Vous n'avez pas les droits requis");
    }
    
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
  
// Secure code invalide
if (! chk_crypt($code)) {
    exit("Le code de sécurité est invalide");
}

// Ajout
addMessageToLivre($nom, $message);
exit("Ajout effectué avec succès");
