<?php
@session_start();

// Titre
$titre = getTraduction("accueil_boutique", $_SESSION['lang']);
if (isset($titre["valeurtrad"]))
    echo "<h1>" . $titre["valeurtrad"] . "</h1>";
echo "Le formulaire d'achat à envoyer par courrier :
         <A class='btn btn-link' HREF='ressources/bondecommande-fr.pdf'
         target='_blank'>Bon de commande</A>";
// Actualité
$prod = getBoutique($_SESSION['lang']);
echo "<table>";
if (count($prod) <= 0) {
    echo "<tr><td>Aucun produit à afficher</td></tr>";
}
foreach ($prod as $row) {
    echo "<tr>";
    echo "<td>" . (isset($row['img']) ? "<img width='50px' height='50px' src='" .
             $row['img'] . "'>" : "") . "</td>";
    echo "<td>" . (isset($row['name']) ? $row['name'] : "") . "</td>";
    echo "<td>" . (isset($row['txt']) ? $row['txt'] : "") . "</td>";
    echo "<td>" . (isset($row['prix']) ? number_format($row['prix'], 2, '.', 
            ' ') . " €" : "") . "</td>";
    echo "</tr>";
}
?>
</table>