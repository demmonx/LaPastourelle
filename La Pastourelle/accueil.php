<?php
// récupération du titre de la page
$titre = recup_titre("accueil");

?>

<div class="clear"></div>
<?php
// Phrase du jour
$phrase = recup_phrasejour();
echo "<marquee scrollAmount=\"4\">Phrase de la semaine : " . $phrase .
         " </marquee>";
echo "<CENTER><H1>$titre</H1></CENTER>";

// Actualité
$actu = getActu($_SESSION['lang']);
foreach ($actu as $row) {
    echo "<div class='box grid_6'>";
    $img_actu = recup_img($row['img'], "actualite");
    echo "<img src='" . $img_actu . "'><br /><br />";
    echo "<span class='comment'>" . $row['txt'] . "</span></div>";
}
?>
<div class="clear"></div>
