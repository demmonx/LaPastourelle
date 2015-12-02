<?php
@session_start();
@header('Content-Type: text/html; charset=utf-8');
require_once 'traitement.inc.php';
verifLoginWithArray($_SESSION, 1);
echo "<h2>Liste des contenus disponibles</h2>";
echo "<table class='table table-bordered'><tr><th>Fichier</th><th>Suppression</th></tr>";
$files = getFile();
foreach ($files as $file) {
    echo "<tr>";
    echo "<td><a href='" . $file["adr"] . "' target='blank'>" . $file["adr"] .
             "</a></td>";
    echo "<td><a class='delete' href='gest_content_traitement.php?ac=1&id=" .
             $file["id"] .
             "'><i class='fa fa-close fa-2x'></i></a></td>";
    echo "</tr>";
}
echo "</table>";
?>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
		$("#list-ressources").load("list_file.php");
	}

	$('.delete').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer le fichier selectionné ?")) {
            // requete de suppression
            $.ajax({
                url: $(this).attr("href"),
                type: 'GET',
                success: function (html) { // Récupération de la réponse
                    // recharge la liste des images si ok
                    if (html.search("succès") >= 0) {
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