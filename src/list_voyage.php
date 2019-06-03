<?php
@session_start();
require_once 'inc.function.php';
verifLoginWithArray($_SESSION, 1);

$allVoyage = getVoyage();
// Affichage du drapeau correspondant
if (count($allVoyage) > 0) {
    
    foreach ($allVoyage as $voy) {
        echo "<div>";
        echo "<a class='delete' href='traitement_voyage.php?ac=1&id=" .
                 $voy["id"] . "'><i class='fa fa-close fa-2x'></i></a> ";
        echo $voy["pays"];
        echo " " . $voy["titre"] . " ";
        echo "<span class='spoiler'><i class='fa fa-plus-square-o'></i></span><div class='spoiler-hidden' >";
        // Formulaire de modification
        
        echo "
				  <FORM method='post'  action='traitement_voyage.php' class='update'>
                    <input type='hidden' value='" .
                 $voy["id"] . "' name='id' />
					<textarea name='content' class='editor'>" .
                 nl2br(html_entity_decode($voy["txt"])) . "</textarea><br />
					<input class='btn' type='submit' value='Modifier'>
				  </FORM>";
        echo "</div></div>";
    }
    echo "<br/>";
} else {
    echo "<p>Aucun voyage disponible</p>";
}
?>

<script>
	function refresh() {
		$("#liste-continent").load("list_voyage.php");
	}</script>
<script type="text/javascript" src="ressources/js/gest_content.js"></script>
<script type="text/javascript" src="ressources/js/spoiler.js"></script>