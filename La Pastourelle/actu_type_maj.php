<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once "traitement.inc.php";
verifLoginWithArray($_SESSION, 1);

$action = filter_input(INPUT_GET, 'ac', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$id_type = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);

/* Cas d'erreur */
if (! ($nom || $action && $id || $id_type && isset($_FILES["fichier"]) && !empty($_FILES["fichier"]["name"])))
    exit("L'action choisit n'est pas valide");

/**
 * On traite la partie ajout
 */
if ($nom) {
    try {
        addActuType($nom);
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
            if (deleteImageActu($id)) {
                exit("Suppression effectuée avec succès");
            } else {
                exit("Erreur lors de la suppression");
            }
            break;
        case 2:
            if (deleteTypeActu($id)) {
                exit("Suppression effectuée avec succès");
            } else {
                exit("Erreur lors de la suppression");
            }
            break;
        default:
            exit("L'action selectionnée est invalide");
    }
} // else

/**
 * On traite l'ajout d'une photo
 */
if ($id_type) {
    $file = $_FILES["fichier"];
    try {
        // Ajout du fichier sur le serveur
        $image = upload_file("image/actualite/", 
                array(
                        "image/png",
                        "image/x-png",
                        "image/jpeg",
                        "image/pjpeg",
                        "image/gif"
                ), $file);
        // Insertion dans la BD
        if (insertImageActu($image, $id_type)) {
            exit("Modification effectué avec succès");
        } else {
            exit("Erreur lors de la modification");
        }
    } catch (Exception $e) {
        exit($e->getMessage());
    }
}

