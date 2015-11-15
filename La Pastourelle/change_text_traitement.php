<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once 'traitement.inc.php';
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
         ! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    exit("Vous n'avez pas les droits requis");
} // else
$lang = filter_input(INPUT_POST, 'lang', FILTER_VALIDATE_INT);
$page = filter_input(INPUT_POST, 'page', FILTER_VALIDATE_INT);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

if (! ($lang && $page && $content)) {
    exit("Les champs doivent être remplis");
}

setContent($page, $lang, $content);
exit("Mise à jour réussie");