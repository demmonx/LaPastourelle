<?php
@session_start();

?>
<div class="clear"></div>
<?php
// Phrase du jour
$phrase = recup_phrasejour($_SESSION['lang']);
if (isset($phrase) && $phrase != "") {
    echo "<marquee scrollAmount=\"4\">Phrase de la semaine : " . $phrase .
             " </marquee>";
}

// Titre
$titre = getTraduction("accueil_titre", $_SESSION['lang']);
if (isset($titre["valeurtrad"]))
    echo "<h1>" . $titre["valeurtrad"] . "</h1>";
    
    // Actualité
$actu = getActu($_SESSION['lang']);
foreach ($actu as $row) {
    echo "<div class='box grid_6'>";
    $img_actu = $row['img'];
    if (! empty($row['img']))
        echo "<img src='" . $img_actu . "'><br /><br />";
    echo "<span class='comment'>" . (isset($row['txt']) ? $row['txt'] : "") .
             "</span></div>";
}
?>
<div class="clear"></div>
