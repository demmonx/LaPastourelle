<?php
@session_start();
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);

$allLang = getLanguages ();
// Affichage du drapeau correspondant
if (count ( $allLang ) > 1) {
	echo '<table><tr><th>Langue</th><th>Action</th></tr>';
	foreach ( $allLang as $lang ) {
		echo "<tr>";
		echo "<td>" . $lang ["name"] . "</td>";
		echo "<td><a class='delete' href='lang_maj_traitement.php?ac=1&id=" . $lang ["id"] . "'><img src='/ressources/images/delete.png'/></a></td>";
		echo "</tr>";
	}
	echo "</table>";
} else {
	echo "<br /><br /><b>Aucune langue à supprimer</b>";
}
?>

<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des langues
	function refresh() {
		$("#liste-lang").load("liste_lang.php");
	}

	$('.delete').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer la langue selectionnée ?")) {
            // requete de suppression
            $.ajax({
                url: $(this).attr("href"),
                type: 'GET',
                success: function (html) { // Récupération de la réponse
                    // recharge la liste des images si ok
                    if (html === "Suppression effectuée avec succès") {
                        refresh();
                    } else {
                        alert(html);
                    }
                    
                }
            });
        }
    });
    
});
</script>