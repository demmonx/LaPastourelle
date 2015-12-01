<?php
@session_start();
@header ( 'Content-Type: text/html; charset=utf-8' );
require_once 'traitement.inc.php';
verifLoginWithArray ( $_SESSION, 1);
// Teste les entrées
$action = filter_input(INPUT_GET, 'ac', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
if (! (($action && $id) || ($titre && isset($_FILES["fichier"]) && !empty($_FILES["fichier"]["name"])))) {
    exit("Erreur lors de la réalisation de l'action");
}

// else
if ($action) {
    // On met à jour les infos
    switch ($action) {
        case 1:
            if (deleteRevue($id)) {
                exit("Suppression effectuée avec succès");
            } else {
                exit("Erreur lors de la suppression");
            }
            break;
        default:
            exit("L'action selectionnée est invalide");
    }
} // else

if (strlen($titre) >= 100) {
	exit("Le titre doit faire moins de 100 caractères");
}
$file = $_FILES["fichier"];

// On ajoute une diapo
try {
    // Ajout du fichier sur le serveur
    $image = upload_file("image/revue_presse/", 
            array(
                    "image/png",
                    "image/x-png",
                    "image/jpeg",
                    "image/pjpeg",
                    "image/gif"
            ), $file);
    
    // Insertion dans la BD
    if (addRevue($titre, $image)) {
        exit("Ajout effectué avec succès");
    } else {
        exit("Erreur lors de l'ajout");
    }
} catch (Exception $e) {
    exit($e->getMessage());
}