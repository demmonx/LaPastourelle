<?php
@session_start();
require_once 'inc.footer.php';

// Titre
$titre = getTraduction("video", $_SESSION['lang']);
if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";
    
    // Si pas de produit dispo
$vid = getMedias();
if (count($vid) <= 0) {
    echo "Aucune vidéo à afficher";
    exit(footer());
}

// Affichage liste produits
echo "<table class='table'>";
foreach ($vid as $row) {
	if (isset($row['name'])) {
    echo "<tr>";
    echo "<td><a href='".$row['url']."'>" .  $row['name'] . "</a></td>";
    echo "</tr>";
	}
}
?>
</table>