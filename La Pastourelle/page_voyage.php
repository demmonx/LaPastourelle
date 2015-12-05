<?php
$titre = getTraduction("voyage", $_SESSION['lang']);
if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";

$list = getVoyage();

if (count($list) <= 0) {
    echo "Aucun voyage à afficher";
    exit(footer());
}
$continent = ""; // Variable utilisée pour savoir si le continent à déjà été
                 // écrit
$pays = ""; // Variable utilisée pour savoir si le pays à déjà été écrit
foreach ($list as $voyage) {
    if ($continent != $voyage["id_continent"]) {
        if (! empty($continent)) {
            echo "</div>";
        }
        echo "<h2 class='spoiler'>" . $voyage["continent"] .
                 " <i class='fa fa-plus-square-o'></i></h2><div class='spoiler-hidden'>";
    }
    
    // Teste si le pays à déjà été écrit
    if ($pays != $voyage["pays"]) {
        echo "<h3>" . $voyage["pays"] . "</h3>";
        echo "<br/>";
    }
    echo "<a href='index.php?page=page_generic&type=v&id=" . $voyage['id'] . "'>" .
             $voyage['titre'] . "</a>";
    echo "<br/>";
    
    $continent = $voyage["id_continent"];
    $pays = $voyage["pays"];
}
echo "</div>";
?>
<script type="text/javascript" src="ressources/js/spoiler.js"></script>