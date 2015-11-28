<?php
@session_start();
require_once "traitement.inc.php";
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
    echo "<H2>COMPTE RENDU DE REUNION, D'ASSEMBLEE GENERALE, ...</H2>";
}

// Affichage de chaque compte rendu
if (count($list) == 0) {
    echo "Aucun compte rendu à afficher";
}
foreach ($list as $row) {
    echo " <div>";
    if ($admin) {
        $delete_img = "<a class='delete' href='compte_rendu_traitement.php?ac=1&id=" .
                 $row["id"] . "'><img src='/ressources/images/delete.png'/></a>";
        echo $delete_img . " ";
    }
    echo "Compte rendu du " . date("j-M-Y", strtotime($row['date'])) . " : <button class='spoiler'>Afficher / Masquer</button>
        	<div class='spoiler-hidden' >";
    // Formulaire de modification
    if ($admin) {
        echo "
				  <FORM method='post' action='compte_rendu_traitement.php' class='update'>
					Modifier le compte rendu : <BR>
                    <input type='hidden' value='" .
                 $row["id"] .
                 "' name='id' />
					<textarea class='form-compteRendu' name='content' rows='15' cols='20'>" .
                 stripnl2br2(($row["txt"])) . "</textarea><br />
					<input class='btn' type='submit' value='Modifier'>
				  </FORM>";
    } else {
        echo "
				  <div >" .
                 nl2br(html_entity_decode(decodeREGEX($row["txt"]))) . "</div>";
    }
    echo "</div></div>";
}

?>
<script>
	function refresh() {
		$("#list-cr").load("list_compte_rendu.php");
	}</script>
<script type="text/javascript" src="ressources/js/gest_content.js"></script>
