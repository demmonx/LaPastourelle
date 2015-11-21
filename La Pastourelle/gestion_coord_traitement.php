<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once "traitement.inc.php";
if (! isset($_SESSION['pseudo']) || ! isset($_SESSION['pass']) ||
         ! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    exit("Vous n'avez pas les droits requis");
} // else
$tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
$adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_SPECIAL_CHARS);
$mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);

// Cas d'échec
if (! $mail) {
    exit("L'adresse mail est invalide");
}
if (! $tel || ! $mail || ! $adresse) {
    exit("Les champs doivent être remplis");
}
if (strlen($tel) != 10) {
    exit("Le numéro de téléphone doit faire 10 caractères");
}

// Si fichier on l'héberge
if (isset($_FILES["fichier"]) && ! empty($_FILES["fichier"]["name"])) {
    $file = $_FILES["fichier"];
    try {
        // Ajout du fichier sur le serveur
        $image = upload_file("image/coordonnees/", 
                array(
                        "image/png",
                        "image/x-png",
                        "image/jpeg",
                        "image/pjpeg",
                        "image/gif"
                ), $file);
        updateCoor($tel, $adresse, $mail, $image);
    } catch (Exception $e) {
        exit($e->getMessage());
    }
} else { // sinon eon envoie tel quel
    updateCoor($tel, $adresse, $mail);
}
exit("Les informations ont bien été mise à jour");