<?php
@session_start();
require_once 'inc.function.php';
require_once 'inc.footer.php';
verifLoginWithArray($_SESSION, 1);
$tab = getMusics();
if (count($tab) == 0) {
    echo "Aucune musique disponible";
    exit(footer());
}
echo "<table class='table table-bordered'>";

echo "<tr>";

echo "<th>Titre</th>";
echo "<th>Artiste</th>";
echo "<th colspan='2'>Statut</th>";
echo "<th>Supprimer</th>";
echo "</tr>";
// mise en forme
foreach ($tab as $row) {
    echo "<tr>";
    
    echo "<td>" . $row["titre"] . "</td>";
    echo "<td>" . $row["groupe"] . "</td>";
    echo "<td>" . ($row["statut"] == 'A' ? "<i class='fa fa-check-circle-o fa-2x'></i>
            		" : "<i class='fa fa-circle-o fa-2x'></i>") .
             "</td>";
    echo "<td><a class='statut' href='traitement_player.php?ac=1&id=" .
             $row["id"] . "'>" .
             ($row["statut"] == 'A' ? "<i class='fa fa-close fa-2x'></i>" : "<i class='fa fa-check fa-2x'></i>") .
             "</a></td>";
    echo "<td><a class='delete' href='traitement_player.php?ac=2&id=" .
             $row["id"] . "'><i class='fa fa-trash fa-2x'></i></a></td>";
    echo "</tr>";
}
echo "</table>";
?>
<script type="text/javascript">
$(document).ready(function () {

	// Rafraichit la liste des music mais pas le player
	function refresh() {
		$("#liste-player-full").load("list_music.php");
		$("#player-content").load("inc.player.php");
	}

	$('.delete').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer la musique selectionnée ?")) {
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

	// Inverse le statut
    $('.statut').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // requete de modification
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
    });
});
</script>