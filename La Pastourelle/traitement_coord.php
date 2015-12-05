<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once "inc.function.php";
verifLoginWithArray($_SESSION, 1);
$tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_SPECIAL_CHARS);
$adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_SPECIAL_CHARS);
$mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
$lat = filter_input(INPUT_POST, 'lat', FILTER_VALIDATE_FLOAT);
$long = filter_input(INPUT_POST, 'long', FILTER_VALIDATE_FLOAT);

// Cas d'échec
if (! $mail) {
    exit("L'adresse mail est invalide");
}
if (! $tel || ! $mail || ! $adresse || ! $lat || ! $long) {
    exit("Les champs doivent être remplis");
}
if (strlen($tel) != 10) {
    exit("Le numéro de téléphone doit faire 10 caractères");
}

if (strlen($mail) >= 100) {
    exit("L'adresse mail doit faire moins de 100 caractères");
}

updateCoor($tel, $adresse, $mail, $lat, $long);
exit("Les informations ont bien été mises à jour");