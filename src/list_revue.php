<?php
@session_start();
require_once 'inc.function.php';
verifLoginWithArray($_SESSION, 1);

$tab = getRevuePresse();
if (count($tab) != 0) {
    echo "<table class='table table-bordered'>";
    echo "<tr>";
    
    echo "<th>Titre</th>";
    echo "<th>Supprimer</th>";
    echo "</tr>";
    // mise en forme
    foreach ($tab as $row) {
        echo "<tr>";
        
        echo "<td>" . $row["titre"] . "</td>";
        echo "<td><a class='delete' href='traitement_revue.php?ac=1&id=" .
                 $row["id"] . "'><i class='fa fa-close fa-2x'></i></a></td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "Aucune revue à afficher";
}
?>
</table>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des page
	function refresh() {
        $('#modif-revue').load("list_revue.php");
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