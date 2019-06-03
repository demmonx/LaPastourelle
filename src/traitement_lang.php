<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once "inc.function.php";
verifLoginWithArray($_SESSION, 1);

$action = filter_input(INPUT_GET, 'ac', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$code = filter_input(INPUT_POST, 'lang', FILTER_SANITIZE_SPECIAL_CHARS);

/* Cas d'erreur */
if (! ($action && $id ||
         $code && isset($_FILES["fichier"]) && ! empty(
                $_FILES["fichier"]["name"])))
    exit("L'action choisit n'est pas valide");

/**
 * On traite les suppressions
 */
    // else
if ($action) {
    // On met à jour les infos
    switch ($action) {
        case 1:
            try {
                if (deleteLang($id)) {
                    exit("Suppression effectuée avec succès");
                } else {
                    exit("Erreur lors de la suppression");
                }
            } catch (Exception $e) {
                exit($e->getMessage());
            }
            break;
        default:
            exit("L'action selectionnée est invalide");
    }
} // else

/**
 * On traite l'ajout d'une photo
 */
if ($code) {
    $file = $_FILES["fichier"];
    try {
        // Ajout du fichier sur le serveur
        $image = upload_file("image/lang/", 
                array(
                        "image/png",
                        "image/x-png",
                        "image/jpeg",
                        "image/pjpeg",
                        "image/gif"
                ), $file);
        // Insertion dans la BD
        if (addLang($code, $image)) {
            exit("Ajout effectué avec succès");
        } else {
            exit("Erreur lors de l'ajout");
        }
    } catch (Exception $e) {
        exit($e->getMessage());
    }
}

