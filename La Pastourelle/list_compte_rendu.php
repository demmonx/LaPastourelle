<?php
@session_start();
require_once "inc.function.php";
verifLoginWithArray($_SESSION, 0);
try {
    $admin = checkLoginWithArray($_SESSION, 0);
} catch (Exception $e) {
    $admin = false;
}
$list = getCompteRendu();
// Affichage du titre
if ($admin) {
    echo '<H2>Compte rendu des réunions précédentes</H2>';
} else {
    echo "<H2>Comptes rendus de réunions, d'assemblées générales, ...</H2>";
}

// Affichage de chaque compte rendu
if (count($list) == 0) {
    echo "Aucun compte rendu à afficher";
}
foreach ($list as $row) {
    echo " <div>";
    if ($admin) {
        $delete_img = "<a class='delete' href='traitement_compte_rendu.php?ac=1&id=" .
                 $row["id"] . "'><i class='fa fa-close fa-2x'></i></a>";
        echo $delete_img . " ";
    }
    echo "Compte rendu du " . date("j-M-Y", strtotime($row['date'])) . " : <span class='spoiler'><i class='fa fa-plus-square-o'></i></span>
        	<div class='spoiler-hidden' >";
    // Formulaire de modification
    if ($admin) {
        echo "
				  <FORM method='post' action='traitement_compte_rendu.php' class='update'>
                    <input type='hidden' value='" . $row["id"] . "' name='id' />
					<textarea class='editor' name='content' >" .
                 nl2br(html_entity_decode($row["txt"])) . "</textarea><br />
					<input class='btn' type='submit' value='Modifier'>
				  </FORM>";
    } else {
        echo "
				  <div >" . nl2br(html_entity_decode($row["txt"])) . "</div>";
    }
    echo "</div></div>";
}

?>
<!-- On appelle la fonction spoiler ici, sinon elle ne trouve pas les éléments -->
<script>
 	function refresh() {
 		$("#list-cr").load("list_compte_rendu.php");
 	}</script>
<script type="text/javascript" src="ressources/js/gest_content.js"></script>
<script type="text/javascript" src="ressources/js/spoiler.js"></script>