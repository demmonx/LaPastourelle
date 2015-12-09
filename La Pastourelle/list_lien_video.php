<?php
@session_start();
require_once 'inc.function.php';
verifLoginWithArray($_SESSION, 1);
echo "<table class='table table-bordered'>";
$tab = getMedias();
if (count($tab) != 0) {
    
    echo "<tr>";
    
    echo "<th>Nom</th>";
    echo "<th>URL</th>";
    echo "<th></th>";
    echo "</tr>";
    // mise en forme
    foreach ($tab as $row) {
        echo "<tr>";
        
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["url"] . "</td>";
        echo "<td><a class='delete' href='traitement_lien_video.php?ac=1&id=" .
                 $row["id"] . "'><i class='fa fa-trash fa-2x'></i></a></td>";
        echo "</tr>";
    }
} else {
    echo "Aucun lien à afficher";
}
?>
</table>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
        $('#lien-container').load("list_lien_video.php");
	}

	$('.delete').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer l'élément selectionné ?")) {
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