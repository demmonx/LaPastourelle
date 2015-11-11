<?php
@session_start();
// récupération du titre de la page
$titre = recup_titre("accueil", $_SESSION['lang']);
$titre = isset($titre) ? $titre["texte"]: 'Inconnu';

?>

<div class="clear"></div>
<?php
// Phrase du jour
$phrase = recup_phrasejour($_SESSION['lang']);
if (isset($phrase) && $phrase["valeurtrad"] != "") {
	echo "<marquee scrollAmount=\"4\">Phrase de la semaine : " . $phrase["valeurtrad"] .
         " </marquee>";
}


echo "<CENTER><H1>". $titre ."</H1></CENTER>";

// Actualité
$actu = getActu($_SESSION['lang']);
foreach ($actu as $row) {
    echo "<div class='box grid_6'>";
    $img_actu = $row['img'];
    echo "<img src='" . $img_actu . "'><br /><br />";
    echo "<span class='comment'>" . $row['txt'] . "</span></div>";
}
?>
<div class="clear"></div>
