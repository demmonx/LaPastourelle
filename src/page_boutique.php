<?php
@session_start();
require_once 'inc.footer.php';

// Titre
$titre = getTraduction("boutique", $_SESSION['lang']);
if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";
    
    // Si pas de produit dispo
$prod = getBoutique($_SESSION['lang']);
if (count($prod) <= 0) {
    echo "Aucun produit à afficher";
    exit(footer());
}

// Affichage bon de commande
$lang = getLanguage($_SESSION['lang']);
$file = "ressources/bondecommande-fr.pdf";
if (file_exists("ressources/bondecommande-".$lang['code'].".pdf")) {
	$file = "ressources/bondecommande-".$lang['code'].".pdf";
}
echo "<p>Le formulaire d'achat à envoyer par courrier :
         <A HREF='".$file."'
         target='_blank'><button class='btn'>Bon de commande</button></A></p>";

// Affichage liste produits
echo "<table class='table table-bordered'>";
foreach ($prod as $row) {
	if (isset($row['name'])) {
    echo "<tr>";
    echo "<td>" . (isset($row['img']) ? "<img width='50px' height='50px' src='" .
             $row['img'] . "'>" : "") . "</td>";
    echo "<td>" .  $row['name'] . "</td>";
    echo "<td>" . (isset($row['txt']) ? $row['txt'] : "") . "</td>";
    echo "<td>" . (isset($row['prix']) ? number_format($row['prix'], 2, '.', 
            ' ') . " €" : "") . "</td>";
    echo "</tr>";
	}
}
?>
</table>