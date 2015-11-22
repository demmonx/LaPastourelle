<?php
@session_start();
require_once "traitement.inc.php";
verifLoginWithArray($_SESSION, 1);
  
// Teste les entrées
$action = filter_input(INPUT_GET, 'ac', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
if (! (($action && $id) || ($type && isset($_FILES["fichier"]) && !empty($_FILES["fichier"]["name"])))) {
    exit("Erreur lors de la réalisation de l'action");
}

// else
if ($action) {
    // On met à jour les infos
    switch ($action) {
        case 1:
            if (deleteFile($id)) {
                exit("Suppression effectuée avec succès");
            } else {
                exit("Erreur lors de la suppression");
            }
            break;
        default:
            exit("L'action selectionnée est invalide");
    }
} // else

$file = $_FILES["fichier"];
$supported_type = null;
$folder = null;
// On génère la liste des types pris en charge et le dossier d'upload
switch ($type) {
    case "img":
        $supported_type = array(
                "image/png",
                "image/x-png",
                "image/jpeg",
                "image/pjpeg",
                "image/gif"
        );
        $folder = 'image/';
        break;
    case "video":
        $supported_type = array(
                "video/mpeg",
                "video/mp4",
                "video/quicktime",
                "video/x-ms-wmv",
                "video/x-msvideo",
                "video/x-flv",
                "video/webm"
        );
        $folder = 'video/';
        break;
    default:
        exit("Type de fichier non pris en charge");
}

// On ajoute le fichier
try {
    // Ajout du fichier sur le serveur, on fait un dossier par type
    $content = upload_file($folder, $supported_type, $file);
    
    // Insertion dans la BD
    if (addFile($content)) {
        exit("Ajout effectué avec succès");
    } else {
        exit("Erreur lors de l'ajout");
    }
} catch (Exception $e) {
    exit($e->getMessage());
}