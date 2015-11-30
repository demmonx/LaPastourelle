<?php
$test = getVoyage();

if (count($test) <= 0) {
    exit("Aucun continent trouvé".footer());
}
$continent = ""; // Variable utilisée pour savoir si le continent à déjà été
                 // écrit
$pays = ""; // Variable utilisée pour savoir si le pays à déjà été écrit
foreach ($test as $voyage) {
    if ($continent != $voyage["id_continent"]) {
        echo "<strong>" . $voyage["continent"] . " : </strong><br/>";
    }
    
    // Teste si le pays à déjà été écrit
    if ($pays != $voyage["pays"]) {
        echo $voyage["pays"] . " : ";
        echo "<br/>";
    }
    echo "<a href='index.php?page=generic&type=v&id=" . $voyage['id'] . "'>" .
             $voyage['titre'] . "</a>";
    echo "<br/>";
    
    $continent = $voyage["id_continent"];
    $pays = $voyage["pays"];
}