<?php
@session_start();
// récupération du titre de la page
$titre = recup_titre("accueil_00", $_SESSION['lang']);
$titre = isset($titre) ? $titre["valeurtrad"] : 'Inconnu';

?>
<div class="clear"></div>
<?php
// Phrase du jour
$phrase = recup_phrasejour($_SESSION['lang']);
if (isset($phrase) && $phrase != "") {
    echo "<marquee scrollAmount=\"4\">Phrase de la semaine : " . $phrase .
             " </marquee>";
}

echo "<CENTER><H1>" . $titre . "</H1></CENTER>";

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
