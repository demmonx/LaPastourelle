<?php
@session_start();
header('Content-Type: text/html; charset=utf-8');
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);
/*
 * Teste si on a reçu tous les champs, même vide
 * Pour cela, besoin de lister les champs à recevoir
 */
$produit = getProducts();
$langage = getLanguages();
foreach ($produit as $field) {
    foreach ($langage as $lang) {
        if (! (isset($_POST[$field["produit"]][$lang["id"]]['name']) &&
                 isset($_POST[$field["produit"]][$lang["id"]]['desc']))) {
            exit("Au moins un des champs n'a pas été envoyé");
        }
    }
} // else on a tout bien reçu
  // On peut faire la Maj
foreach ($produit as $field) {
    foreach ($langage as $lang) {
        try {
            updateProduct($_POST[$field["produit"]][$lang["id"]]['name'], 
                    $_POST[$field["produit"]][$lang["id"]]['desc'], 
                    $field["produit"], $lang["id"]);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
}

exit("Mise à jour réussie");