<?php
@session_start();
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);

$allVoyage= getVoyage ();
// Affichage du drapeau correspondant
if (count ( $allVoyage ) > 0) {

	foreach ( $allVoyage as $voy ) {
		echo "<div>";
		echo "<a class='delete' href='admin_logo_traitement.php?ac=1&id=" . $voy ["id"] . "'><img src='/ressources/images/delete.png'/></a>";
		echo " " .$voy ["pays"];
		echo " ". $voy ["titre"]. " ";
		echo "<button class='spoiler'>Afficher / Masquer</button><div class='spoiler-hidden' >";
		// Formulaire de modification

			echo "
				  <FORM method='post'  class='update'>
					Modifier la description : <BR>
                    <input type='hidden' value='" .
		                    $row["id"] .
		                    "' name='id' />
					<textarea name='content' class='editor'>" .
							stripnl2br2(($voy["txt"])) . "</textarea><br />
					<input class='btn' type='submit' value='Modifier'>
				  </FORM>";
		echo "</div></div>";
	}
	echo"<br/>";

} else {
	echo "<br /><br /><b>Aucun voyage disponible</b>";
}
?>

<?php 

?>

<script>
	function refresh() {
		$("#liste-continent").load("liste_voyage.php");
	}</script>
<script type="text/javascript" src="ressources/js/gest_content.js"></script>