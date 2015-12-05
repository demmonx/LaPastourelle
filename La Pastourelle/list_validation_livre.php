<?php
@session_start();
require_once 'inc.function.php';
verifLoginWithArray($_SESSION, 1);
$messNoValid = getMessageValidationLivre();
if (count($messNoValid) == 0) {
    echo ("Il n'y a aucun message en attente");
} else {
    echo "
	<div id='liens'>
		<table class='table table-bordered' >";
    echo "
			<tr>";
    echo "
				<th>Date</th>
				<th>Nom</th>
				<th>Message</th>
				<th colspan='2'>Gestion</th>";
    echo "
			</tr>";
    foreach ($messNoValid as $row) {
        echo "<tr>";
        echo "<td>" . $row['date'] . "</td><td>" . $row['nom'] . "</td>
				<td>" . nl2br(html_entity_decode($row['message'])) . "</td>";
        echo "<td>";
        echo "<a class='delete' href='traitement_demande.php?id=" . $row['id'] .
                 "&ac=1'><i class='fa fa-check fa-2x'></i></a>";
        echo "</td>";
        echo "<td>";
        echo "<a class='valid' href='traitement_demande.php?id=" . $row['id'] .
                 "&ac=2'><i class='fa fa-close fa-2x'></i></a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "
		</table>
	</div>";
}
?>
<script type="text/javascript">
$(document).ready(function () {

    // Rafraichit la liste des music mais pas le player
    function refresh() {
        $('#container-livre').load("list_validation_livre.php");
    }

    $('.delete').on('click', function (e) {
        e.preventDefault(); // bloque le click sur le lien
        // confirmation
        if (confirm("Supprimer le message selectionné ?")) {
            // requete de suppression
            $.ajax({
                url: $(this).attr("href"),
                type: 'GET',
                success: function (html) { // Récupération de la réponse
                    // recharge la liste des images si ok
                    if (html.search("supprimé") >= 0) {
                        refresh();
                    } else {
                        alert(html);
                    }
                }
            });
        }
    });

        $('.valid').on('click', function (e) {
            e.preventDefault(); // bloque le click sur le lien
            // requete de validation
            $.ajax({
                url: $(this).attr("href"),
                type: 'GET',
                success: function (html) { // Récupération de la réponse
                    // recharge la liste des images si ok
                    if (html.search("validé") >= 0) {
                        refresh();
                    } else {
                        alert(html);
                    }
                }
            });
        });


});
</script>