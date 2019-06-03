<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once ("inc.function.php");

$pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
$pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);
// Champs non renseignés
if (! ($pseudo && $pass)) {
    exit("Les champs doivent être remplis");
}

try {
    $id = getId($pseudo);
    $pass = sha1($pass);
    $info = getMember($id);
    if ($id < 0 || ! password_verify($pass, $info['pass'])) {
        exit("Les informations n'ont pas permises de vous identifier");
    }
    checkLogin($pseudo, $info["pass"], 0);
    $_SESSION['pseudo'] = $pseudo;
    $_SESSION['id'] = $info["id"];
    $_SESSION['pass'] = $info["pass"];
    exit("Vous êtes maintenant connecté sur le site de La Pastourelle de Rodez");
} catch (Exception $e) {
    exit($e->getMessage());
}
