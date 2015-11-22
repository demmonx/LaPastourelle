<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once ("traitement.inc.php");

$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
$pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
// Champs non renseignés
if (! ($pseudo && $pass)) {
    exit("Les champs doivent être remplis");
}

try {
<<<<<<< Upstream, based on branch 'cyril' of https://github.com/demmonx/LaPastourelle.git
    verifLo($_POST['pseudo'], sha1($_POST['motdepasse']));
    $_SESSION['pseudo'] = $_POST['pseudo'];
    $_SESSION['pass'] = sha1($_POST['motdepasse']);
    $_SESSION['id'] = getId($_POST['pseudo']);
=======
	$pass = sha1($pass);
    checkLogin($pseudo, $pass, 0);
    $_SESSION['pseudo'] = $pseudo;
    $_SESSION['pass'] = $pass;
    $_SESSION['id'] = getId($pseudo);
>>>>>>> 94176de nouveau système de login
    exit(
            "Vous êtes maintenant connecté sur le site de La Pastourelle de Rodez<br /><a href='index.php'>Cliquez-ici pour revenir à l'accueil</a>");
} catch (Exception $e) {
    exit($e->getMessage());
}
