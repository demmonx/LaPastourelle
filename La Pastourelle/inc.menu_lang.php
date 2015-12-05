<?php
@session_start();
require_once 'inc.function.php';
require_once 'inc.footer.php';

// Récupération de toutes les langues disponibles
$languages = getSupportedLanguagesFull();
// Récupération de la langue courante
$current = getLanguage($_SESSION['lang']);

if (count($current) == 0) {
    exit("<span class='error'>Erreur critique, aucune langue disponible</span>");
}
// Affichage de l'image sans lien
$img = " <img class='img-lang' src='" . $current['img'] . "' alt='" .
         $current["name_en"] . "'  />";

// Affichage de la langue courante sous forme de drapeau
if (count($languages) == 1) {
    echo $img;
} else {
    // Affichage langue courante + menu déroulant
    echo "<div data-toggle='dropdown'>" . $img . "
        <span class='caret'></span></div><ul class='dropdown-menu'>";
    // Affichage des langues dispo sous forme de menu déroulant
    foreach ($languages as $lang) {
        // Construction du lien
        $lien = "index.php?lang=" . $lang['id'];
        
        // On a récupéré une page
        if (isset($_GET['page'])) {
            $lien .= "&page=" . $_GET['page'];
        }
        
        if (isset($_GET['id'])) {
            $lien .= "&id=" . $_GET['id'];
        }
        
        // Chaine à afficher
        $img = " <a href='" . $lien . "' title='" . $lang["name_en"] .
                 "'><img class='img-lang' src='" . $lang['img'] . "' alt='" .
                 $lang["name_en"] . "'  /></a>";
        echo "<li class=''>" . $img . "</li>";
    }
    echo "</ul>";
}
?>