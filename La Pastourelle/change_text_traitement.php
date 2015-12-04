<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);
$lang = filter_input(INPUT_POST, 'lang', FILTER_VALIDATE_INT);
$page = filter_input(INPUT_POST, 'page', FILTER_VALIDATE_INT);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
$titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);

if (! ($lang && $page && $content && $titre)) {
    exit("Les champs doivent être remplis");
}

setContent($page, $lang, $content, $titre);
exit("Mise à jour réussie");