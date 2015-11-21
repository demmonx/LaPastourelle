<?php
@session_start();

// Phrase du jour
$phrase = getPhraseJour($_SESSION['lang']);
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
echo "<div class='slide-accueil'>";
foreach ($actu as $row) {
    echo "<div>";
    $img_actu = $row['img'];
    if (! empty($row['img']))
        echo "<img src='" . $img_actu . "'><br /><br />";
    echo "<span class='comment'>" . (isset($row['txt']) ? $row['txt'] : "") .
             "</span></div>";
}
echo "</div>"?>


<script type="text/javascript">
$(document).ready(function(){
    $('.slide-accueil').slick({
    	  slidesToShow: 2,
    	  slidesToScroll: 1,
    	  autoplay: true,
    	  autoplaySpeed: 5000,
    	  dots: true
    });	
});
</script>