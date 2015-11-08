<?php
require_once "traitement.inc.php";
// Teste les entrées
$action = filter_input(INPUT_GET, 'ac', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$band = filter_input(INPUT_POST, 'band', FILTER_SANITIZE_SPECIAL_CHARS);
$name = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
if (! (($action && $id) || (isset($_FILES["fichier"])))) {
    exit("Erreur lors de la réalisation de l'action");
}

// else
if ($action) {
    // On met à jour les infos
    switch ($action) {
        case 1:
            if (toggleStatutMusic($id)) {
                exit("Mise à jour effectuée avec succès");
            } else {
                exit("Erreur lors de la mise à jour");
            }
            break;
        case 2:
            if (deleteMusic($id)) {
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

// On ajoute une musique
try {
    // Ajout du fichier sur le serveur
    $path = upload_file("musics/", 
            array(
                    "audio/mpeg",
                    "audio/mp3"
            ), $file);
    
    // Création des champs facultatifs
    $band = isset($band) && $band ? $band : "Inconnu";
    $name = isset($name) && $name ? $name : $_FILES["fichier"]["name"];
    
    // Insertion dans la BD
    if (insertMusic($path, $band, $name)) {
        exit("Ajout effectué avec succès");
    } else {
        exit("Erreur lors de l'ajout");
    }
} catch (InvalidArgumentException $e) {
    exit($e->getMessage());
} catch (Exception $e) {
    exit($e->getMessage());
}