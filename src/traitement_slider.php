<?php
require_once "inc.function.php";
// Teste les entrées
$action = filter_input(INPUT_GET, 'ac', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (! (($action && $id) || (isset($_FILES["fichier"]) && !empty($_FILES["fichier"]["name"])))) {
    exit("Erreur lors de la réalisation de l'action");
}

// else
if ($action) {
    // On met à jour les infos
    switch ($action) {
        case 1:
            if (toggleStatutDiapo($id)) {
                exit("Mise à jour effectuée avec succès");
            } else {
                exit("Erreur lors de la mise à jour");
            }
            break;
        case 2:
            if (deleteDiapo($id)) {
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

// On ajoute une diapo
try {
    // Ajout du fichier sur le serveur
    $image = upload_file("diaporama/", 
            array(
                    "image/png",
                    "image/x-png",
                    "image/jpeg",
                    "image/pjpeg",
                    "image/gif"
            ), $file);
    
    // Redimension après ajout
    $extension = substr(strrchr($image, '.'), 1);
    $dimension = getimagesize($image);
    $coef_l = 380;
    $coef_h = 255;
    if ($extension == 'jpg' || $extension == 'jpeg')
        $chemin = imagecreatefromjpeg($image);
    if ($extension == 'png')
        $chemin = imagecreatefrompng($image);
    if ($extension == 'gif')
        $chemin = imagecreatefromgif($image);
    $nouvelle = imagecreatetruecolor($coef_l, $coef_h);
    imagecopyresampled($nouvelle, $chemin, 0, 0, 0, 0, $coef_l, $coef_h, 
            $dimension[0], $dimension[1]);
    imagejpeg($nouvelle, $image);
    imagedestroy($chemin);
    
    // Insertion dans la BD
    if (insertDiapo($image)) {
        exit("Ajout effectué avec succès");
    } else {
        exit("Erreur lors de l'ajout");
    }
} catch (InvalidArgumentException $e) {
    exit($e->getMessage());
} catch (Exception $e) {
    exit($e->getMessage());
}