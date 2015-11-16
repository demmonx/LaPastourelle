<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once 'traitement.inc.php';
if (! isset($_SESSION['pseudo']) or ! isset($_SESSION['pass']) or
         ! verifLoAdmin($_SESSION['pseudo'], $_SESSION['pass'])) {
    exit("Vous n'avez pas les droits requis");
} // else
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
$action = filter_input(INPUT_GET, 'ac', FILTER_SANITIZE_SPECIAL_CHARS);
$id_content = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

if (! ($id && $content || $content && $date || $action && $id_content)) {
    exit("Les champs doivent être remplis");
} // else
  
// mise à jour du contenu
if ($id && $content) {
    setCompteRendu($id, $content);
    exit("Mise à jour réussie");
} // else
  
// Ajout d'un compte rendu
if ($content && $date) {
    
    // traitement de la date pour l'inserer de la forme aaaa/mm/jj pour pouvoir
    // les
    // classer par date
    $morceau_date = explode("/", $date);
    $jourDate = $morceau_date[0];
    $mois = $morceau_date[1];
    $annee = $morceau_date[2];
    $date = $annee . "-" . $mois . "-" . $jourDate;
    
    if (addCompteRendu($content, $date)) {
        exit("Ajout effectué avec succès");
    } else {
        exit("La date n'est pas valide");
    }
}

// LEs suppressions
// else
if ($action) {
    switch ($action) {
        case 1:
            deleteCompteRendu($id_content);
            exit("Suppression effectuée avec succès");
            break;
        default:
            exit("L'action selectionnée est invalide");
    }
} // else