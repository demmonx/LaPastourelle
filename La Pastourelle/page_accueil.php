<?php
@session_start();


// Titre
$titre = getTraduction("accueil", $_SESSION['lang']);
if (isset($titre["content"]))
    echo "<h1>" . $titre["content"] . "</h1>";
    
    // Actualité
$actu = getActu($_SESSION['lang']);

// Cas où tous les types ont été supprimés
if (count($actu) == 0) {
    echo "Aucune actualité disponible";
}

// Affichage du slider
echo "<div class='slide-accueil'>";
foreach ($actu as $row) {
    if (isset($row['img'])) {
        echo "<div>";
        echo "<img src='" . $row['img'] . "'><br /><br />";
        echo "<span class='comment'>" .
                 (isset($row['txt']) ? nl2br(html_entity_decode($row['txt'])) : "") .
                 "</span></div>";
    }
}
echo "</div>"?>

<script type="text/javascript">
$(document).ready(function(){
    $('.slide-accueil').slick({
    	  slidesToShow: 1,
    	  slidesToScroll: 1,
    	  autoplay: true,
    	  autoplaySpeed: 5000,
    	  dots: false,
    	  arrows: true
    });	
});
</script>