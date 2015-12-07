<?php
$titre = getTraduction("lien", $_SESSION['lang']);
if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";

$liens = getLinks();
if (count($liens) <= 0) {
    echo "Aucun lien à afficher";
}
echo "<table class='table'>";
foreach ($liens as $link) {
  
echo "<tr><td><a href=". $link['url'].">".$link['nom']."</a></td>";
if (!empty($link['img'])) {
echo "<td><a href=". $link['url']."><img class='link' src='". $link['img']."' /></a></td>";
} else {
			echo "<td></td>";
}
echo "</tr>";
}
echo "</table>";