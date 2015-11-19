<?php
// récupération du titre de la page
$titre = getTraduction("revue_presse_titre", $_SESSION['lang']);
// récupération des revues de presse dans la BD et traitement
$tab_revue = recup_revuePresse();

if (isset($titre["valeurtrad"]))
    echo "<h1>" . $titre["valeurtrad"] . "</h1>";
    
    // si pas de revue
if (count($tab_revue) == 0) {
    echo "Aucune revue à afficher";
}

// Affichage de la liste des revues
foreach ($tab_revue as $revue) {
    echo "<div>";
    echo "<figure>
    <figcaption>" . $revue['titre'] . "</figcaption>        
    <a href='" . $revue['img'] . "' title='Cliquez pour agrandir'>
    <img src='" . $revue['img'] . "' alt='image'/>
    </a>
    </figure>";
    echo "<br /></div><hr />";
}
?>