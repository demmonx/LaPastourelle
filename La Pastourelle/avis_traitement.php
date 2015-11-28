<?php
require 'traitement.inc.php';
if (! (isset($_POST['g-recaptcha-response']) &&  verifCaptcha($_SERVER, $_POST['g-recaptcha-response']))) {
	exit("Code de validation incorrect");
}
$nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
$mail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

if (! $mail) {
    exit("L'adresse mail est invalide");
}
if (! $nom || ! $mail || ! $message) {
    exit("Les champs doivent être remplis");
}

sendMail($nom, $mail, $message);
exit("Le message a été envoyé avec succès");